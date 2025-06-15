<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\RiwayatAktivitasController;
use App\Http\Controllers\BerandaSiswaController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\DataBukuController;
use App\Http\Controllers\GantiPasswordController;
use App\Http\Controllers\PeminjamanController; // <-- Pastikan ini diimpor jika digunakan di rute petugas
// use App\Http\Middleware\CekLogin; // Middleware sudah otomatis dikenali via Kernel

Route::get('/', [AuthController::class, 'showLoginForm'])->name('auth.login');
Route::post('/', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Grup route yang dilindungi oleh middleware autentikasi kustom
Route::middleware('auth.custom')->group(function () {
    // Route umum yang perlu autentikasi
    Route::get('/petugas-beranda', function () {
        return view('petugas.beranda');
    })->name('petugas.beranda');

    Route::get('/siswa-beranda', function () {
        return view('siswa.beranda');
    })->name('siswa.beranda');

    Route::post('/ganti-password', [GantiPasswordController::class, 'update'])->name('password.update');
});

// Grup route khusus untuk Petugas
Route::middleware('auth.custom')->prefix('petugas')->group(function () {
    Route::get('datasiswa', [SiswaController::class, 'index'])->name('petugas.datasiswa');
    Route::post('datasiswa', [SiswaController::class, 'store'])->name('petugas.datasiswa.store');
    Route::put('datasiswa/{nis_siswa}', [SiswaController::class, 'update'])->name('petugas.datasiswa.update');
    Route::delete('datasiswa/{nis_siswa}', [SiswaController::class, 'destroy'])->name('petugas.datasiswa.destroy');

    Route::get('datapetugas', [PetugasController::class, 'index'])->name('petugas.datapetugas');
    Route::post('datapetugas', [PetugasController::class, 'store'])->name('petugas.datapetugas.store');
    Route::put('datapetugas/{nip}', [PetugasController::class, 'update'])->name('petugas.datapetugas.update');
    Route::delete('datapetugas/{nip}', [PetugasController::class, 'destroy'])->name('petugas.datapetugas.destroy');

    Route::get('databuku', [DataBukuController::class, 'index'])->name('petugas.databuku');
    Route::post('databuku', [DataBukuController::class, 'store'])->name('petugas.databuku.store');
    Route::put('databuku/{id}', [DataBukuController::class, 'update'])->name('petugas.databuku.update');
    Route::delete('databuku/{id}', [DataBukuController::class, 'destroy'])->name('petugas.databuku.destroy');

    // Data Peminjaman
    Route::get('datapeminjaman', [PeminjamanController::class, 'index'])->name('petugas.datapeminjaman');
    Route::post('datapeminjaman', [PeminjamanController::class, 'store'])->name('petugas.datapeminjaman.store');
    Route::put('datapeminjaman/{id}', [PeminjamanController::class, 'update'])->name('petugas.datapeminjaman.update');
    Route::delete('datapeminjaman/{id}', [PeminjamanController::class, 'destroy'])->name('petugas.datapeminjaman.destroy');

    Route::get('riwayat', [RiwayatAktivitasController::class, 'index'])->name('petugas.riwayat');
});

// Grup route khusus untuk Siswa
Route::middleware('auth.custom')->prefix('siswa')->group(function () {
    // Beranda siswa
    Route::get('beranda', [BerandaSiswaController::class, 'index'])->name('siswa.beranda');
    
    // Route untuk pinjam buku
    Route::post('pinjam-buku', [BerandaSiswaController::class, 'pinjamBuku'])->name('siswa.pinjam.buku');
    
    Route::get('/profil', function () {
        return view('siswa.profile');
    })->name('siswa.profile');
});