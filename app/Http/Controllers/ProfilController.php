<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Validation\Rule; // (Sudah dihapus karena tidak lagi memvalidasi email unik)

class ProfilController extends Controller
{
    // Menampilkan Halaman Profil
    public function index()
    {
        $user = Auth::user(); // Mengambil data user yang sedang login
        return view('admin.profil.index', compact('user'));
    }

    // Memproses Perubahan Password Saja
    public function update(Request $request)
    {
        // 1. Validasi KHUSUS untuk form kata sandi (Nama & Email sepenuhnya diabaikan)
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:4|confirmed',
        ], [
            'current_password.required' => 'Kata sandi saat ini wajib diisi.',
            'new_password.required' => 'Kata sandi baru wajib diisi.',
            'new_password.min' => 'Kata sandi baru minimal 4 karakter.',
            'new_password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $user = Auth::user();

        // 2. Cek kecocokan kata sandi lama
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi lama yang Anda masukkan salah.']);
        }

        // 3. Enkripsi dan simpan kata sandi baru
        $user->password = Hash::make($request->new_password);
        $user->save();

        // 4. Kembali dengan pesan sukses
        return back()->with('success', 'Kata sandi berhasil diperbarui demi keamanan akun!');
    }
}
