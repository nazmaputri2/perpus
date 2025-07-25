<?php

namespace App\Http\Controllers;
use App\Models\Siswa;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
   public function index(Request $request)
{
    $siswa = Siswa::query();

    if ($request->has('search') && $request->filled('search')) {
        $search = $request->search;

        $siswa->where(function ($query) use ($search) {
            $query->where('nis_siswa', 'like', "%{$search}%")
                  ->orWhere('nama_siswa', 'like', "%{$search}%")
                  ->orWhere('kelas_siswa', 'like', "%{$search}%");
        });
    }

    // Ambil 10 data terbaru dan paginasi
    $students = $siswa->latest()->orderBy('created_at', 'desc')->paginate(25)->withQueryString();


        return view('petugas.datasiswa', compact('students'));
    }
    
    public function store(Request $request)
    {
        \Log::info('Request masuk ke store:', $request->all());
        // Validasi data siswa + username/password
        $request->validate([
            'nis_siswa' => 'required|unique:siswa,nis_siswa',
            // ...
        ], [
            'nis_siswa.unique' => 'NIS ini sudah terdaftar. Harap gunakan NIS yang lain.',
            'nama_siswa' => 'required',
            'kelamin_siswa' => 'required|in:Laki-laki,Perempuan',
            'kelas_siswa' => 'required',
            'nohp_siswa' => ['required', 'regex:/^0[0-9]{9,11}$/'],
        ], [
            'nohp_siswa.regex' => 'Nomor HP harus dimulai dengan 0 dan terdiri dari 10–12 digit.'
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

        catatRiwayat('siswa', 'tambah', 'Menambahkan data siswa: ' . $request->nama_siswa);



        return redirect()->back()->with('success', 'Data siswa  berhasil dibuat!');
    }

    public function update(Request $request, $nis_siswa)
    {
        $siswa = Siswa::where('nis_siswa', $nis_siswa)->findOrFail($nis_siswa);

        $request->validate([
            'nis_siswa' => 'required|unique:siswa,nis_siswa,' . $siswa->nis_siswa . ',nis_siswa',
            'nama_siswa' => 'required',
            'kelamin_siswa' => 'required|in:Laki-laki,Perempuan',
            'kelas_siswa' => 'required',
            'nohp_siswa' => ['required', 'regex:/^0[0-9]{9,11}$/'],
        ], [
            'nohp_siswa.regex' => 'Nomor HP harus dimulai dengan 0 dan terdiri dari 10–12 digit.'
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

        catatRiwayat('siswa', 'ubah', 'Mengubah data siswa: ' . $siswa->nama_siswa);


        return redirect()->back()->with('success', 'Data siswa berhasil diperbarui!');
    }


    public function destroy($nis_siswa)
    {
        $siswa = Siswa::where('nis_siswa', $nis_siswa)->first();
    
    if (!$siswa) {
        return redirect()->back()->with('error', 'Data petugas tidak ditemukan!');
    }
    
        $pengguna = $siswa->pengguna;

        $siswa->delete();
        if ($pengguna) {
            $pengguna->delete();
        }

        catatRiwayat('siswa', 'hapus', 'Menghapus data siswa: ' . $siswa->nama_siswa);


        return redirect()->back()->with('success', 'Data siswa berhasil dihapus!');
    }






}
