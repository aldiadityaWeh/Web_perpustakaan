<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // ==========================================
    // TAMPILAN HALAMAN (VIEW)
    // ==========================================

    public function showLoginForm()
    {
        // Cegah user yang sudah login untuk kembali ke halaman login
        if (Auth::check()) {
            return redirect()->intended('/admin/dashboard');
        }
        return view('auth.login');
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
            
            // Redirect langsung ke dashboard admin setelah berhasil login
            return redirect()->intended('/admin/dashboard')->with('success', 'Selamat datang kembali!');
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

        return redirect('/login')->with('success', 'Anda telah berhasil logout dari sistem.');
    }

    // ==========================================
    // LOGIKA LUPA PASSWORD (TETAP DIPERTAHANKAN)
    // ==========================================

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email'], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.'
        ]);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', 'Tautan untuk mengatur ulang kata sandi telah dikirim! (Silakan cek log email lokal Anda).');
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