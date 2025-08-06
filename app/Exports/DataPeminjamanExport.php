<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Peminjaman;

class DataPeminjamanExport implements FromCollection, WithHeadings
{
    protected $bulan, $status;

    public function __construct($bulan = null, $status = null)
    {
        $this->bulan = $bulan;
        $this->status = $status;
    }

    public function collection()
    {
        // Ambil data dengan relasi siswa dan buku
        $query = Peminjaman::with(['siswa', 'buku']);

        if ($this->bulan) {
            $query->whereMonth('tanggal_peminjaman', $this->bulan);
        }

        if ($this->status) {
            $query->where('status_peminjaman', $this->status);
        }

        $data = $query->get();

        // Format data untuk export
        return $data->map(function ($item) {
            return [
                'nama_siswa'            => $item->siswa->nama_siswa ?? '-',
                'kelas_siswa'           => $item->siswa->kelas_siswa ?? '-',
                'judul_buku'            => $item->buku->judul ?? '-',
                'tanggal_peminjaman'    => $item->tanggal_peminjaman,
                'tanggal_pengembalian'  => $item->tanggal_pengembalian ?? '-',
                'status'                => $item->status_peminjaman,
                'keterangan'            => $item->keterangan ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Siswa',
            'Kelas',
            'Judul Buku',
            'Tanggal Peminjaman',
            'Tanggal Pengembalian',
            'Status',
            'Keterangan',
        ];
    }
}
