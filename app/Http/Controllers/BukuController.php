<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Wajib untuk fitur hapus/update foto

class BukuController extends Controller
{
    /**
     * 1. Menampilkan Halaman Daftar Buku
     */
    public function index()
    {
        // Menggunakan paginate agar tabel terbagi per halaman
        $bukus = Buku::latest()->paginate(10);
        return view('admin.buku.index', compact('bukus'));
    }

    /**
     * 2. Menampilkan Form Tambah Buku
     */
    public function create()
    {
        return view('admin.buku.create');
    }

    /**
     * 3. Memproses Data dari Form Tambah Buku ke Database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isbn' => 'required|string|unique:buku,isbn|max:50',
            'pengarang' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|digits:4|integer',
            'kategori' => 'required|string',
            'stok' => 'required|integer|min:1',
            'rak' => 'required|string|max:50',
            'gambar_sampul' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('gambar_sampul')) {
            $path = $request->file('gambar_sampul')->store('sampul_buku', 'public');
            $validated['gambar_sampul'] = $path;
        }

        Buku::create($validated);

        return redirect()->route('buku.index')->with('success', 'Data buku baru berhasil disimpan ke sistem!');
    }

    /**
     * 4. Menampilkan Detail Buku (Tombol Mata)
     */
    public function show(string $id)
    {
        $buku = Buku::findOrFail($id);
        return view('admin.buku.show', compact('buku'));
    }

    /**
     * 5. Menampilkan Form Edit Buku (Tombol Pensil)
     */
    public function edit(string $id)
    {
        // Mengambil data buku berdasarkan ID untuk diisi ke dalam form
        $buku = Buku::findOrFail($id);
        return view('admin.buku.edit', compact('buku'));
    }

    /**
     * 6. Memproses Update Data ke Database
     */
    public function update(Request $request, string $id)
    {
        $buku = Buku::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            // Pengecualian unik agar tidak bentrok dengan ISBN-nya sendiri saat diupdate
            'isbn' => 'required|string|max:50|unique:buku,isbn,' . $buku->id,
            'pengarang' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|digits:4|integer',
            'kategori' => 'required|string',
            'stok' => 'required|integer|min:0',
            'rak' => 'required|string|max:50',
            'gambar_sampul' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Jika user upload foto baru saat edit
        if ($request->hasFile('gambar_sampul')) {
            // Hapus foto lama dari folder storage (jika sebelumnya ada foto)
            if ($buku->gambar_sampul) {
                Storage::disk('public')->delete($buku->gambar_sampul);
            }
            // Simpan foto yang baru
            $validated['gambar_sampul'] = $request->file('gambar_sampul')->store('sampul_buku', 'public');
        }

        // Update data di database
        $buku->update($validated);

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil diperbarui!');
    }

    /**
     * 7. Menghapus Data Buku (Tombol Sampah)
     */
    public function destroy(string $id)
    {
        $buku = Buku::findOrFail($id);

        // Hapus file foto dari server/storage jika buku ini punya foto
        if ($buku->gambar_sampul) {
            Storage::disk('public')->delete($buku->gambar_sampul);
        }

        // Hapus datanya dari database
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus dari sistem!');
    }
}
