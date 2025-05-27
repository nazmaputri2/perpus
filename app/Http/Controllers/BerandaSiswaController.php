<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;

class BerandaSiswaController extends Controller
{
 public function index()
    {
        // Data dummy untuk buku
        $buku = [
            [
                'id' => 1,
                'gambar' => 'bahanpbl/1.png',
                'judul' => 'Bahasa Indonesia',
                'isbn' => '123456789',
                'penulis' => 'Penulis A',
                'penerbit' => 'Penerbit A',
                'tahun_terbit' => '2022',
                'stok' => '10',
                'deskripsi' => 'Buku pelajaran Bahasa Indonesia untuk kelas 6 SD'
            ],
            [
                'id' => 2,
                'gambar' => 'https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/picture_meta/2023/4/10/sqew3j5qexpsolyjghtrom.jpg',
                'judul' => 'Si Putih',
                'isbn' => '987654321',
                'penulis' => 'Penulis B',
                'penerbit' => 'Penerbit B',
                'tahun_terbit' => '2021',
                'stok' => '5',
                'deskripsi' => 'Novel fiksi tentang petualangan seekor kucing putih'
            ],
            // Tambahkan data buku lainnya sesuai kebutuhan
        ];

        // Opsi filter
        $kategoriOptions = ['Pelajaran', 'Fiksi', 'Non Fiksi'];
        $kelasOptions = range(1, 6);

        return view('siswa.beranda', [
            'buku' => $buku,
            'kategoriOptions' => $kategoriOptions,
            'kelasOptions' => $kelasOptions
        ]);
    }

    public function pinjamBuku(Request $request)
    {
        // Ini hanya simulasi tanpa benar-benar menyimpan ke database
        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil dipinjam (simulasi)'
        ]);
    }

}