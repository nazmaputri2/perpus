<?php
namespace App\Models;
use App\Models\Pengguna;
use Illuminate\Database\Eloquent\Model;
class Riwayat extends Model
{
    protected $table = 'riwayat';
    public $timestamps = false;
    protected $fillable = [
        'id_user',
        'tabel',
        'aksi',
        'keterangan',
        'waktu'
    ];
    public function pengguna()
{
    return $this->belongsTo(Pengguna::class, 'id_user', 'id_user');
}
}
