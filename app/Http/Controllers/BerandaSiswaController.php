<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class BerandaSiswaController extends Controller
{
    public function index()
    {
        $buku = Buku::all();

        foreach ($buku as $item) {
            // --- LOGGING UNTUK DEBUGGING ---
            Log::info("--- Processing Book: {$item->judul} (ISBN: {$item->isbn}) ---");
            Log::info("  1. Value of \$item->gambar from DB: '{$item->gambar}'"); // Path dari DB, misal: /storage/images/buku/abc.png

            $gambarPathFromDb = $item->gambar;

            // Logika untuk memeriksa keberadaan file fisik di 'storage/app/public/'
            // Kita perlu menghapus '/storage/' dari awal path untuk fungsi file_exists()
            $cleanPathForFileExists = '';
            if (!empty($gambarPathFromDb) && is_string($gambarPathFromDb)) {
                // Cek apakah path dari DB dimulai dengan '/storage/'
                if (str_starts_with($gambarPathFromDb, '/storage/')) {
                    $cleanPathForFileExists = substr($gambarPathFromDb, 9); // Hapus '/storage/' (9 karakter)
                } else {
                    // Jika tidak dimulai dengan '/storage/', asumsikan itu sudah path relatif dari public disk
                    $cleanPathForFileExists = $gambarPathFromDb;
                }
            }

            $fullStoragePath = storage_path('app/public/' . $cleanPathForFileExists);
            Log::info("  2. Full expected path for file_exists(): '{$fullStoragePath}'");

            if (!empty($cleanPathForFileExists) && file_exists($fullStoragePath)) {
                // Jika file ditemukan, gunakan path asli dari database (yang sudah ada /storage/)
                // Fungsi asset() akan menangani path /storage/ dengan benar melalui symlink.
                $item->gambar_url = asset($gambarPathFromDb);
                Log::info("  3. File FOUND. Generated public URL: '{$item->gambar_url}'");
            } else {
                // Jika $item->gambar kosong, bukan string, atau file tidak ditemukan
                $item->gambar_url = asset('images/default-book.png'); // Fallback ke default
                Log::warning("  3. File NOT FOUND or \$item->gambar invalid. Using default image. (Checked path: '{$fullStoragePath}')");
            }
            Log::info("--------------------------------------------------");
        }

        $kategoriOptions = ['Pelajaran', 'Fiksi', 'Non Fiksi'];
        $kelasOptions = range(1, 6);

        return view('siswa.beranda', [
            'buku' => $buku,
            'kategoriOptions' => $kategoriOptions,
            'kelasOptions' => $kelasOptions
        ]);
    }

    public function pinjamBuku(Request $request)
    {
        try {
            Log::info('Pinjam buku request:', $request->all());

            $pengguna = Auth::user();

            if (!$pengguna || $pengguna->role !== 'siswa') {
                Log::error('Pengguna tidak terautentikasi atau bukan siswa saat mencoba meminjam buku.');
                return response()->json([
                    'success' => false,
                    'message' => 'Anda harus login sebagai siswa untuk meminjam buku.'
                ], 401);
            }

            $pengguna->load('siswa');
            $siswa = $pengguna->siswa;

            Log::info('Data pengguna yang mencoba pinjam:', [
                'id_user' => $pengguna->id_user,
                'username' => $pengguna->username,
                'role' => $pengguna->role,
                'siswa_data_from_relation' => $siswa ? $siswa->toArray() : null
            ]);

            $nisSiswa = $siswa->nis_siswa ?? null;

            if (!$siswa || empty($nisSiswa)) {
                Log::error('Data NIS siswa tidak ditemukan pada relasi siswa:', [
                    'id_user_pengguna' => $pengguna->id_user ?? 'N/A',
                    'siswa_relasi_status' => $siswa ? 'Ditemukan' : 'Tidak Ditemukan',
                    'nis_siswa_value_check' => $nisSiswa ?? 'NULL/Kosong'
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Data NIS siswa tidak lengkap. Hubungi administrator.'
                ], 400);
            }

            $request->validate([
                'buku_id' => 'required|exists:buku,isbn'
            ]);

            DB::beginTransaction();

            $bukuIdentifier = $request->buku_id;
            $buku = Buku::where('isbn', $bukuIdentifier)->lockForUpdate()->first();

            if (!$buku) {
                DB::rollBack();
                Log::error('Buku tidak ditemukan dengan ISBN: ' . $bukuIdentifier);
                return response()->json([
                    'success' => false,
                    'message' => 'Buku tidak ditemukan'
                ], 404);
            }

            if ($buku->stok < 1) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Stok buku tidak tersedia'
                ], 400);
            }

            Log::info('Data siswa yang akan digunakan untuk peminjaman:', [
                'id_user_pengguna' => $pengguna->id_user,
                'username_pengguna' => $pengguna->username,
                'nis_siswa_final' => $nisSiswa,
            ]);

            $existingPinjaman = Peminjaman::where('nis_siswa', $nisSiswa)
                ->where('isbn', $buku->isbn)
                ->where('status_peminjaman', 'Dipinjam')
                ->first();

            if ($existingPinjaman) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah meminjam buku ini'
                ], 409);
            }

            $namaSiswa = $siswa->nama_lengkap ?? $pengguna->username ?? 'Siswa';

            $peminjaman = Peminjaman::create([
                'nis_siswa' => $nisSiswa,
                'nama_siswa' => $namaSiswa,
                'isbn' => $buku->isbn,
                'judul' => $buku->judul,
                'tanggal_peminjaman' => Carbon::now()->format('Y-m-d H:i:s'),
                'tanggal_pengembalian' => null,
                'status_peminjaman' => 'Dipinjam'
            ]);

            Log::info('Peminjaman berhasil dibuat:', $peminjaman->toArray());

            $buku->decrement('stok');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Buku berhasil dipinjam',
                'data' => [
                    'peminjaman_id' => $peminjaman->id_peminjaman,
                    'tanggal_peminjaman' => $peminjaman->tanggal_peminjaman,
                    'new_stock' => $buku->fresh()->stok
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('Validation error saat meminjam buku:', $e->errors());
            $errorMessage = implode(', ', array_map(function($messages) {
                return implode(', ', $messages);
            }, $e->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid: ' . $errorMessage
            ], 422);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Terjadi kesalahan sistem saat meminjam buku:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_data' => $request->all(),
                'user_data' => Auth::user() ? Auth::user()->toArray() : null
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }
}