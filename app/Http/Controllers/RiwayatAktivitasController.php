<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RiwayatAktivitasController extends Controller
{
    public function index()
    {
        // Data dummy untuk contoh
        $todayActivities = [
            [
                'aktivitas' => 'Meminjam Buku "Matahari"',
                'pengguna' => 'Riansyah',
                'waktu' => '32 menit yang lalu'
            ],
            [
                'aktivitas' => 'Mengembalikan Buku "Bulan"',
                'pengguna' => 'Putra Maulana',
                'waktu' => '1 jam yang lalu'
            ],
            [
                'aktivitas' => 'Meminjam Buku "Bintang"',
                'pengguna' => 'Rafif Ruhul Haqq',
                'waktu' => '2 jam yang lalu'
            ],
            [
                'aktivitas' => 'Memperbarui Data Buku "Bintang"',
                'pengguna' => 'Rafif Ruhul Haqq',
                'waktu' => '3 jam yang lalu'
            ]
        ];

        $yesterdayActivities = [
            [
                'aktivitas' => 'Meminjam Buku "Matahari"',
                'pengguna' => 'Riansyah',
                'waktu' => '14.50'
            ],
            [
                'aktivitas' => 'Mengembalikan Buku "Bulan"',
                'pengguna' => 'Putra Maulana',
                'waktu' => '13.21'
            ],
            [
                'aktivitas' => 'Menambahkan Buku "Bintang"',
                'pengguna' => 'Rafif Ruhul Haqq',
                'waktu' => '10.15'
            ],
            [
                'aktivitas' => 'Memperbarui Data Buku "Bintang"',
                'pengguna' => 'Rafif Ruhul Haqq',
                'waktu' => '09.28'
            ]
        ];

        $previousActivities = [
            [
                'aktivitas' => 'Meminjam Buku "Matahari"',
                'pengguna' => 'Riansyah',
                'waktu' => '14.50'
            ],
            [
                'aktivitas' => 'Mengembalikan Buku "Bulan"',
                'pengguna' => 'Putra Maulana',
                'waktu' => '13.21'
            ],
            [
                'aktivitas' => 'Menambahkan Buku "Bintang"',
                'pengguna' => 'Rafif Ruhul Haqq',
                'waktu' => '10.15'
            ],
            [
                'aktivitas' => 'Memperbarui Data Buku "Bintang"',
                'pengguna' => 'Rafif Ruhul Haqq',
                'waktu' => '09.28'
            ]
        ];

        return view('petugas.riwayat', [
            'today' => 'Selasa, 22 April 2025',
            'yesterday' => 'Senin, 21 April 2025',
            'previousDay' => 'Jumat, 18 April 2025',
            'todayActivities' => $todayActivities,
            'yesterdayActivities' => $yesterdayActivities,
            'previousActivities' => $previousActivities
        ]);
    }
}