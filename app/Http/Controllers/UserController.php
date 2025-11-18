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
        // Ambil semua user
        $users = User::all();

        // Kembalikan dalam format JSON
        return response()->json($users, 200);
    }

}