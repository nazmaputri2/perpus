<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Http\Request;

class StatistikController extends Controller
{
     public function statistik(Request $request)
    {
        $keanggotaan = $request->input('keanggotaan');
        $bulan = $request->input('bulan');
        $search = $request->input('search'); // Tambahan: input pencarian

        $daftarKeanggotaan = DB::table('anggota')
            ->select('keanggotaan')
            ->distinct()
            ->orderBy('keanggotaan')
            ->pluck('keanggotaan');

        // Mapping nama bulan Indonesia ke angka
        $bulanMap = [
            'januari' => '01', 'februari' => '02', 'maret' => '03',
            'april' => '04', 'mei' => '05', 'juni' => '06',
            'juli' => '07', 'agustus' => '08', 'september' => '09',
            'oktober' => '10', 'november' => '11', 'desember' => '12',
        ];

        $query = DB::table('peminjaman')
            ->join('anggota', 'peminjaman.no_anggota', '=', 'anggota.no_anggota')
            ->select('anggota.nama_anggota', 'anggota.keanggotaan', 'anggota.no_anggota', DB::raw('COUNT(*) as jumlah'))
            ->where('peminjaman.status_peminjaman', '!=', 'Proses')
            ->groupBy('anggota.nama_anggota', 'anggota.keanggotaan', 'anggota.no_anggota');

        if ($keanggotaan) {
            $query->where('anggota.keanggotaan', $keanggotaan);
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

        if ($keanggotaan) {
            $statQuery->join('anggota', 'peminjaman.no_anggota', '=', 'anggota.no_anggota')
                ->where('anggota.keanggotaan', $keanggotaan);
        }

        if ($bulanAngka) {
            $statQuery->whereMonth('tanggal_peminjaman', $bulanAngka);
        }

        $all = (clone $statQuery)->where('status_peminjaman', 'Dikembalikan')->count();
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
            'peminjamTerbanyak', 'keanggotaan', 'bulan', 'search', 'stats', 'daftarKeanggotaan'
        ));
    }

}
