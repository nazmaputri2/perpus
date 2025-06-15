<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna; // <-- Pastikan ini diimpor
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; // <-- PENTING: Import fasad Auth

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // tampilan form login
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Coba autentikasi menggunakan Auth::attempt
        // Ini akan mencari pengguna berdasarkan username dan memverifikasi password terhash
        if (Auth::attempt($credentials)) {
            // Regenerasi session ID untuk mencegah session fixation attacks
            $request->session()->regenerate();

            $pengguna = Auth::user(); // Dapatkan instance pengguna yang sedang login

            // Redirect berdasarkan role
            return redirect()->route($pengguna->role === 'petugas' ? 'petugas.beranda' : 'siswa.beranda');
        }

        // Jika autentikasi gagal
        return back()->withErrors(['login' => 'Username atau password salah'])->withInput($request->only('username'));
    }

    public function logout(Request $request)
    {
        Auth::logout(); // <-- Gunakan Auth::logout() untuk mengeluarkan pengguna

        // Invalidasi sesi dan regenerasi token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login');
    }
}