<?php

namespace App\Models;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    protected $table = 'pengguna';
    protected $primaryKey = 'id_user';
public $incrementing = true;
protected $keyType = 'int';
    public $timestamps = false; // Jika tidak menggunakan timestamps created_at dan updated_at
    protected $fillable = [
        'username',
        'password',
        'role',
    ];
    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'id_user');
    }
}
 Pengguna::create([
        'username' => 'nazma',
        'password' => Hash::make('siswa123'),
        'role' => 'siswa'
    ]);

     Pengguna::create([
        'username' => 'rafif',
        'password' => Hash::make('petugas123'),
        'role' => 'petugas'
    ]);