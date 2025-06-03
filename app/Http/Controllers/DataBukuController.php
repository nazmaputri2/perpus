<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use Illuminate\Support\Facades\Storage;

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
            'isbn' => 'required|unique:buku,isbn',
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer',
            'sinopsis' => 'nullable|string',
            'stok' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        $gambar = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/'), $filename);
            $gambar = 'images//' . $filename;
        }
    
        Buku::create([
            'isbn' => $request->isbn,
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'sinopsis' => $request->sinopsis,
            'stok' => $request->stok,
            'gambar' => $gambar,
        ]);
    
        return redirect()->route('petugas.databuku')->with('success', 'Data buku berhasil ditambahkan');
    }

    public function updateBuku(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $request->validate([
            'isbn' => 'required|unique:buku,isbn,' . $buku->id,
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahunterbit' => 'required|integer',
            'sinopsis' => 'nullable|string',
            'stok' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gambar = $buku->gambar;
        if ($request->hasFile('gambar')) {
            if ($gambar) {
                Storage::disk('public')->delete($gambar);
            }
            $gambar = $request->file('gambar')->store('gambar_buku', 'public');
        }

        $buku->update([
            'isbn' => $request->isbn,
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahunterbit' => $request->tahunterbit,
            'sinopsis' => $request->sinopsis,
            'stok' => $request->stok,
            'gambar' => $gambar,
        ]);

        return redirect()->route('petugas.databuku')->with('success', 'Buku berhasil diperbarui');
    }

    public function deleteBuku($id)
    {
        $buku = Buku::findOrFail($id);

        if ($buku->gambar) {
            Storage::disk('public')->delete($buku->gambar);
        }

        $buku->delete();

        return redirect()->route('petugas.databuku')->with('success', 'Buku berhasil dihapus');
    }
}
