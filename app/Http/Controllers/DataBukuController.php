<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use Illuminate\Support\Facades\Storage; // Pastikan ini di-import
use Illuminate\Validation\Rule;

class DataBukuController extends Controller
{
    public function index()
    {
        $buku = Buku::all();
        return view('petugas.databuku', compact('buku'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'isbn' => 'required|string|max:20|unique:buku,isbn',
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date("Y"),
            'jenis_buku' => 'required|string|in:Pelajaran,Fiksi,Non-Fiksi',
            'kelas' => ['nullable', 'string', Rule::in(['Tidak Ada', '1', '2', '3', '4', '5', '6'])],
            'sinopsis' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gambar = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            // Simpan gambar ke direktori 'public/images/buku' di dalam storage
            // Laravel akan secara otomatis menempatkannya di storage/app/public/images/buku
            $path = $file->store('images/buku', 'public');
            // Dapatkan URL yang dapat diakses publik
            $gambar = Storage::url($path);
        }

        Buku::create([
            'isbn' => $request->isbn,
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'jenis_buku' => $request->jenis_buku,
            'kelas' => $request->kelas,
            'sinopsis' => $request->sinopsis,
            'stok' => $request->stok,
            'gambar' => $gambar,
        ]);

        return redirect()->route('petugas.databuku')->with('success', 'Data buku berhasil ditambahkan');
    }

    public function update(Request $request, $isbn)
    {
        $buku = Buku::where('isbn', $isbn)->firstOrFail();

        $request->validate([
            'isbn' => ['required', 'string', 'max:20', Rule::unique('buku', 'isbn')->ignore($buku->isbn, 'isbn')],
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date("Y"),
            'jenis_buku' => 'required|string|in:Pelajaran,Fiksi,Non-Fiksi',
            'kelas' => ['nullable', 'string', Rule::in(['Tidak Ada', '1', '2', '3', '4', '5', '6'])],
            'sinopsis' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gambar = $buku->gambar;
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada dan bukan gambar default
            // Penting: Pastikan path yang disimpan di DB adalah URL dari Storage::url()
            // sehingga kita bisa mengkonversinya kembali ke path internal storage
            if ($gambar && str_contains($gambar, '/storage/images/buku/')) {
                // Konversi URL publik kembali ke path internal storage
                $oldPath = str_replace(Storage::url('/'), 'public/', $gambar);
                Storage::delete($oldPath);
            }

            $file = $request->file('gambar');
            $path = $file->store('images/buku', 'public');
            $gambar = Storage::url($path);
        }

        $buku->update([
            'isbn' => $request->isbn,
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'jenis_buku' => $request->jenis_buku,
            'kelas' => $request->kelas,
            'sinopsis' => $request->sinopsis,
            'stok' => $request->stok,
            'gambar' => $gambar,
        ]);

        return redirect()->route('petugas.databuku')->with('success', 'Buku berhasil diperbarui');
    }

    public function destroy($isbn)
    {
        $buku = Buku::where('isbn', $isbn)->firstOrFail();

        // Hapus gambar terkait jika ada
        if ($buku->gambar && str_contains($buku->gambar, '/storage/images/buku/')) {
            $oldPath = str_replace(Storage::url('/'), 'public/', $buku->gambar);
            Storage::delete($oldPath);
        }

        $buku->delete();

        return redirect()->route('petugas.databuku')->with('success', 'Buku berhasil dihapus');
    }
}