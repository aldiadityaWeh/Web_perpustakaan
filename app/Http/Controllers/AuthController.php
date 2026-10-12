<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sekolah;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // TAMPILAN HALAMAN (VIEW)

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset-password')->with([
            'token' => $token,
            'email' => $request->email
        ]);
    }

    // ==========================================
    // LOGIKA PENDAFTARAN SAAS (MULTI-SEKOLAH)
    // ==========================================

    public function register(Request $request)
    {
        // 1. Validasi Inputan
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'name' => 'required|string|min:3|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:3|max:8',
        ], [
            'nama_sekolah.required' => 'Nama Sekolah / Instansi wajib diisi.',
            'name.required' => 'Username wajib diisi.',
            'name.min' => 'Username terlalu pendek, minimal 3 karakter.',
            'name.max' => 'Username terlalu panjang, maksimal 20 karakter.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar. Silakan gunakan email lain.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi terlalu pendek, minimal 3 karakter.',
            'password.max' => 'Kata sandi terlalu panjang, maksimal 8 karakter.',
        ]);

        try {
            // 2. Gunakan DB Transaction agar jika salah satu gagal, semuanya dibatalkan
            DB::transaction(function () use ($request) {

                // A. Buat Lemari Sekolah Baru
                $sekolah = Sekolah::create([
                    'nama_sekolah' => $request->nama_sekolah
                ]);

                // B. Buat Akun Admin untuk sekolah tersebut
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'sekolah_id' => $sekolah->id // <--- Kunci Multi-Tenancy!
                ]);

                // C. Buat Pengaturan Default untuk sekolah tersebut
                Pengaturan::create([
                    'maksimal_buku_pinjam' => 3,
                    'maksimal_hari_pinjam' => 7,
                    'denda_per_hari' => 1000,
                    'sekolah_id' => $sekolah->id
                ]);

                // D. Langsung Loginkan usernya
                Auth::login($user);
            });

            return redirect()->route('dashboard')->with('success', 'Pendaftaran Sekolah berhasil! Selamat datang di Dasbor Anda.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Pendaftaran gagal: ' . $e->getMessage()])->withInput();
        }
    }

    // ==========================================
    // LOGIKA LOGIN, LOGOUT & RESET PASSWORD
    // ==========================================

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email'], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.'
        ]);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', 'Tautan untuk mengatur ulang kata sandi telah dikirim! (Silakan cek file storage/logs/laravel.log untuk melihat tautannya).');
        }

        return back()->withErrors(['email' => 'Maaf, kami tidak dapat menemukan akun dengan alamat email tersebut.']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:3|max:8',
        ], [
            'password.min' => 'Kata sandi baru minimal 3 karakter.',
            'password.max' => 'Kata sandi baru maksimal 8 karakter.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Kata sandi Anda berhasil diatur ulang! Silakan masuk menggunakan sandi baru Anda.');
        }

        return back()->withErrors(['email' => 'Tautan sudah kedaluwarsa atau email tidak valid.']);
    }
}
