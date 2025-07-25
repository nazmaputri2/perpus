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
        Schema::create('siswa', function (Blueprint $table) {
            $table->string('nis_siswa')->primary();
            $table->string('nama_siswa');
            $table->enum('kelamin_siswa', ['Laki-laki', 'Perempuan']);
            $table->enum('kelas_siswa', ['1', '2', '3', '4', '5', '6']); // Kelas siswa, bisa diubah sesuai kebutuhan
            $table->string('nohp_siswa')->nullable(); // Nomor HP siswa, bisa null jika tidak diisi
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
        Schema::dropIfExists('siswa');
    }
};
