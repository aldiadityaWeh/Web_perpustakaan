<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    // Menentukan nama file tempat menyimpan pengaturan
    private $file_path = 'pengaturan.json';

    public function index()
    {
        // Ambil data dari JSON
        $pengaturan = $this->getPengaturan();

        // Tampilkan ke halaman view
        return view('admin.pengaturan.index', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        // Validasi inputan dari form
        $validated = $request->validate([
            'alamat_sekolah' => 'required|string|max:255',
            'kepala_sekolah' => 'required|string|max:255',
            'nip_kepala_sekolah' => 'required|string|max:255',
            'maksimal_hari' => 'required|integer|min:1',
            'maksimal_buku' => 'required|integer|min:1',
            'denda_per_hari' => 'required|integer|min:0',
        ]);

        // Simpan data (ditimpa) ke dalam file pengaturan.json
        Storage::disk('local')->put($this->file_path, json_encode($validated, JSON_PRETTY_PRINT));

        return redirect()->route('pengaturan.index')->with('success', 'Pengaturan sistem berhasil diperbarui!');
    }

    /**
     * Fungsi bantuan untuk membaca file JSON
     */
    private function getPengaturan()
    {
        // Jika file pengaturan.json sudah ada, baca isinya
        if (Storage::disk('local')->exists($this->file_path)) {
            $data = json_decode(Storage::disk('local')->get($this->file_path), true);
            return (object) $data; // Diubah jadi Object agar cocok dengan tampilan Blade (->)
        }

        // Jika file BELUM ADA, gunakan nilai default ini
        return (object) [
            'alamat_sekolah' => 'Purwakarta',
            'kepala_sekolah' => 'Budi Sudarsono, S.Pd',
            'nip_kepala_sekolah' => '19801234 200501 1 001',
            'maksimal_hari' => 7,
            'maksimal_buku' => 2,
            'denda_per_hari' => 500,
        ];
    }
}
