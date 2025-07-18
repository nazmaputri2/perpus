<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Http\Request;

class StatistikController extends Controller
{
     public function statistik(Request $request)
    {
        $kelas = $request->input('kelas');
        $bulan = $request->input('bulan');
        $search = $request->input('search'); // Tambahan: input pencarian

        $daftarKelas = DB::table('siswa')
            ->select('kelas_siswa')
            ->distinct()
            ->orderBy('kelas_siswa')
            ->pluck('kelas_siswa');

        // Mapping nama bulan Indonesia ke angka
        $bulanMap = [
            'januari' => '01', 'februari' => '02', 'maret' => '03',
            'april' => '04', 'mei' => '05', 'juni' => '06',
            'juli' => '07', 'agustus' => '08', 'september' => '09',
            'oktober' => '10', 'november' => '11', 'desember' => '12',
        ];

        $query = DB::table('peminjaman')
            ->join('siswa', 'peminjaman.nis_siswa', '=', 'siswa.nis_siswa')
            ->select('siswa.nama_siswa', 'siswa.kelas_siswa', 'siswa.nis_siswa', DB::raw('COUNT(*) as jumlah'))
            ->where('peminjaman.status_peminjaman', '!=', 'Proses')
            ->groupBy('siswa.nama_siswa', 'siswa.kelas_siswa', 'siswa.nis_siswa');

        if ($kelas) {
            $query->where('siswa.kelas_siswa', $kelas);
        }

        $bulanAngka = null;
        if ($bulan) {
            $bulanLower = strtolower($bulan);
            $bulanAngka = $bulanMap[$bulanLower] ?? null;

            if ($bulanAngka) {
                $query->whereMonth('tanggal_peminjaman', $bulanAngka);
            }
        }

        // Tambahkan pencarian nama atau NIS
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('siswa.nama_siswa', 'like', '%' . $search . '%')
                  ->orWhere('siswa.nis_siswa', 'like', '%' . $search . '%');
            });
        }

        $peminjamTerbanyak = $query->orderByDesc('jumlah')->limit(10)->get();

        // Hitung statistik total
        $statQuery = DB::table('peminjaman')
            ->where('status_peminjaman', '!=', 'Proses');

        if ($kelas) {
            $statQuery->join('siswa', 'peminjaman.nis_siswa', '=', 'siswa.nis_siswa')
                ->where('siswa.kelas_siswa', $kelas);
        }

        if ($bulanAngka) {
            $statQuery->whereMonth('tanggal_peminjaman', $bulanAngka);
        }

        $all = $statQuery->count();
        $dipinjam = (clone $statQuery)->where('status_peminjaman', 'Dipinjam')->count();
        $terlambat = (clone $statQuery)->where('status_peminjaman', 'Terlambat')->count();
        $selesaiHariIni = (clone $statQuery)
            ->where('status_peminjaman', 'Dikembalikan')
            ->whereDate('peminjaman.updated_at', Carbon::today())
            ->count();

        $stats = [
            'total' => $all,
            'dipinjam' => $dipinjam,
            'terlambat' => $terlambat,
            'selesaiHariIni' => $selesaiHariIni,
        ];

        return view('petugas.statistik', compact(
            'peminjamTerbanyak', 'kelas', 'bulan', 'search', 'stats', 'daftarKelas'
        ));
    }

}
