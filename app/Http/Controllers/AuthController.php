<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman form login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Menampilkan halaman form pendaftaran (register).
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Menampilkan halaman form lupa password.
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }
}
