<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('anggota', function (Blueprint $table) {
            $table->string('no_anggota')->primary();
            $table->string('nama_anggota');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->enum('keanggotaan', ['kelas 1', 'kelas 2', 'kelas 3', 'kelas 4', 'kelas 5', 'kelas 6','guru']); // Kelas siswa, bisa diubah sesuai kebutuhan
            $table->string('nohp_anggota')->nullable(); // Nomor HP siswa, bisa null jika tidak diisi
            $table->unsignedBigInteger('id_user'); // foreign key ke tabel pengguna
            $table->foreign('id_user')->references('id_user')->on('pengguna')->onDelete('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota');
    }
};
