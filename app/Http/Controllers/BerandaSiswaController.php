<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Diperlukan untuk transaksi database
use Illuminate\Support\Facades\Log; // Tetap diperlukan untuk logging error
use Carbon\Carbon; // Tetap diperlukan untuk tanggal peminjaman

class BerandaSiswaController extends Controller
{
    /**
     * Menampilkan daftar buku di beranda siswa.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $buku = Buku::all();

        foreach ($buku as $item) {
            // Jika ada path gambar dari DB dan file fisik ada, gunakan path tersebut.
            // Jika tidak, gunakan gambar default.
            if (!empty($item->gambar) && is_string($item->gambar) && file_exists(public_path($item->gambar))) {
                $item->gambar_url = asset($item->gambar);
            } else {
                $item->gambar_url = asset('images/default-book.png');
            }
        }

        $kategoriOptions = ['Pelajaran', 'Fiksi', 'Non Fiksi'];
        $kelasOptions = range(1, 6);

        return view('siswa.beranda', [
            'buku' => $buku,
            'kategoriOptions' => $kategoriOptions,
            'kelasOptions' => $kelasOptions
        ]);
    }

    /**
     * Memproses permintaan peminjaman buku oleh siswa.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function pinjamBuku(Request $request)
    {
        try {
            $pengguna = Auth::user();

            if (!$pengguna || $pengguna->role !== 'siswa') {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda harus login sebagai siswa untuk meminjam buku.'
                ], 401);
            }

            // Memuat relasi 'siswa' untuk mendapatkan data siswa terkait.
            $pengguna->load('siswa');
            $siswa = $pengguna->siswa;

            $nisSiswa = $siswa->nis_siswa ?? null;

            if (!$siswa || empty($nisSiswa)) {
                Log::error('Data NIS siswa tidak ditemukan pada relasi siswa.', [
                    'id_user_pengguna' => $pengguna->id_user ?? 'N/A'
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
            // Menggunakan lockForUpdate() untuk mencegah race condition saat mengurangi stok.
            $buku = Buku::where('isbn', $bukuIdentifier)->lockForUpdate()->first();

            if (!$buku) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Buku tidak ditemukan.'
                ], 404);
            }

            if ($buku->stok < 1) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Stok buku tidak tersedia.'
                ], 400);
            }

            // Memeriksa apakah siswa sudah meminjam buku ini.
            $existingPinjaman = Peminjaman::where('nis_siswa', $nisSiswa)
                ->where('isbn', $buku->isbn)
                ->where('status_peminjaman', 'Dipinjam')
                ->first();

            if ($existingPinjaman) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah meminjam buku ini.'
                ], 409);
            }

            $namaSiswa = $siswa->nama_lengkap ?? $pengguna->username ?? 'Siswa';

            Peminjaman::create([
                'nis_siswa' => $nisSiswa,
                'nama_siswa' => $namaSiswa,
                'isbn' => $buku->isbn,
                'judul' => $buku->judul,
                'tanggal_peminjaman' => Carbon::now()->format('Y-m-d H:i:s'),
                'tanggal_pengembalian' => null,
                'status_peminjaman' => 'proses'
            ]);

            $buku->decrement('stok'); // Mengurangi stok buku

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Buku berhasil dipinjam.',
                'data' => [
                    'new_stock' => $buku->fresh()->stok // Mengambil stok terbaru setelah decrement
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('Validation error saat meminjam buku:', $e->errors());
            $errorMessage = collect($e->errors())->flatten()->implode(', ');
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
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi nanti.'
            ], 500);
        }
    }
}