<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index()
    {
        // Ambil data user yang sedang login.
        // Jika masih mode simulasi (belum ada auth), gunakan data dummy agar tidak error.
        $user = Auth::user() ?? (object) [
            'name' => 'Administrator',
            'email' => 'admin@perpustakaan.com',
        ];

        return view('admin.profil.index', compact('user'));
    }

    public function update(Request $request)
    {
        // Simulasi jika belum ada sistem Auth
        if (!Auth::check()) {
            return back()->with('success', 'Informasi profil berhasil diperbarui! (Mode Simulasi)');
        }

        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        // Simpan ke database
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Informasi profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        // Simulasi jika belum ada sistem Auth
        if (!Auth::check()) {
            return back()->with('success', 'Kata sandi berhasil diperbarui! (Mode Simulasi)');
        }

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Cek apakah password lama yang dimasukkan benar
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini tidak cocok dengan catatan kami.']);
        }

        // Ganti password di database
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Kata sandi Anda berhasil diperbarui!');
    }
}
