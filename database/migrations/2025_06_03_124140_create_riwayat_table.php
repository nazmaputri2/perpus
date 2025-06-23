
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('riwayat', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('id_user');
            $table->string('tabel');         // Nama tabel yang diubah (siswa/buku)
            $table->string('aksi');          // Tambah/Edit/Hapus
            $table->text('keterangan');      // Keterangan tambahan
            $table->timestamp('waktu')->useCurrent(); // Waktu kejadian
            $table->foreign('id_user')->references('id_user')->on('pengguna')->onDelete('cascade');
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
