<?php

namespace App\Models;
use App\Models\Pengguna;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $primaryKey = 'nis_siswa';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'nis_siswa',
        'nama_siswa',
        'kelamin_siswa',
        'kelas_siswa',
        'nohp_siswa',
        'id_user', // foreign key ke tabel pengguna
    ];
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_user', 'id_user');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'nis_siswa', 'nis_siswa');
    }
}
