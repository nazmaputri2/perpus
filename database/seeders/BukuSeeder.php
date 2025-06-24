<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BukuSeeder extends Seeder
{
    public function run()
    {
        DB::table('buku')->insert([
            [
                'gambar' => 'buku1.jpg',
                'isbn' => '9786020000001',
                'judul' => 'Laravel Untuk Pemula',
                'penulis' => 'A. Developer',
                'penerbit' => 'Informatika',
                'tahun_terbit' => 2022,
                'sinopsis' => 'Belajar Laravel step-by-step.',
                'stok' => 5,
                'jenis_buku' => 'Teknologi',
                'kelas' => 'XI',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'gambar' => 'buku2.jpg',
                'isbn' => '9786020000002',
                'judul' => 'Dasar HTML dan CSS',
                'penulis' => 'B. Frontend',
                'penerbit' => 'Elex Media',
                'tahun_terbit' => 2021,
                'sinopsis' => 'Pemahaman dasar desain web.',
                'stok' => 7,
                'jenis_buku' => 'Teknologi',
                'kelas' => 'X',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'gambar' => 'buku3.jpg',
                'isbn' => '9786020000003',
                'judul' => 'Algoritma & Pemrograman',
                'penulis' => 'C. Algoritmik',
                'penerbit' => 'Erlangga',
                'tahun_terbit' => 2020,
                'sinopsis' => 'Konsep dan logika algoritma.',
                'stok' => 10,
                'jenis_buku' => 'Pelajaran',
                'kelas' => 'XI',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'gambar' => 'buku4.jpg',
                'isbn' => '9786020000004',
                'judul' => 'Matematika SMA',
                'penulis' => 'D. Matematika',
                'penerbit' => 'Tiga Serangkai',
                'tahun_terbit' => 2023,
                'sinopsis' => 'Matematika kelas XI revisi.',
                'stok' => 6,
                'jenis_buku' => 'Pelajaran',
                'kelas' => 'XI',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'gambar' => 'buku5.jpg',
                'isbn' => '9786020000005',
                'judul' => 'Bahasa Indonesia Aktif',
                'penulis' => 'E. Bahasa',
                'penerbit' => 'Grasindo',
                'tahun_terbit' => 2022,
                'sinopsis' => 'Latihan Bahasa Indonesia untuk SMA.',
                'stok' => 8,
                'jenis_buku' => 'Bahasa',
                'kelas' => 'XI',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
