<?php

namespace App\Http\Controllers;
use App\Models\Anggota;
use Illuminate\Http\Request;
use App\Models\Buku;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log; // Tambahkan ini untuk debugging

class DataBukuController extends Controller
{
public function index()
{
    // Ambil 10 data buku terbaru (urut dari yang terbaru berdasarkan created_at atau id)
    $buku = Buku::latest()->paginate(10); // <-- ini pagination utama

    // Ambil data siswa untuk modal peminjaman
    $anggota = Anggota::select('no_anggota', 'nama_anggota', 'keanggotaan')
                ->orderBy('keanggotaan')
                ->orderBy('nama_anggota')
                ->get();

    // Ambil data unik kategori & kelas untuk keperluan filter dropdown
    $kategoriOptions = Buku::select('jenis_buku')->distinct()->pluck('jenis_buku')->filter()->sort()->values()->all();
    $kelasOptions = Buku::select('kelas')->distinct()->pluck('kelas')->filter()->sort()->values()->all();

    // Kirim semua data ke view
    return view('petugas.databuku', compact('buku', 'anggota', 'kategoriOptions', 'kelasOptions'));
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
            'kelas' => ['nullable', 'string', Rule::in(['Tidak Ada', '1', '2', '3', '4', '5', '6', 'guru'])],
            'sinopsis' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gambar = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $path = $file->store('images/buku', 'public'); // Simpan ke storage/app/public/images/buku
            $gambar = Storage::url($path); // Dapatkan URL publik: /storage/images/buku/namafile.png
            Log::info("DataBukuController@store: Gambar baru diupload. Path disimpan ke DB: {$gambar}");
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
            'gambar' => $gambar, // Simpan URL publik ke database
        ]);

 catatRiwayat('buku', 'menambah', 'Menambahkan buku berjudul: ' . $request->judul);

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
            'kelas' => ['nullable', 'string', Rule::in(['Tidak Ada', '1', '2', '3', '4', '5', '6', 'guru'])],
            'sinopsis' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gambar = $buku->gambar; // Ambil path gambar yang sudah ada dari DB
        if ($request->hasFile('gambar')) { // Jika ada file gambar baru yang diupload
            // Hapus gambar lama jika ada dan bukan gambar default
            if ($gambar && str_starts_with($gambar, '/storage/images/buku/')) { // Pastikan itu URL gambar kita
                // Konversi URL publik kembali ke path internal storage untuk penghapusan
                $oldPath = ltrim($gambar, '/storage/'); // Menghapus '/storage/' di awal
                Storage::disk('public')->delete($oldPath);
                Log::info("DataBukuController@update: Gambar lama dihapus: {$oldPath}");
            }

            $file = $request->file('gambar');
            $path = $file->store('images/buku', 'public'); // Simpan gambar baru
            $gambar = Storage::url($path); // Dapatkan URL publik baru
            Log::info("DataBukuController@update: Gambar baru diupload. Path disimpan ke DB: {$gambar}");
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
            'gambar' => $gambar, // Simpan URL publik yang diperbarui
        ]);

        catatRiwayat('buku', 'mengubah', 'Mengubah data buku: ' . $request->judul);

        return redirect()->route('petugas.databuku')->with('success', 'Buku berhasil diperbarui');
    }

    public function destroy($isbn)
    {
        $buku = Buku::where('isbn', $isbn)->firstOrFail();

        // Hapus gambar terkait jika ada
        if ($buku->gambar && str_starts_with($buku->gambar, '/storage/images/buku/')) {
            $pathToDelete = ltrim($buku->gambar, '/storage/'); // Konversi URL publik ke path internal
            Storage::disk('public')->delete($pathToDelete);
            Log::info("DataBukuController@destroy: Gambar dihapus: {$pathToDelete}");
        }

        $buku->delete();

         catatRiwayat('buku', 'menghapus', 'Menghapus buku berjudul: ' . $buku->judul);

        return redirect()->route('petugas.databuku')->with('success', 'Buku berhasil dihapus');
    }
}