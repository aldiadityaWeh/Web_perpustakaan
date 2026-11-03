<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Cek apakah pengguna sudah login dan rolenya sesuai dengan yang diminta
        if (auth()->check() && auth()->user()->role === $role) {
            return $next($request);
        }

        // Jika bukan admin, tolak akses dengan pesan error 403
        abort(403, 'Akses Ditolak! Hanya Admin yang boleh mengakses halaman atau aksi ini.');
    }
}
