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
    public function index(Request $request)
    {
    // Security RBAC - Cek apakah user adalah ADMIN
    if ($request->user()->role !== 'admin') {
        return response()->json([
            'message' => 'Forbidden: Admin only.'
        ], 403);
    }

    // Ambil semua user
    $users = User::all();

    // Response JSON
    return response()->json($users, 200);
    }

}