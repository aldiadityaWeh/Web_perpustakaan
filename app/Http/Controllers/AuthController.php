<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // ==========================================
    // TAMPILAN HALAMAN (VIEW)
    // ==========================================

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

    // ==========================================
    // LOGIKA MANUAL (EMAIL & PASSWORD)
    // ==========================================

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        return redirect()->route('dashboard')->with('success', 'Pendaftaran berhasil!');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Arahkan ke dashboard admin
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

    // ==========================================
    // LOGIKA GOOGLE OAUTH (SOCIALITE)
    // ==========================================

    public function redirectToGoogle()
    {
        // Mengarahkan pengguna ke halaman login Google
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            // Menangkap data pengguna dari Google
            $googleUser = Socialite::driver('google')->user();

            // Cek apakah user dengan email ini sudah ada di database kita
            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                // Jika email sudah terdaftar (baik via manual atau google sebelumnya)
                // Kita update google_id-nya untuk berjaga-jaga, lalu login
                $user->update([
                    'google_id' => $googleUser->id,
                ]);
                Auth::login($user);
            } else {
                // Jika belum ada sama sekali, daftarkan akun baru secara otomatis
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    // Buatkan password acak karena dia login via Google
                    'password' => Hash::make(Str::random(24))
                ]);
                Auth::login($newUser);
            }

            // Setelah sukses, arahkan ke dashboard
            return redirect()->intended('/admin/dashboard');

        } catch (\Exception $e) {
            // Jika terjadi error (misal user membatalkan pilihan akun, atau timeout)
            // Kembalikan ke halaman login dengan pesan error
            return redirect()->route('login')->withErrors([
                'error' => 'Gagal masuk menggunakan Google. Silakan coba lagi.'
            ]);
        }
    }
}
