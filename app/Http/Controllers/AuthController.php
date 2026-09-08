<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

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
        // Menampilkan halaman buat sandi baru dengan membawa token rahasia
        return view('auth.reset-password')->with([
            'token' => $token, 
            'email' => $request->email
        ]);
    }

    // LOGIKA MANUAL (EMAIL & PASSWORD)

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:3|max:8',
        ], [
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

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan masuk menggunakan akun Anda.');
    }

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

    // LOGIKA LUPA & RESET PASSWORD

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
            // Sukses ganti password, arahkan ke login
            return redirect()->route('login')->with('success', 'Kata sandi Anda berhasil diatur ulang! Silakan masuk menggunakan sandi baru Anda.');
        }

        return back()->withErrors(['email' => 'Tautan sudah kedaluwarsa atau email tidak valid.']);
    }
}