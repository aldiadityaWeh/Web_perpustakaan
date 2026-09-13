<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $query = Anggota::query();

        // Logika Pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nama_lengkap', 'like', '%' . $search . '%')
                  ->orWhere('nis', 'like', '%' . $search . '%')
                  ->orWhere('kelas', 'like', '%' . $search . '%');
        }

        // Batasi 5 data per halaman sesuai permintaan
        $anggotas = $query->latest()->paginate(5)->withQueryString();

        return view('admin.anggota.index', compact('anggotas'));
    }

    public function create()
    {
        return view('admin.anggota.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // NIS dibatasi maksimal 10 karakter
            'nis' => 'required|string|unique:anggota,nis|max:10',
            'nama_lengkap' => 'required|string|max:255',
            // Kelas menerima input 1A hingga 6C
            'kelas' => 'required|string|in:1A,1B,1C,2A,2B,2C,3A,3B,3C,4A,4B,4C,5A,5B,5C,6A,6B,6C',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'nullable|string',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ], [
            'nis.max' => 'NISN/NIS maksimal 10 digit angka.',
            'kelas.in' => 'Pilihan kelas tidak valid.',
        ]);

        Anggota::create($validated);

        return redirect()->route('anggota.index')->with('success', 'Data anggota baru berhasil disimpan!');
    }

    public function show(string $id)
    {
        $anggota = Anggota::with(['peminjamans.buku'])->findOrFail($id);
        return view('admin.anggota.show', compact('anggota'));
    }

    public function edit(string $id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('admin.anggota.edit', compact('anggota'));
    }

    public function update(Request $request, string $id)
    {
        $anggota = Anggota::findOrFail($id);

        $validated = $request->validate([
            'nis' => 'required|string|max:10|unique:anggota,nis,' . $anggota->id,
            'nama_lengkap' => 'required|string|max:255',
            // Kelas menerima input 1A hingga 6C
            'kelas' => 'required|string|in:1A,1B,1C,2A,2B,2C,3A,3B,3C,4A,4B,4C,5A,5B,5C,6A,6B,6C',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'nullable|string',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ], [
            'nis.max' => 'NISN/NIS maksimal 10 digit angka.',
            'kelas.in' => 'Pilihan kelas tidak valid.',
        ]);

        $anggota->update($validated);

        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->delete();

        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil dihapus!');
    }
}
