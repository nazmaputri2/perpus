<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Riwayat;
use App\Models\Pengguna;
use Carbon\Carbon;
class RiwayatAktivitasController extends Controller
{
public function index()
    {
        // Ambil semua riwayat terbaru dan relasi pengguna
        $riwayat = Riwayat::with('pengguna')
    ->orderBy('waktu', 'desc')
    ->get();
        // Kelompokkan berdasarkan waktu
       $todayActivities = $riwayat->filter(function ($item) {
    return Carbon::parse($item->waktu)->timezone('Asia/Jakarta')->isToday();
});
        $yesterdayActivities = $riwayat->filter(function ($item) {
            return Carbon::parse($item->waktu)->isYesterday();
        });
        $previousActivities = $riwayat->filter(function ($item) {
            return Carbon::parse($item->waktu)->isBefore(Carbon::yesterday());
        });
        return view('petugas.riwayat', [
            'today' => now()->translatedFormat('l, d F Y'),
            'yesterday' => now()->subDay()->translatedFormat('l, d F Y'),
            'previousDay' => 'Sebelumnya',
            'todayActivities' => $todayActivities,
            'yesterdayActivities' => $yesterdayActivities,
            'previousActivities' => $previousActivities
        ]);
        }
}
