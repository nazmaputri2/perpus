<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman'; // Nama tabel di database

    protected $primaryKey = 'id_peminjaman'; // Primary key tabel

    protected $fillable = [
        'nis_siswa',
        'isbn', // Sesuaikan dengan nama kolom di migrasi Anda
        'tanggal_peminjaman', // Sesuaikan dengan nama kolom di migrasi Anda
        'tanggal_pengembalian',
        'status_peminjaman',
        'id_user', // Tambahkan ini jika Anda sudah menambahkan di migrasi
    ];

    public function getStatusPeminjamanAttribute($value)
{
    if ($value === 'Dipinjam' && Carbon::now()->gt(Carbon::parse($this->tanggal_pengembalian))) {
        return 'Terlambat';
    }

    return $value;
}

    // Relasi dengan model Buku
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'isbn', 'isbn'); // Foreign key 'isbn' di Peminjaman merujuk ke 'isbn' di Buku
    }

    // Relasi dengan model Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis_siswa', 'nis_siswa'); // Foreign key 'nis_siswa' di Peminjaman merujuk ke 'nis_siswa' di Siswa
    }

    // Relasi dengan model Petugas (asumsi petugas adalah user dari tabel 'pengguna')
    public function petugas()
    {
        // Asumsi 'id_petugas' di tabel peminjaman merujuk ke 'id_user' di tabel 'pengguna'
        return $this->belongsTo(Pengguna::class, 'id_petugas', 'id_user');
    }
}