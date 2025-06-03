<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';
    protected $primaryKey = 'isbn';
    public $incrementing = false; // karena primary key bukan integer
    protected $keyType = 'string';

    protected $fillable = [
        'isbn',
        'judul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'sinopsis',
        'stok',
        'gambar',
    ];
}

