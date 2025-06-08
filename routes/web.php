<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\RiwayatAktivitasController;
use App\Http\Controllers\BerandaSiswaController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\DataBukuController;
use App\Http\Controllers\GantiPasswordController;
use App\Http\Middleware\CekLogin;


Route::get('/', [AuthController::class, 'showLoginForm'])->name('auth.login');
Route::post('/', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth.custom')->group(function () {
    Route::get('/petugas-beranda', function () {
        return view('petugas.beranda'); // Ganti dengan tampilan beranda petugas
    })->name('petugas.beranda');

    Route::get('/siswa-beranda', function () {
        return view('siswa.beranda'); // Ganti dengan tampilan beranda siswa
    })->name('siswa.beranda');

     Route::post('/ganti-password', [GantiPasswordController::class, 'update'])->name('password.update');
    
});


Route::middleware('auth.custom')->prefix('petugas')->group(function () {
 Route::get('datasiswa', [SiswaController::class, 'index'])->name('petugas.datasiswa');
    Route::post('datasiswa', [SiswaController::class, 'store'])->name('petugas.datasiswa.store');
    Route::put('datasiswa/{nis_siswa}', [SiswaController::class, 'update'])->name('petugas.datasiswa.update');
    Route::delete('datasiswa/{nis_siswa}', [SiswaController::class, 'destroy'])->name('petugas.datasiswa.destroy');

    Route::get('datapetugas', [PetugasController::class, 'index'])->name('petugas.datapetugas');
    Route::post('datapetugas', [PetugasController::class, 'store'])->name('petugas.datapetugas.store');
    Route::put('datapetugas/{nip}', [PetugasController::class, 'update'])->name('petugas.datapetugas.update');
    Route::delete('datapetugas/{nip}', [PetugasController::class, 'destroy'])->name('petugas.datapetugas.destroy');



     // Data Buku (contoh, sesuaikan dengan controller Anda)
    Route::get('databuku', [DataBukuController::class, 'index'])->name('petugas.databuku');
    Route::post('databuku', [DataBukuController::class, 'store'])->name('petugas.databuku.store');
    Route::put('databuku/{id}', [DataBukuController::class, 'update'])->name('petugas.databuku.update');
    Route::delete('databuku/{id}', [DataBukuController::class, 'destroy'])->name('petugas.databuku.destroy');

    // Data Peminjaman (contoh, sesuaikan dengan controller Anda)
    // Route::get('datapeminjaman', [PeminjamanController::class, 'index'])->name('petugas.datapeminjaman');
    // Route::post('datapeminjaman', [PeminjamanController::class, 'store'])->name('petugas.datapeminjaman.store');
    // Route::put('datapeminjaman/{id}', [PeminjamanController::class, 'update'])->name('petugas.datapeminjaman.update');
    // Route::delete('datapeminjaman/{id}', [PeminjamanController::class, 'destroy'])->name('petugas.datapeminjaman.destroy');

    // Riwayat Aktivitas
    Route::get('riwayat', [RiwayatAktivitasController::class, 'index'])->name('petugas.riwayat');


    Route::get('/siswa/beranda', [BerandaSiswaController::class, 'index'])->name('siswa.beranda');
        Route::post('/siswa/beranda', [SiswaController::class, 'pinjamBuku'])->name('siswa.pinjam.buku');
Route::get('/profil', function () {
    // Anda akan mengambil data siswa dari database di sini
    // Untuk saat ini, kita akan meneruskan array kosong atau dummy
    return view('siswa.profile');
})->name('siswa.profile');

});


// Route::get('/', function () {
//     return view('welcome');
// });
