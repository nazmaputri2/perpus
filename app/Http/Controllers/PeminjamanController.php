<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Siswa;
use App\Models\Peminjaman;
use App\Models\Pengguna; // Tambahkan ini jika model Pengguna digunakan untuk petugas
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan id_petugas yang login

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $buku = Buku::all();
        $siswa = Siswa::select('nis_siswa', 'nama_siswa', 'kelas_siswa')->orderBy('kelas_siswa')->orderBy('nama_siswa')->get();
        $kategoriOptions = Buku::select('jenis_buku')->distinct()->pluck('jenis_buku')->filter()->sort()->values()->all();
        $kelasOptions = Buku::select('kelas')->distinct()->pluck('kelas')->filter()->sort()->values()->all();

        return view('petugas.koleksibuku', compact('buku', 'siswa', 'kategoriOptions', 'kelasOptions'));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'isbn_buku' => 'required|string|exists:buku,isbn', // Validasi input yang masuk
                'nis_siswa' => 'required|string|exists:siswa,nis_siswa',
            ]);

            $buku = Buku::where('isbn', $validatedData['isbn_buku'])->first();
            $siswa = Siswa::where('nis_siswa', $validatedData['nis_siswa'])->first();

            if (!$buku) {
                return response()->json(['success' => false, 'message' => 'Buku tidak ditemukan.'], 404);
            }
            if (!$siswa) {
                return response()->json(['success' => false, 'message' => 'Siswa tidak ditemukan.'], 404);
            }

            if ($buku->stok <= 0) {
                return response()->json(['success' => false, 'message' => 'Stok buku ini tidak tersedia.'], 400);
            }

            // Dapatkan ID petugas yang sedang login
            // Asumsi model Auth::user() adalah Pengguna dan memiliki kolom 'id_user' sebagai primary key.
            // Atau jika primary key nya 'id', gunakan Auth::id()
            $idUser = Auth::user()->id_user ?? Auth::id(); 
            
            // Cek apakah id_petugas tersedia. Jika tidak, mungkin user belum login atau sesi bermasalah.
            if (!$idUser) {
                return response()->json(['success' => false, 'message' => 'Petugas tidak terautentikasi atau ID tidak ditemukan.'], 401);
            }

            DB::beginTransaction();

            // Kurangi stok buku
            $buku->decrement('stok');

            // Buat entri peminjaman
            Peminjaman::create([
                'isbn' => $buku->isbn, // *** PERUBAHAN PENTING DI SINI: GUNAKAN 'isbn' BUKAN 'isbn_buku' ***
                'nis_siswa' => $siswa->nis_siswa,
                'tanggal_peminjaman' => now(),
                'tanggal_pengembalian' => now()->addDays(14),
                'status_peminjaman' => 'Dipinjam', // Status awal, sesuai enum di migrasi
                'id_user' => $idUser, 
            ]);

            DB::commit();

            catatRiwayat('peminjaman', 'meminjam', 'Petugas meminjamkan buku "' . $buku->judul . '" kepada siswa: ' . $siswa->nama_siswa);

            return response()->json([
                'success' => true,
                'message' => 'Peminjaman berhasil dicatat!',
                'new_stok' => $buku->stok // Kirim stok terbaru
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Data validasi tidak sesuai.', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error during book borrowing: ' . $e->getMessage(), [
                'isbn_buku_received' => $request->isbn_buku, // Log input yang diterima
                'nis_siswa_received' => $request->nis_siswa,
                'error_line' => $e->getLine(),
                'error_file' => $e->getFile(),
                'stack_trace' => $e->getTraceAsString(), // Tambahkan stack trace lengkap
            ]);
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan server saat mencatat peminjaman. Silakan coba lagi. Detail error telah dicatat.'], 500);
        }
    }
}