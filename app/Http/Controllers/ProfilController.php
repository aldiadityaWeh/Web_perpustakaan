<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfilController extends Controller
{
    // Menampilkan Halaman Profil
    public function index()
    {
        $user = Auth::user(); // Mengambil data admin yang sedang login
        return view('admin.profil.index', compact('user'));
    }

    // Memproses Perubahan Profil & Password
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            // Validasi email unik, TAPI abaikan jika emailnya milik user ini sendiri
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],

            // Validasi Password (Opsional: hanya wajib jika form password diisi)
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed', // Harus cocok dengan new_password_confirmation
        ]);

        // 1. Update Nama & Email
        $user->name = $request->name;
        $user->email = $request->email;

        // 2. Jika Admin mengisi kolom Password Baru
        if ($request->filled('new_password')) {
            // Cek apakah password lama yang dimasukkan cocok dengan di database
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password lama yang Anda masukkan salah.']);
            }

            // Enkripsi dan simpan password baru
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return back()->with('success', 'Profil dan pengaturan akun berhasil diperbarui!');
    }
}
