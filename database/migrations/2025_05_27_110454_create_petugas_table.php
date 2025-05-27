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
        Schema::create('petugas', function (Blueprint $table) {
            $table->string('nip')->primary();
            $table->string('nama');
            $table->string('nohp')->nullable();
            $table->text('alamat');
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
        Schema::dropIfExists('petugas');
    }
};
