<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataPeminjamanExport;
use Carbon\Carbon;
use App\Models\Buku;
use App\Models\Siswa;

class DataPeminjamanController extends Controller
{
    /**
     * Menandai peminjaman yang terlambat secara otomatis.
     * Peminjaman dianggap terlambat jika statusnya 'Dipinjam' dan tanggal batas kembali (peminjaman + 14 hari) sudah lewat dari hari ini.
     */
    protected function tandaiTerlambatOtomatis()
    {
        $terlambat = Peminjaman::where('status_peminjaman', 'Dipinjam')
            ->whereDate(DB::raw('DATE_ADD(tanggal_peminjaman, INTERVAL 14 DAY)'), '<', now())
            ->get();

        foreach ($terlambat as $pinjam) {
            $pinjam->update(['status_peminjaman' => 'Terlambat']);
        }
    }

    /**
     * Menampilkan daftar data peminjaman dengan fitur filter berdasarkan status dan pencarian.
     * @param Request $request Objek request HTTP untuk mendapatkan parameter filter (status, search).
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Jalankan sistem penanda otomatis untuk buku yang terlambat
        $this->tandaiTerlambatOtomatis();

        // Hitung statistik untuk semua status, sebelum filter diterapkan
        $stats = [
            'total' => Peminjaman::where('status_peminjaman', 'Dikembalikan')->count(),
            'dipinjam' => Peminjaman::where('status_peminjaman', 'Dipinjam')->count(),
            'terlambat' => Peminjaman::where('status_peminjaman', 'Terlambat')->count(),
            'selesaiHariIni' => Peminjaman::where('status_peminjaman', 'Dikembalikan')
                ->whereDate('updated_at', Carbon::today())
                ->count(),
        ];

        // Mulai query utama yang akan difilter
        $query = Peminjaman::with(['anggota', 'buku']);

        // Filter berdasarkan status dari request (klik stats card)
        $statusFilter = $request->input('status');

        // Debug: Log parameter yang diterima
        \Log::info('Status Filter: ' . $statusFilter);

        // Aplikasikan filter berdasarkan status
        if ($statusFilter) {
            if ($statusFilter === 'total') {
                // ✅ Jika filter total dipilih, tampilkan hanya Dikembalikan
                $query->where('status_peminjaman', 'Dikembalikan');
            } else {
                // ✅ Filter lain tetap seperti semula
                switch ($statusFilter) {
                    case 'Dipinjam':
                        $query->where('status_peminjaman', 'Dipinjam');
                        break;
                    case 'Terlambat':
                        $query->where('status_peminjaman', 'Terlambat');
                        break;
                    case 'SelesaiHariIni':
                        $query->where('status_peminjaman', 'Dikembalikan')
                            ->whereDate('updated_at', Carbon::today());
                        break;
                    case 'Dikembalikan':
                        $query->where('status_peminjaman', 'Dikembalikan');
                        break;
                    case 'Proses':
                        $query->where('status_peminjaman', 'Proses');
                        break;
                }
            }
        }
        
        // Filter berdasarkan pencarian (search input)
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->whereHas('anggota', function ($qr) use ($searchTerm) {
                    $qr->where('nama_anggota', 'like', '%' . $searchTerm . '%')
                        ->orWhere('no_anggota', 'like', '%' . $searchTerm . '%')
                        ->orWhere('keanggotaan', 'like', '%' . $searchTerm . '%');
                })->orWhereHas('buku', function ($qr) use ($searchTerm) {
                    $qr->where('isbn', 'like', '%' . $searchTerm . '%')
                        ->orWhere('judul', 'like', '%' . $searchTerm . '%');
                })->orWhere('status_peminjaman', 'like', '%' . $searchTerm . '%');
            });
        }

        // Debug: Log query SQL yang akan dijalankan
        \Log::info('Query SQL: ' . $query->toSql());

        \Log::info('Query Bindings: ', $query->getBindings());

        // Urutkan data terbaru dan lakukan paginasi, dengan mempertahankan query string
        $peminjaman = $query->latest('created_at')->paginate(25)->withQueryString();

        // Debug: Log jumlah data yang ditemukan
        \Log::info('Jumlah data ditemukan: ' . $peminjaman->total());

        // Kirim informasi filter aktif ke view untuk keperluan UI
        $activeFilter = $statusFilter ?? 'semua';

        return view('petugas.datapeminjaman', compact('peminjaman', 'stats', 'activeFilter'));
    }

    /**
     * Memperbarui status peminjaman (setujui, selesai, batal).
     * @param Request $request Objek request HTTP.
     * @param int $id ID peminjaman yang akan diperbarui.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $aksi = $request->input('aksi');

        $buku = $peminjaman->buku;
        $anggota = $peminjaman->anggota;

        if ($aksi === 'setujui') {
            // Validasi stok buku sebelum menyetujui
            if ($buku && $buku->stok <= 0) {
                return back()->with('error', 'Stok buku tidak mencukupi.');
            }

            $peminjaman->status_peminjaman = 'Dipinjam';
            $peminjaman->tanggal_peminjaman = now(); // Set tanggal peminjaman aktual
            $peminjaman->tanggal_pengembalian = now()->addDays(14); // Set batas pengembalian

            // Kurangi stok buku
            if ($buku) {
                $buku->stok -= 1;
                $buku->save();
            }

            // Asumsi catatRiwayat adalah helper function
            if (function_exists('catatRiwayat')) {
                catatRiwayat('peminjaman', 'menyetujui', 'Menyetujui peminjaman buku "' . $buku->judul . '" oleh: ' . $anggota->nama_anggota);
            }

        } elseif ($aksi === 'selesai') {
            $peminjaman->status_peminjaman = 'Dikembalikan';

            // Simpan tanggal pengembalian sebagai hari ini
            $tanggalKembali = now();
            $peminjaman->tanggal_pengembalian = $tanggalKembali;

            // Hitung batas waktu pengembalian (14 hari dari tanggal peminjaman)
            $batasKembali = Carbon::parse($peminjaman->tanggal_peminjaman)->addDays(14);

            // Cek apakah terlambat
            if ($tanggalKembali->gt($batasKembali)) {
                // Hitung hari keterlambatan menggunakan startOfDay untuk menghindari desimal
                $hariTerlambat = $tanggalKembali->startOfDay()->diffInDays($batasKembali->startOfDay());
                $peminjaman->keterangan = 'Terlambat dikembalikan ' . abs($hariTerlambat) . ' hari';
            } else {
                $peminjaman->keterangan = 'Dikembalikan tepat waktu';
            }

            // Tambah stok buku
            if ($buku) {
                $buku->stok += 1;
                $buku->save();
            }

            // Simpan data peminjaman yang sudah diperbarui
            $peminjaman->save();

            // Catat riwayat pengembalian
            if (function_exists('catatRiwayat')) {
                catatRiwayat('peminjaman', 'mengembalikan', 'Menyelesaikan peminjaman buku "' . $buku->judul . '" oleh: ' . $anggota->nama_anggota);
            }

        } elseif ($aksi === 'batal') {
            // Jika status sedang dipinjam atau terlambat, kembalikan stok
            if (in_array($peminjaman->status_peminjaman, ['Dipinjam', 'Terlambat'])) {
                if ($buku) {
                    $buku->stok += 1;
                    $buku->save();
                }
            }

            // Asumsi catatRiwayat adalah helper function
            if (function_exists('catatRiwayat')) {
                catatRiwayat('peminjaman', 'membatalkan', 'Membatalkan peminjaman buku "' . $buku->judul . '" oleh: ' . $anggota->nama_anggota);
            }

            $peminjaman->delete();
            return back()->with('success', 'Peminjaman berhasil dibatalkan.');
        }

        $peminjaman->save();
        return back()->with('success', 'Status peminjaman berhasil diperbarui.');
    }

    /**
     * Method untuk debugging - menampilkan semua data peminjaman dengan status
     */
    public function debug()
    {
        $data = Peminjaman::with(['siswa', 'buku'])->get();
        foreach ($data as $item) {
            echo "ID: {$item->id_peminjaman}, Status: {$item->status_peminjaman}, Siswa: {$item->anggota->nama_anggota}<br>";
        }
    }

    /**
     * Placeholder untuk fitur ekspor data.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request)
    {
        $bulan = $request->bulan;
        $status = $request->status;

        return Excel::download(new DataPeminjamanExport($bulan, $status), 'data_peminjaman.xlsx');
    }
}