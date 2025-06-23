<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Riwayat;
use Carbon\Carbon;
use App\Models\Pengguna;
use App\Helpers\RiwayatHelper;
class BerandaPetugasController extends Controller
{
   public function index()
{
    $riwayat = Riwayat::with('pengguna')
                ->whereDate('waktu', today())
                ->orderBy('waktu', 'desc')
                ->get();
    return view('petugas.beranda', [
        'today' => now()->translatedFormat('l, d F Y'),
        'todayActivities' => $riwayat,
    ]);
    }
}