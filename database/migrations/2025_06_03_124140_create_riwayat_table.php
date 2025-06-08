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
        Schema::create('riwayat', function (Blueprint $table) {
            $table->id('id_riwayat')->unique(); // Kolom Id (primary key)
            $table->string('nip'); // Foreign key ke petugas
            $table->string('nama');
            $table->string('tabel');
            $table->string('aksi');
            $table->text('keterangan')->nullable();
            $table->timestamp('waktu')->useCurrent();

            // Relasi ke tabel petugas
            $table->foreign('nip')->references('nip')->on('petugas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat');
    }
};
