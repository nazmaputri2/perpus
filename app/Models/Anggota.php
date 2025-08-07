<?php

namespace App\Models;
use App\Models\Pengguna;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'anggota';
    protected $primaryKey = 'no_anggota';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'no_anggota',
        'nama_anggota',
        'jenis_kelamin',
        'keanggotaan',
        'nohp_anggota',
        'id_user', // foreign key ke tabel pengguna
    ];
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_user', 'id_user');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'no_anggota', 'no_anggota');
    }
}
