<?php

namespace App\Models;
use App\Models\Pengguna;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    protected $table = 'petugas';
    protected $primaryKey = 'nip';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'nip',
        'nama',
        'nohp',
        'alamat',
        'id_user', // foreign key ke tabel pengguna
    ];
    
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_user', 'id_user');
    }
}
