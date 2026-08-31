<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    /**
     * Menampilkan halaman daftar anggota
     */
    public function index()
    {
        $anggotas = Anggota::latest()->paginate(10);
        return view('admin.anggota.index', compact('anggotas'));
    }

    /**
     * Menampilkan halaman form tambah anggota
     */
    public function create()
    {
        return view('admin.anggota.create');
    }

    /**
     * Memproses penyimpanan data anggota baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|string|unique:anggota,nis|max:50',
            'nama_lengkap' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'nullable|string',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        Anggota::create($validated);

        return redirect()->route('anggota.index')->with('success', 'Data anggota baru berhasil disimpan!');
    }

    /**
     * Menampilkan halaman detail anggota
     */
    public function show(string $id)
    {
        // Tarik data anggota sekaligus riwayat peminjamannya (beserta relasi buku)
        $anggota = Anggota::with(['peminjamans.buku'])->findOrFail($id);

        // Return ke view dengan membawa data anggota yang sudah lengkap
        return view('admin.anggota.show', compact('anggota'));
    }

    /**
     * Menampilkan halaman form edit anggota
     */
    public function edit(string $id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('admin.anggota.edit', compact('anggota'));
    }

    /**
     * Memproses update data anggota
     */
    public function update(Request $request, string $id)
    {
        $anggota = Anggota::findOrFail($id);

        $validated = $request->validate([
            'nis' => 'required|string|max:50|unique:anggota,nis,' . $anggota->id,
            'nama_lengkap' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'nullable|string',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        $anggota->update($validated);

        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil diperbarui!');
    }

    /**
     * Menghapus data anggota
     */
    public function destroy(string $id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->delete();

        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil dihapus!');
    }
}
