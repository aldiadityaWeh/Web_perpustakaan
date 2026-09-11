<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::query();

        // Logika Live Search AJAX & Pencarian Buku (Judul, Pengarang, ISBN, Kategori)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('pengarang', 'like', '%' . $search . '%')
                  ->orWhere('isbn', 'like', '%' . $search . '%')
                  ->orWhere('kategori', 'like', '%' . $search . '%');
            });
        }

        // Batasi 5 data per halaman dengan pagination
        $bukus = $query->latest()->paginate(5)->withQueryString();

        // Jika request datang dari AJAX (Live Search), kembalikan hanya bagian tabelnya saja
        if ($request->ajax()) {
            return view('admin.buku.index', compact('bukus'));
        }

        return view('admin.buku.index', compact('bukus'));
    }

    public function create()
    {
        return view('admin.buku.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'isbn' => 'required|string|unique:buku,isbn|max:50',
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'kategori' => 'required|string|max:100',
            'stok' => 'required|integer|min:0',
            'rak' => 'required|string|max:50', // Wajib ada agar tidak error 1364
            'gambar_sampul' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Tangani proses upload gambar sampul jika ada
        if ($request->hasFile('gambar_sampul')) {
            $validated['gambar_sampul'] = $request->file('gambar_sampul')->store('sampul-buku', 'public');
        }

        Buku::create($validated);

        return redirect()->route('buku.index')->with('success', 'Data buku baru berhasil disimpan!');
    }

    public function show(string $id)
    {
        $buku = Buku::findOrFail($id);
        return view('admin.buku.show', compact('buku'));
    }

    public function edit(string $id)
    {
        $buku = Buku::findOrFail($id);
        return view('admin.buku.edit', compact('buku'));
    }

    public function update(Request $request, string $id)
    {
        $buku = Buku::findOrFail($id);

        $validated = $request->validate([
            'isbn' => 'required|string|max:50|unique:buku,isbn,' . $buku->id,
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'kategori' => 'required|string|max:100',
            'stok' => 'required|integer|min:0',
            'rak' => 'required|string|max:50', // Wajib ada
            'gambar_sampul' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Jika ada upload gambar baru, hapus gambar lama lalu simpan yang baru
        if ($request->hasFile('gambar_sampul')) {
            if ($buku->gambar_sampul) {
                Storage::disk('public')->delete($buku->gambar_sampul);
            }
            $validated['gambar_sampul'] = $request->file('gambar_sampul')->store('sampul-buku', 'public');
        }

        $buku->update($validated);

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $buku = Buku::findOrFail($id);

        // Hapus file gambar dari storage jika ada
        if ($buku->gambar_sampul) {
            Storage::disk('public')->delete($buku->gambar_sampul);
        }

        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil dihapus!');
    }
}
