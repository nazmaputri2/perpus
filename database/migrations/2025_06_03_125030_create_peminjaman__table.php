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

            // Relasi ke siswa
            $table->string('nis_siswa'); // FK
            $table->string('nama_siswa');

            // Relasi ke buku
            $table->string('isbn'); // FK
            $table->string('judul');

            $table->date('tanggal_peminjaman');
            $table->date('tanggal_pengembalian')->nullable();
            $table->enum('status_peminjaman', ['Proses','Dipinjam', 'Dikembalikan', 'Terlambat'])->default('Proses');

            // Foreign Key Constraints
            $table->foreign('nis_siswa')->references('nis_siswa')->on('siswa')->onDelete('cascade');
            $table->foreign('isbn')->references('isbn')->on('buku')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_');
    }
};
