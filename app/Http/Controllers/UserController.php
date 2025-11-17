<?php

namespace App\Http\Controllers;

// use Illuminate\Routing\Controller; // <-- HAPUS JIKA ADA BARIS INI
use Illuminate\Http\Request; // <-- Pastikan ini ada
use App\Models\User;

class UserController extends Controller // <-- project-api-kelompokIni sudah benar
{
    /**
     * =============================================
     * Endpoint Eka Wijaya (Get All Users)
     * Materi: CRUD (Read), Format JSON
     * =============================================
     */
    public function index()
    {
        // Security RBAC - Cek apakah user adalah ADMIN
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Forbidden: Admin only.'
            ], 403);
        }

        // 1. CRUD - READ (sesuai materi PDF 04)
        // Ambil semua data dari Model User

        $users = User::all();

        // 2. Kembalikan data sebagai JSON (sesuai materi PDF 02)
        return response()->json($users, 200); // 200 OK
    }
}