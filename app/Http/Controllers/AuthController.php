<?php

namespace App\Http\Controllers;

// HAPUS 'use Illuminate\Routing\Controller;' DARI SINI

use Illuminate\Http\Request; // <-- Pastikan ini ada
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller // <-- Ini sekarang sudah benar
{
    /**
     * =============================================
     * Endpoint Budi Hartono (Register)
     * Materi: CRUD (Create), Validasi, Error 422
     * =============================================
     */
    public function register(Request $request)
    {
        // 1. VALIDASI INPUT (sesuai materi PDF 06)
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed', // 'confirmed' berarti harus ada 'password_confirmation'
            'role' => 'sometimes|string|in:admin,user' // 'sometimes' berarti opsional
        ]);

        // 2. ERROR HANDLING jika validasi gagal (sesuai materi PDF 06)
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422); // 422 Unprocessable Entity
        }

        // 3. CRUD - CREATE (sesuai materi PDF 04)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password di-hash
            'role' => $request->role ?? 'user', // Jika role tidak diisi, otomatis 'user'
        ]);

        // 4. Beri respon sukses
        // Sesuai materi PDF 03 & 06, kirim status 201 Created
        return response()->json([
            'message' => 'Registrasi pengguna berhasil'
        ], 201); // 201 Created
    }

    /**
     * =============================================
     * Endpoint Ossa Amelia (Login)
     * Materi: Autentikasi JWT, Error 401
     * =============================================
     */
    public function login(Request $request)
    {
        // 1. Ambil email & password dari request
        $credentials = $request->only('email', 'password');

        // 2. Coba Autentikasi dan buat token
        // Ini adalah inti dari materi PDF 09
        if (!$token = JWTAuth::attempt($credentials)) {
            // 3. ERROR HANDLING jika email/password salah
            // Sesuai materi PDF 06, kirim error 401 Unauthorized
            return response()->json(['error' => 'Kredensial tidak valid (Unauthorized)'], 401);
        }

        // 4. Berhasil, kembalikan TOKEN JWT
        // Sesuai materi PDF 09, kirim token-nya ke client
        return response()->json([
            'message' => 'Login berhasil',
            'token' => $token
        ], 200); // 200 OK
    }
}