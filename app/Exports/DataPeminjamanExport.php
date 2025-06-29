<?php


namespace App\Exports;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DataPeminjamanExport implements FromCollection, WithHeadings
{
    protected $data;
    public function __construct(Collection $data)
    {
        $this->data = $data;
    }
    public function collection()
    {
        return $this->data->map(function ($item) {
            return [
                'nama_siswa' => $item->siswa->nama_siswa ?? '-',
                'kelas_siswa' => $item->siswa->kelas_siswa ?? '-',
                'judul_buku' => $item->buku->judul ?? '-',
                'tanggal_peminjaman' => $item->tanggal_peminjaman,
                'tanggal_pengembalian' => $item->tanggal_pengembalian ?? '-',
                'status' => $item->status_peminjaman,
                'keterangan' => $item->keterangan ?? '-',
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
