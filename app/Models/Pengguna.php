<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // PENTING: Menggunakan Authenticatable
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable // PENTING: Extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $table = 'pengguna';
    protected $primaryKey = 'id_user';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true; // <-- UBAH INI: Migrasi Anda menggunakan timestamps(), jadi set true

    protected $fillable = [
        'username',
        'password',
        'role',
        // 'nis_siswa' TIDAK perlu di sini karena berada di tabel 'siswa'
    ];

    protected $hidden = [
        'password',
        'remember_token', // <-- Pastikan ini ada setelah menambahkan kolom remember_token
    ];

    // Relasi ke tabel siswa
    public function siswa()
    {
        // 'id_user' pada tabel 'siswa' adalah foreign key
        // 'id_user' pada tabel 'pengguna' adalah primary key
        return $this->hasOne(Siswa::class, 'id_user', 'id_user');
    }

    // Relasi ke tabel petugas
    public function petugas()
    {
        // 'id_user' pada tabel 'petugas' adalah foreign key
        // 'id_user' pada tabel 'pengguna' adalah primary key
        return $this->hasOne(Petugas::class, 'id_user', 'id_user');
    }
}