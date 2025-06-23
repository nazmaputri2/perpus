<?php

        namespace App\Http\Controllers;

        use Illuminate\Http\Request;
        use App\Models\Peminjaman;
        use Illuminate\Support\Facades\DB;
        use Carbon\Carbon;
        use App\Models\Buku;
        use App\Models\Siswa;

        class DataPeminjamanController extends Controller
        {
           protected function tandaiTerlambatOtomatis()
{
    $terlambat = Peminjaman::where('status_peminjaman', 'Dipinjam')
        ->whereDate(DB::raw('DATE_ADD(tanggal_peminjaman, INTERVAL 14 DAY)'), '<', now())
        ->get();

    foreach ($terlambat as $pinjam) {
        $pinjam->update(['status_peminjaman' => 'Terlambat']);
    }
}


            public function index()
            {
                // Jalankan sistem penanda otomatis
                $this->tandaiTerlambatOtomatis();

                $peminjaman = Peminjaman::with(['siswa', 'buku'])->latest()->get();

                $stats = [
                    'total' => $peminjaman->count(),
                    'dipinjam' => $peminjaman->where('status_peminjaman', 'Dipinjam')->count(),
                    'terlambat' => $peminjaman->where('status_peminjaman', 'Terlambat')->count(),
                    'selesaiHariIni' => $peminjaman->where('status_peminjaman', 'Dikembalikan')->where('updated_at', '>=', now()->startOfDay())->count(),
                ];

                return view('petugas.datapeminjaman', compact('peminjaman', 'stats'));
            }

public function updateStatus(Request $request, $id)
{
    $peminjaman = Peminjaman::findOrFail($id);
    $aksi = $request->input('aksi');

     $buku = $peminjaman->buku;
    $siswa = $peminjaman->siswa;

    if ($aksi === 'setujui') {
        $peminjaman->status_peminjaman = 'Dipinjam';

         catatRiwayat('peminjaman', 'menyetujui', 'Menyetujui peminjaman buku "' . $buku->judul . '" oleh siswa: ' . $siswa->nama_siswa);

    } elseif ($aksi === 'selesai') {
        $peminjaman->status_peminjaman = 'Dikembalikan';
        $peminjaman->tanggal_pengembalian = now();

        // Hitung batas waktu pengembalian
        $batasKembali = Carbon::parse($peminjaman->tanggal_peminjaman)->addDays(14);
$selisihHari = Carbon::parse($peminjaman->tanggal_pengembalian)->diffInDays($batasKembali, false);
$hariTerlambat = abs(floor($selisihHari));

       if ($selisihHari < 0) {
    $peminjaman->keterangan = 'Terlambat dikembalikan (' . $hariTerlambat . ' hari)';
} else {
    $peminjaman->keterangan = null;
}

        // Tambah stok
        $buku = $peminjaman->buku;
        if ($buku) {
            $buku->stok += 1;
            $buku->save();
        }

         catatRiwayat('peminjaman', 'mengembalikan', 'Menyelesaikan peminjaman buku "' . $buku->judul . '" oleh siswa: ' . $siswa->nama_siswa);


    } elseif ($aksi === 'batal') {
        if (in_array($peminjaman->status_peminjaman, ['Dipinjam', 'Terlambat'])) {
            $buku = $peminjaman->buku;
            if ($buku) {
                $buku->stok += 1;
                $buku->save();
            }
        }

         catatRiwayat('peminjaman', 'menghapus', 'Membatalkan peminjaman buku "' . $buku->judul . '" oleh siswa: ' . $siswa->nama_siswa);

        $peminjaman->delete();
        return back()->with('success', 'Peminjaman dibatalkan.');
    }

    $peminjaman->save();
    return back()->with('success', 'Status peminjaman diperbarui.');
}


            public function export()
            {
                // Placeholder fitur ekspor (Excel / PDF)
                return response()->json(['message' => 'Fitur ekspor belum diimplementasikan.']);
            }
        }
