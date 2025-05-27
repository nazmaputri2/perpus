<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // tampilan form login
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $pengguna = Pengguna::where('username', $request->username)->first();

        if (!$pengguna || !Hash::check($request->password, $pengguna->password)) {
            return back()->withErrors(['login' => 'Username atau password salah']);
        }

        // Simpan data pengguna ke session
session([
    'user' => [
        'id' => $pengguna->id,
        'name' => $pengguna->name,
        'role' => $pengguna->role,
    ]
]);
        // Redirect berdasarkan role
        return redirect()->route($pengguna->role === 'petugas' ? 'petugas.beranda' : 'siswa.beranda');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login');
    }
}