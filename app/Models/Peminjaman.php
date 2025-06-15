<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';
    public $timestamps = false;

    protected $fillable = [
        'nis_siswa',
        'nama_siswa',
        'isbn',
        'judul',
        'tanggal_peminjaman',
        'tanggal_pengembalian',
        'status_peminjaman'
    ];
}
