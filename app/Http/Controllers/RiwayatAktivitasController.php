<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Riwayat;
use App\Models\Pengguna;
use Carbon\Carbon;

class RiwayatAktivitasController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter filter tanggal dari request
        $filterDate = $request->get('filter_date');
        
        // Query dasar untuk riwayat dengan relasi pengguna
        $query = Riwayat::with('pengguna')->orderBy('waktu', 'desc');
        
        // Jika ada filter tanggal, filter berdasarkan tanggal tersebut
        if ($filterDate) {
            try {
                // Parse tanggal dari format yyyy-mm-dd (dari database atau input HTML date)
                $date = Carbon::parse($filterDate);
                
                // Filter hanya aktivitas pada tanggal yang dipilih
                $query->whereDate('waktu', $date->format('Y-m-d'));
                
                // Ambil data yang sudah difilter
                $riwayat = $query->get();
                
                // Untuk tanggal yang difilter, semua data masuk ke grup "Hari yang dipilih"
                return view('petugas.riwayat', [
                    'today' => $date->translatedFormat('l, d F Y'),
                    'yesterday' => '',
                    'previousDay' => '',
                    'todayActivities' => $riwayat,
                    'yesterdayActivities' => collect(), // kosong
                    'previousActivities' => collect(), // kosong
                    'isFiltered' => true,
                    'filterDate' => $filterDate
                ]);
                
            } catch (\Exception $e) {
                // Jika format tanggal salah, tampilkan semua data
                $riwayat = $query->get();
            }
        } else {
            // Jika tidak ada filter, ambil semua data
            $riwayat = $query->get();
        }
        
        // Kelompokkan berdasarkan waktu (logika asli)
        $todayActivities = $riwayat->filter(function ($item) {
            return Carbon::parse($item->waktu)->timezone('Asia/Jakarta')->isToday();
        });
        
        $yesterdayActivities = $riwayat->filter(function ($item) {
            return Carbon::parse($item->waktu)->timezone('Asia/Jakarta')->isYesterday();
        });
        
        $previousActivities = $riwayat->filter(function ($item) {
            return Carbon::parse($item->waktu)->timezone('Asia/Jakarta')->isBefore(Carbon::yesterday());
        });
        
        return view('petugas.riwayat', [
            'today' => now()->timezone('Asia/Jakarta')->translatedFormat('l, d F Y'),
            'yesterday' => now()->timezone('Asia/Jakarta')->subDay()->translatedFormat('l, d F Y'),
            'previousDay' => 'Sebelumnya',
            'todayActivities' => $todayActivities,
            'yesterdayActivities' => $yesterdayActivities,
            'previousActivities' => $previousActivities,
            'isFiltered' => false,
            'filterDate' => null
        ]);
    }
    
    /**
     * Method untuk AJAX request filter tanggal (opsional)
     */
    public function filterByDate(Request $request)
    {
        $filterDate = $request->get('date');
        
        if (!$filterDate) {
            return response()->json(['error' => 'Tanggal tidak valid'], 400);
        }
        
        try {
            // Parse tanggal dari format yyyy-mm-dd (standar database/HTML date input)
            $date = Carbon::parse($filterDate);
            
            // Ambil aktivitas pada tanggal tersebut
            $activities = Riwayat::with('pengguna')
                ->whereDate('waktu', $date->format('Y-m-d'))
                ->orderBy('waktu', 'desc')
                ->get();
            
            // Format data untuk response
            $formattedActivities = $activities->map(function ($activity) {
                return [
                    'id' => $activity->id,
                    'aksi' => $activity->aksi,
                    'tabel' => $activity->tabel,
                    'keterangan' => $activity->keterangan,
                    'username' => $activity->pengguna->username,
                    'waktu' => Carbon::parse($activity->waktu)->diffForHumans(),
                    'waktu_raw' => $activity->waktu,
                    'tanggal' => Carbon::parse($activity->waktu)->format('Y-m-d')
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => $formattedActivities,
                'count' => $activities->count(),
                'date_label' => $date->translatedFormat('l, d F Y')
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Format tanggal tidak valid'], 400);
        }
    }
}