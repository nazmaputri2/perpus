<?php

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users', // Pastikan ini menunjuk ke provider 'users' di bawah
        ],
        // Jika Anda ingin guard khusus untuk siswa atau petugas, Anda bisa tambahkan di sini
        // Misalnya:
        // 'siswa' => [
        //     'driver' => 'session',
        //     'provider' => 'pengguna_siswa', // Provider baru untuk siswa
        // ],
    ],

    'providers' => [
        'users' => [ // <-- Pastikan ini adalah provider default Anda
            'driver' => 'eloquent',
            'model' => App\Models\Pengguna::class, // <-- UBAH INI: Arahkan ke model Pengguna Anda
        ],

        // Jika Anda membuat guard khusus di atas, definisikan providernya di sini
        // Misalnya:
        // 'pengguna_siswa' => [
        //     'driver' => 'eloquent',
        //     'model' => App\Models\Pengguna::class,
        // ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];