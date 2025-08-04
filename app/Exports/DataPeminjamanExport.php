<?php


namespace App\Exports;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\DataPeminjaman;
use App\Models\Peminjaman;

class DataPeminjamanExport implements FromCollection
{
    protected $bulan, $status;

    public function __construct($bulan, $status)
    {
        $this->bulan = $bulan;
        $this->status = $status;
    }

    public function collection()
    {
        $query = Peminjaman::with(['siswa', 'buku']);

        if ($this->bulan) {
            $query->whereMonth('tanggal_peminjaman', $this->bulan);
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        return $query->get();
    }}
