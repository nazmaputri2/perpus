<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id('id_peminjaman'); // Primary Key

            // Foreign Key ke tabel siswa (nis_siswa string)
            $table->string('nis_siswa');
            // Hapus nama_siswa karena bisa diambil dari relasi ke tabel siswa
            // $table->string('nama_siswa'); 

            // Foreign Key ke tabel buku (isbn string)
            $table->string('isbn');
            // Hapus judul karena bisa diambil dari relasi ke tabel buku
            // $table->string('judul');

            $table->date('tanggal_peminjaman');
            $table->date('tanggal_pengembalian')->nullable();
            $table->enum('status_peminjaman', ['Proses','Dipinjam', 'Dikembalikan', 'Terlambat'])->default('Proses');
            $table->string('keterangan')->nullable(); // Keterangan tambahan jika diperlukan

            // Tambahkan foreign key untuk petugas yang meminjamkan
            // Asumsi id_petugas di sini merujuk ke id_user di tabel 'pengguna'
            // yang merupakan ID dari petugas yang sedang login.
            $table->unsignedBigInteger('id_user')->nullable(); 

            $table->timestamps();

            // Definisi Foreign Key Constraints
            $table->foreign('nis_siswa')->references('nis_siswa')->on('siswa')->onDelete('cascade');
            $table->foreign('isbn')->references('isbn')->on('buku')->onDelete('cascade');
            
            // Foreign key ke tabel 'pengguna' (untuk id_petugas)
            // Asumsi primary key di tabel 'pengguna' adalah 'id_user' dan bertipe unsignedBigInteger
            $table->foreign('id_user')->references('id_user')->on('pengguna')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};