<?php
namespace App\Http\Controllers;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Models\Riwayat;
use Carbon\Carbon;
use App\Models\Pengguna;
use App\Helpers\RiwayatHelper;
use Illuminate\Support\Facades\DB;
use App\Models\Siswa;

class BerandaPetugasController extends Controller
{
   public function index()
    {
        $totalBuku = Buku::count();

        $bukuDipinjam = Peminjaman::where('status_peminjaman', 'Dipinjam')->count();

        $bukuDikembalikan = Peminjaman::where('status_peminjaman', 'Dikembalikan')->count();
        
        $riwayat = Riwayat::with('pengguna')
                    ->whereDate('waktu', today())
                    ->orderBy('waktu', 'desc')
                    ->get();

        // Mengambil data peminjam terbanyak
        $peminjamTerbanyak = Peminjaman::select('nis_siswa', DB::raw('count(*) as total_peminjaman'))
                                    ->with(['siswa' => function($query) {
                                        $query->select('nis_siswa', 'nama_siswa', 'kelas_siswa');
                                    }])
                                    ->groupBy('nis_siswa')
                                    ->orderBy('total_peminjaman', 'desc')
                                    ->limit(3)
                                    ->get();

        return view('petugas.beranda', [
            'today' => now()->translatedFormat('l, d F Y'),
            'todayActivities' => $riwayat,
            'totalBuku' => $totalBuku,
            'bukuDipinjam' => $bukuDipinjam,
            'bukuDikembalikan' => $bukuDikembalikan,
            'peminjamTerbanyak' => $peminjamTerbanyak,
        ]);
    }
}