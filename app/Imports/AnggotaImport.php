<?php

namespace App\Imports;

use App\Models\Anggota;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class AnggotaImport implements ToCollection, WithHeadingRow{
    /**
    * @param Collection $collection
    */
  public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Validasi sederhana: pastikan kolom penting ada
            if (
                !empty($row['no_anggota']) &&
                !empty($row['nama_anggota']) &&
                !empty($row['jenis_kelamin']) &&
                !empty($row['keanggotaan'])
            ) {
                // Cek jika akun dengan username NIS sudah ada
                $pengguna = Pengguna::firstOrCreate(
                    ['username' => $row['no_anggota']],
                    [
                        'password' => Hash::make('anggota123'),
                        'role' => 'anggota',
                    ]
                );

                // Cek jika siswa sudah ada berdasarkan NIS
                Anggota::updateOrCreate(
                    ['no_anggota' => $row['no_anggota']],
                    [
                        'nama_anggota' => $row['nama_anggota'],
                        'jenis_kelamin' => $row['jenis_kelamin'],
                        'keanggotaan' => $row['keanggotaan'],
                        'nohp_anggota' => $row['no_hp'] ?? null,
                        'id_user' => $pengguna->id_user,
                    ]
                );
        }
    }
}
}
