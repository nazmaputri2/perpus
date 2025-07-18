<?php

namespace App\Http\Controllers;
use App\Models\Petugas;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class PetugasController extends Controller
{
public function index(Request $request)
{
    $query = Petugas::query();

    // Filter pencarian
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('nip', 'like', "%{$search}%")
              ->orWhere('nama', 'like', "%{$search}%")
              ->orWhere('nohp', 'like', "%{$search}%")
              ->orWhere('alamat', 'like', "%{$search}%");
        });
    }

    // Paginate 10 data per halaman dan sertakan query string agar search tetap terbawa
    $petugas = $query->orderBy('nama')->paginate(10)->withQueryString();

    return view('petugas.datapetugas', compact('petugas'));
}
    public function store(Request $request)
    {
        \Log::info('Request masuk ke store:', $request->all());

        // Validasi data petugas + username/password
        $request->validate([
            'nip' => 'required|unique:petugas,nip',
            'nama' => 'required',
            'alamat' => 'required',
            'nohp' => ['required', 'regex:/^0[0-9]{9,11}$/'],
        ], [
            'nip.unique' => 'NIP ini sudah terdaftar. Harap gunakan NIP yang lain.',
            'nohp.regex' => 'Nomor HP harus dimulai dengan 0 dan terdiri dari 10–12 digit.'
        ]);
        \Log::info('Validasi sukses');

        $baseUsername = strtolower(str_replace(' ', '', $request->nama));
        $username = $baseUsername . rand(100, 999); // Tambahkan angka acak untuk memastikan unik

        $defaultPassword = 'petugas123'; // Password default, bisa diubah sesuai kebutuhan
        $hashedPassword = Hash::make($defaultPassword); // Enkripsi password

        // Buat akun pengguna dulu
        $pengguna = Pengguna::create([
            'username' => $request->nip,
            'password' => $hashedPassword, // Enkripsi password
            'role' => 'petugas',
        ]);

        // Buat data petugas dan hubungkan ke akun pengguna
        Petugas::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'nohp' => $request->nohp ?? null, // Gunakan null jika tidak ada input
            'alamat' => $request->alamat,
            'id_user' => $pengguna->id_user,
        ]);

         catatRiwayat('petugas', 'tambah', 'Menambahkan data petugas: ' . $request->nama);


        return redirect()->back()->with('success', 'Data petugas berhasil dibuat!');
    }

   public function update(Request $request, $nip)
{
    $petugas = Petugas::where('nip', $nip)->firstOrFail();

    // Validasi tanpa unique (seperti siswa)
    $request->validate([
        'nip' => 'required',
        'nama' => 'required',
        'alamat' => 'required',
        'nohp' => ['required', 'regex:/^0[0-9]{9,11}$/'],
    ], [
        'nohp.regex' => 'Nomor HP harus dimulai dengan 0 dan terdiri dari 10–12 digit.'
    ]);

    $petugas->update([
        'nip' => $request->nip,
        'nama' => $request->nama,
        'nohp' => $request->nohp,
        'alamat' => $request->alamat,
    ]);

        
        $pengguna = $petugas->pengguna;
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
                catatRiwayat('petugas', 'ubah', 'Mengubah data petugas: ' . $petugas->nama);


        return redirect()->back()->with('success', 'Data petugas berhasil diperbarui!');
    }
    
    public function destroy($nip)
{
    // Cari berdasarkan NIP dengan where, bukan findOrFail
    $petugas = Petugas::where('nip', $nip)->first();
    
    if (!$petugas) {
        return redirect()->back()->with('error', 'Data petugas tidak ditemukan!');
    }
    
    $pengguna = $petugas->pengguna;
    
    $petugas->delete();
    if ($pengguna) {
        $pengguna->delete();
    }
            catatRiwayat('petugas', 'hapus', 'Menghapus data petugas: ' . $petugas->nama);

    
    return redirect()->back()->with('success', 'Data petugas berhasil dihapus!');
}
}