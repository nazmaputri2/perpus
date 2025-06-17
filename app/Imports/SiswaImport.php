<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class SiswaImport implements ToCollection, WithHeadingRow{
    /**
    * @param Collection $collection
    */
  public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Validasi sederhana: pastikan kolom penting ada
            if (
                !empty($row['nis']) &&
                !empty($row['nama_siswa']) &&
                !empty($row['kelamin']) &&
                !empty($row['kelas'])
            ) {
                // Cek jika akun dengan username NIS sudah ada
                $pengguna = Pengguna::firstOrCreate(
                    ['username' => $row['nis']],
                    [
                        'password' => Hash::make('defaultpassword'),
                        'role' => 'siswa',
                    ]
                );

                // Cek jika siswa sudah ada berdasarkan NIS
                Siswa::updateOrCreate(
                    ['nis' => $row['nis']],
                    [
                        'nama' => $row['nama_siswa'],
                        'kelamin' => $row['kelamin'],
                        'kelas' => $row['kelas'],
                        'no_hp' => $row['no_hp'] ?? null,
                        'id_user' => $pengguna->id_user,
                    ]
                );
        }
    }
}
}
