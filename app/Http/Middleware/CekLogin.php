<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- PENTING: Import fasad Auth

class CekLogin
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) { // <-- Gunakan Auth::check()
            // Jika ini permintaan AJAX, kembalikan respons JSON 401
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            // Jika bukan permintaan AJAX, redirect ke halaman login
            return redirect()->route('auth.login')->with('error', 'Anda harus login untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}