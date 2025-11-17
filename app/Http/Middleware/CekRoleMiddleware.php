<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import class Auth
use Symfony\Component\HttpFoundation\Response;

class CekRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  ...$roles  // Ini adalah peran yang diizinkan (misal: 'admin')
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek dulu, user-nya sudah login (autentikasi) belum?
        // Sesuai materi PDF 11, otorisasi hanya untuk user yang ter-autentikasi.
        if (!Auth::check()) {
            return response()->json(['error' => 'Anda harus login (Unauthorized)'], 401); // 401 Unauthorized
        }

        // 2. Ambil data user yang sedang login
        $user = Auth::user();

        // 3. Cek apakah role user ada di daftar $roles yang diizinkan
        // Ini adalah logika Otorisasi RBAC (PDF 11)
        foreach ($roles as $role) {
            if ($user->role == $role) {
                return $next($request); // DI-IZINKAN Lanjut ke Koki (Controller)
            }
        }

        // 4. DITOLAK!
        // Jika loop selesai dan tidak ada role yang cocok, user ditolak.
        // Sesuai materi PDF 06, kirim error 403 Forbidden.
        return response()->json(['error' => 'Akses ditolak. Anda tidak memiliki hak (Forbidden).'], 403);
    }
}