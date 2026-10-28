<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        // Ambil data pengaturan baris pertama (ID = 1)
        // Jika karena suatu alasan data kosong, buat instance kosong agar halaman tidak error
        $pengaturan = Pengaturan::first() ?? new Pengaturan();

        return view('admin.pengaturan.index', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        // Validasi input (termasuk data Kepala Sekolah yang baru)
        $validated = $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'alamat_sekolah' => 'nullable|string',
            'kepala_sekolah' => 'nullable|string|max:255',     // <-- Ditambahkan
            'nip_kepala_sekolah' => 'nullable|string|max:50',  // <-- Ditambahkan
            'kepala_perpustakaan' => 'nullable|string|max:255',
            'nip_kepala' => 'nullable|string|max:255',
            'denda_per_hari' => 'required|numeric|min:0',
            'maksimal_hari_pinjam' => 'required|integer|min:1',
            'maksimal_buku_pinjam' => 'required|integer|min:1',
        ]);

        $pengaturan = Pengaturan::first();

        if ($pengaturan) {
            // Update jika data ada
            $pengaturan->update($validated);
        } else {
            // Fallback jika tidak ada data sama sekali, maka create baru
            Pengaturan::create($validated);
        }

        return redirect()->route('pengaturan.index')->with('success', 'Pengaturan sistem berhasil diperbarui!');
    }
}
