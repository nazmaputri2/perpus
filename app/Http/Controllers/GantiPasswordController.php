<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException; // Import ini untuk menangani ValidationException secara eksplisit

class GantiPasswordController extends Controller
{
    /**
     * Menangani permintaan untuk memperbarui password pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        try {
            // 1. Validasi input dari form
            // Jika validasi gagal, ValidationException akan dilempar secara otomatis oleh Laravel
            $validated = $request->validate([
                'current_password' => ['required', 'current_password'],
                'new_password' => ['required', Password::defaults(), 'confirmed'],
            ]);

            // 2. Update password di database untuk pengguna yang sedang login
            $request->user()->update([
                'password' => Hash::make($validated['new_password']),
            ]);

            // 3. Kembalikan ke halaman sebelumnya dengan pesan sukses
            return back()->with('success', 'Sandi berhasil diperbarui!');

        } catch (ValidationException $e) {
            // Tangani error validasi (misal: sandi baru tidak cocok, format sandi salah)
            // Laravel secara otomatis akan mengisi $errors bag dan mengarahkan kembali.
            // Kita bisa menambahkan flash message 'error' umum di sini jika diperlukan,
            // tetapi pesan validasi spesifik per input lebih disarankan.
            return back()->withErrors($e->errors())->withInput()->with('error', 'Ada kesalahan dalam pengisian formulir. Mohon periksa kembali.');

        } catch (\Exception $e) {
            // Tangani error lain yang tidak terduga (misal: masalah database)
            // Log error untuk debugging lebih lanjut
            \Log::error('Error saat mengubah sandi: ' . $e->getMessage());

            // Kembalikan dengan pesan error umum
            return back()->with('error', 'Terjadi kesalahan sistem. Gagal memperbarui sandi.');
        }
    }
}