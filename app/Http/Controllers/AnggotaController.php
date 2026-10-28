<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Pengaturan;
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

        // Ambil daftar kelas yang unik dari database untuk Dropdown Cetak Massal
        $kelasTersedia = Anggota::select('kelas')
            ->whereNotNull('kelas')
            ->distinct()
            ->orderBy('kelas')
            ->pluck('kelas');

        return view('admin.anggota.index', compact('anggotas', 'kelasTersedia'));
    }

    public function create()
    {
        return view('admin.anggota.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|string|unique:anggota,nis|max:10',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100', // <-- Ditambahkan
            'tanggal_lahir' => 'required|date',          // <-- Ditambahkan
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
            'tempat_lahir' => 'required|string|max:100', // <-- Ditambahkan
            'tanggal_lahir' => 'required|date',          // <-- Ditambahkan
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

    // Fungsi untuk Cetak 1 Kartu
    public function cetakKartu($id)
    {
        // Ubah menjadi collection (menggunakan where dan get) agar foreach di cetak-kartu.blade.php tidak error
        $anggota = Anggota::where('id', $id)->get();
        $pengaturan = Pengaturan::first() ?? new Pengaturan();

        return view('admin.anggota.cetak-kartu', compact('anggota', 'pengaturan'));
    }

    // Fungsi Baru untuk Cetak Massal Per Kelas
    public function cetakMassal(Request $request)
    {
        $request->validate([
            'kelas' => 'required|string'
        ]);

        // Tarik semua anggota yang kelasnya sesuai, diurutkan berdasarkan nama
        $anggota = Anggota::where('kelas', $request->kelas)->orderBy('nama_lengkap')->get();
        $pengaturan = Pengaturan::first() ?? new Pengaturan();

        if ($anggota->isEmpty()) {
            return back()->with('error', 'Tidak ada siswa di kelas tersebut.');
        }

        return view('admin.anggota.cetak-kartu', compact('anggota', 'pengaturan'));
    }
}
