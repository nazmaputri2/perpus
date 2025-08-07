<?php

namespace App\Http\Controllers;
use App\Models\Anggota;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
   public function index(Request $request)
{
    $anggota = Anggota::query();

    if ($request->has('search') && $request->filled('search')) {
        $search = $request->search;

        $anggota->where(function ($query) use ($search) {
            $query->where('no_anggota', 'like', "%{$search}%")
                  ->orWhere('nama_anggota', 'like', "%{$search}%")
                  ->orWhere('keanggotaan', 'like', "%{$search}%");
        });
    }

    // Ambil 10 data terbaru dan paginasi
    $students = $anggota->latest()->orderBy('created_at', 'desc')->paginate(25)->withQueryString();


        return view('petugas.datasiswa', compact('students'));
    }
    
    public function store(Request $request)
    {
        \Log::info('Request masuk ke store:', $request->all());
        // Validasi data siswa + username/password
        $request->validate([
            'no_anggota' => 'required|unique:anggota,no_anggota',
            // ...
        ], [
            'no_anggota.unique' => 'No anggota ini sudah terdaftar. Harap gunakan No anggota yang lain.',
            'nama_anggota' => 'required',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'keanggotaan' => 'required',
            'nohp_anggota' => ['required', 'regex:/^0[0-9]{9,11}$/'],
        ], [
            'nohp_anggota.regex' => 'Nomor HP harus dimulai dengan 0 dan terdiri dari 10–12 digit.'
        ]);

        \Log::info('Validasi sukses');


        $baseUsername = strtolower(str_replace(' ', '', $request->nama_anggota));
        $username = $baseUsername . rand(100, 999); // Tambahkan angka acak untuk memastikan unik

        $defaultPassword = 'anggota123'; // Password default, bisa diubah sesuai kebutuhan
        $hashedPassword = Hash::make($defaultPassword); // Enkripsi password

        // Buat akun pengguna dulu
        $pengguna = Pengguna::create([
            'username' => $request->no_anggota,
            'password' => $hashedPassword, // Enkripsi password
            'role' => 'anggota',
        ]);

        // Buat data siswa dan hubungkan ke akun pengguna
        Anggota::create([
            'no_anggota' => $request->no_anggota,
            'nama_anggota' => $request->nama_anggota,
            'jenis_kelamin' => $request->jenis_kelamin,
            'keanggotaan' => $request->keanggotaan,
            'nohp_anggota' => $request->nohp_anggota ?? null, // Gunakan null jika tidak ada input
            'id_user' => $pengguna->id_user,
        ]);

        catatRiwayat('anggota', 'tambah', 'Menambahkan data anggota: ' . $request->nama_anggota);



        return redirect()->back()->with('success', 'Data keanggotaan berhasil dibuat!');
    }

    public function update(Request $request, $no_anggota)
    {
        $anggota = Anggota::where('no_anggota', $no_anggota)->findOrFail($no_anggota);

        $request->validate([
            'no_anggota' => 'required|unique:anggota,no_anggota,' . $anggota->no_anggota . ',no_anggota',
            'nama_anggota' => 'required',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'keanggotaan' => 'required',
            'nohp_anggota' => ['required', 'regex:/^0[0-9]{9,11}$/'],
        ], [
            'nohp_anggota.regex' => 'Nomor HP harus dimulai dengan 0 dan terdiri dari 10–12 digit.'
        ]);

        $anggota->update([
            'no_anggota' => $request->no_anggota,
            'nama_anggota' => $request->nama_anggota,
            'jenis_kelamin' => $request->jenis_kelamin,
            'keanggotaan' => $request->keanggotaan,
            'nohp_anggota' => $request->nohp_anggota,
        ]);
        $pengguna = $anggota->pengguna;
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

        catatRiwayat('anggota', 'ubah', 'Mengubah data anggota: ' . $anggota->nama_anggota);


        return redirect()->back()->with('success', 'Data keanggotaan berhasil diperbarui!');
    }


    public function destroy($no_anggota)
    {
        $anggota = Anggota::where('no_anggota', $no_anggota)->first();
    
    if (!$anggota) {
        return redirect()->back()->with('error', 'Data anggota tidak ditemukan!');
    }
    
        $pengguna = $anggota->pengguna;

        $anggota->delete();
        if ($pengguna) {
            $pengguna->delete();
        }

        catatRiwayat('anggota', 'hapus', 'Menghapus data anggota: ' . $anggota->nama_anggota);


        return redirect()->back()->with('success', 'Data keanggotaan berhasil dihapus!');
    }






}
