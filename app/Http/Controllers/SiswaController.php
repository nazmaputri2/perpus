<?php

namespace App\Http\Controllers;
use App\Models\Siswa;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        $students = Siswa::all();
        return view('petugas.datasiswa', compact('students'));
    }
    public function store(Request $request)
{
     \Log::info('Request masuk ke store:', $request->all());
    // Validasi data siswa + username/password
    $request->validate([
        'nis_siswa' => 'required|unique:siswa,nis_siswa',
        'nama_siswa' => 'required',
        'kelamin_siswa' => 'required|in:Laki-laki,Perempuan',
        'kelas_siswa' => 'required',
        'nohp_siswa' => 'nullable',
        // 'username' => 'required|unique:pengguna,username',
        // 'password' => 'required|min:6',
    ]);
 \Log::info('Validasi sukses');


    $baseUsername = strtolower(str_replace(' ', '', $request->nama_siswa));
    $username = $baseUsername . rand(100, 999); // Tambahkan angka acak untuk memastikan unik
    
    $defaultPassword = 'siswa123'; // Password default, bisa diubah sesuai kebutuhan
    $hashedPassword = Hash::make($defaultPassword); // Enkripsi password

    // Buat akun pengguna dulu
    $pengguna = Pengguna::create([
        'username' => $request->nis_siswa,
        'password' => $hashedPassword, // Enkripsi password
        'role' => 'siswa',
    ]);

    // Buat data siswa dan hubungkan ke akun pengguna
    Siswa::create([
        'nis_siswa' => $request->nis_siswa,
        'nama_siswa' => $request->nama_siswa,
        'kelamin_siswa' => $request->kelamin_siswa,
        'kelas_siswa' => $request->kelas_siswa,
        'nohp_siswa' => $request->nohp_siswa ?? null, // Gunakan null jika tidak ada input
        'id_user' => $pengguna->id_user,
    ]);

    return redirect()->back()->with('success', 'Data siswa  berhasil dibuat! Username: ' .$username . ', Password: ' . $defaultPassword);
}

public function update(Request $request, $nis_siswa)
{
 $siswa = Siswa::where('nis_siswa', $nis_siswa)->findOrFail($nis_siswa);

        $request->validate([
            'nis_siswa' => 'required|unique:siswa,nis_siswa,' . $siswa->nis_siswa . ',nis_siswa',
            'nama_siswa' => 'required',
            'kelamin_siswa' => 'required|in:Laki-laki,Perempuan',
            'kelas_siswa' => 'required',
            'nohp_siswa' => 'required',
            // username dan password bisa optional untuk update pengguna
        ]);
         $siswa->update([
            'nis_siswa' => $request->nis_siswa,
            'nama_siswa' => $request->nama_siswa,
            'kelamin_siswa' => $request->kelamin_siswa,
            'kelas_siswa' => $request->kelas_siswa,
            'nohp_siswa' => $request->nohp_siswa,
         ]);
           $pengguna = $siswa->pengguna;
        if ($request->username && $request->username !== $pengguna->username) {
            $request->validate([
                'username' => 'unique:pengguna,username,' . $pengguna->id_user . ',id_user',
            ]);
            $pengguna->username = $request->username;
        }
        if ($request->password) {
            $request->validate([
                'password' => 'min:6',
            ]);
            $pengguna->password = Hash::make($request->password);
        }
        $pengguna->save();

        return redirect()->back()->with('success', 'Data siswa berhasil diperbarui!');
    }


     public function destroy($nis)
    {
        $siswa = Siswa::findOrFail($nis);
        $pengguna = $siswa->pengguna;

        $siswa->delete();
        if ($pengguna) {
            $pengguna->delete();
        }

        return redirect()->back()->with('success', 'Data siswa berhasil dihapus!');
    }
    
}
