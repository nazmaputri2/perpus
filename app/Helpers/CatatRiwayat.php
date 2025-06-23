<?php
use App\Models\Riwayat;
use Illuminate\Support\Facades\Auth;
if (!function_exists('catatRiwayat')) {
    function catatRiwayat($tabel, $aksi, $keterangan) {
        if (Auth::check()) {
            Riwayat::create([
                'id_user' => Auth::id(), // ✅ hanya ID
                'tabel' => $tabel,
                'aksi' => $aksi,
                'keterangan' => $keterangan,
                'waktu' => now('Asia/Jakarta'),
            ]);
        }
    }
}