<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengguna;
use App\Models\Siswa;   // <-- Import model Siswa
use App\Models\Petugas; // <-- Import model Petugas
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Buat pengguna siswa
        $penggunaSiswa = Pengguna::firstOrCreate(
            ['username' => 'nazma'],
            [
                'password' => Hash::make('siswa123'),
                'role' => 'siswa'
            ]
        );

        // Buat detail siswa yang berelasi dengan pengguna 'nazma'
        Siswa::firstOrCreate(
            ['nis_siswa' => '2023001'], // NIS siswa untuk Nazma
            [
                'nama_siswa' => 'Nazma Salsabila',
                'kelamin_siswa' => 'Perempuan',
                'kelas_siswa' => '10A',
                'nohp_siswa' => '081234567890',
                'id_user' => $penggunaSiswa->id_user, // Mengaitkan dengan pengguna Nazma
            ]
        );

        // Buat pengguna petugas
        $penggunaPetugas = Pengguna::firstOrCreate(
            ['username' => 'rafif'],
            [
                'password' => Hash::make('petugas123'),
                'role' => 'petugas'
            ]
        );

        // Buat detail petugas yang berelasi dengan pengguna 'rafif'
        Petugas::firstOrCreate(
            ['nip' => 'P001'], // NIP untuk Rafif
            [
                'nama' => 'Rafif Petugas',
                'nohp' => '08987654321',
                'alamat' => 'Jl. Petugas No. 1',
                'id_user' => $penggunaPetugas->id_user, // Mengaitkan dengan pengguna Rafif
            ]
        );

        // Panggil seeder lain jika ada
        // $this->call(SomeOtherSeeder::class);
    }
}