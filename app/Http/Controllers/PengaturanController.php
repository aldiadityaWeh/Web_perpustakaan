<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PengaturanController extends Controller
{
    // Fungsi bantuan untuk mengecek apakah yang login adalah Admin Utama (ID = 1)
    private function cekAdminUtama()
    {
        if (Auth::id() !== 1) {
            abort(403, 'Akses Ditolak! Hanya Admin Utama yang dapat membuka Pengaturan Sistem.');
        }
    }

    public function index()
    {
        $this->cekAdminUtama(); // <-- Kunci halaman

        $pengaturan = Pengaturan::first() ?? new Pengaturan();
        $petugas = User::latest()->get();

        return view('admin.pengaturan.index', compact('pengaturan', 'petugas'));
    }

    public function update(Request $request)
    {
        $this->cekAdminUtama(); // <-- Kunci proses update

        $validated = $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'alamat_sekolah' => 'nullable|string',
            'kepala_sekolah' => 'nullable|string|max:255',
            'nip_kepala_sekolah' => 'nullable|string|max:50',
            'kepala_perpustakaan' => 'nullable|string|max:255',
            'nip_kepala' => 'nullable|string|max:255',
            'denda_per_hari' => 'required|numeric|min:0',
            'maksimal_hari_pinjam' => 'required|integer|min:1',
            'maksimal_buku_pinjam' => 'required|integer|min:1',
        ]);

        $pengaturan = Pengaturan::first();

        if ($pengaturan) {
            $pengaturan->update($validated);
        } else {
            Pengaturan::create($validated);
        }

        return redirect()->route('pengaturan.index')->with('success', 'Pengaturan sistem berhasil diperbarui!');
    }

    public function storePetugas(Request $request)
    {
        $this->cekAdminUtama(); // <-- Kunci tambah petugas

        $request->validate([
            'name' => 'required|string|min:3|max:50',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('pengaturan.index')->with('success', 'Akun petugas baru berhasil ditambahkan!');
    }

    public function destroyPetugas($id)
    {
        $this->cekAdminUtama(); // <-- Kunci hapus petugas

        // Proteksi ganda: Akun ID 1 tidak akan pernah bisa dihapus
        if ($id == 1 || Auth::id() == $id) {
            return redirect()->route('pengaturan.index')->with('error', 'Akun Utama tidak dapat dihapus!');
        }

        User::findOrFail($id)->delete();

        return redirect()->route('pengaturan.index')->with('success', 'Akun petugas berhasil dihapus.');
    }

    public function updatePetugas(Request $request, $id)
    {
       $this->cekAdminUtama();

        // Cegah edit akun utama lewat menu ini karena sudah ada menu Profil
        if ($id == 1 || Auth::id() == $id) {
            return redirect()->route('pengaturan.index')->with('error', 'Silakan gunakan menu Profil Saya untuk mengubah data Admin Utama.');
        }

        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|min:3|max:50',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:4',
        ], [
            'name.required' => 'Nama petugas wajib diisi.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
            'password.min' => 'Kata sandi baru minimal 4 karakter.',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        // Jika Admin Utama mengisi kolom password baru, maka reset password-nya
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('pengaturan.index')->with('success', 'Data / Kata sandi petugas ' . $user->name . ' berhasil diperbarui!');
    }
}
