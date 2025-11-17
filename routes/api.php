<?php

// INI ADALAH BAGIAN YANG BENAR
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Di sinilah kita mendaftarkan semua "Daftar Menu" API kita.
| Ini adalah implementasi dari materi Routing (PDF 04).
|
*/

// ===============================================
// 📍 Endpoint Publik (Tidak Perlu Login)
// ===============================================

// Endpoint Budi Hartono (Register)
// Materi: CRUD (Create)
Route::post('/register', [AuthController::class, 'register']);

// Endpoint Ossa Amelia (Login)
// Materi: Autentikasi JWT (PDF 09)
Route::post('/login', [AuthController::class, 'login']);


// ===============================================
// 🔐 Endpoint Terproteksi (HARUS Punya Token JWT)
// Materi: Autentikasi REST API (PDF 09)
// ===============================================
Route::group(['middleware' => 'auth:api'], function () {

    // Endpoint Citra Lestari (Melihat semua produk)
    // Materi: CRUD (Read)
    // Satpam: Hanya perlu login (role apapun boleh)
    Route::get('/products', [ProductController::class, 'index']);

    
    // ===============================================
    // 👑 Endpoint KHUSUS ADMIN
    // Materi: Otorisasi RBAC (PDF 11)
    // ===============================================
    Route::group(['middleware' => 'role:admin'], function () {
    
        // Endpoint Dewi Anggraini (Update produk)
        // Materi: CRUD (Update)
        // Satpam: Harus login ('auth:api') + Role harus 'admin' ('role:admin')
        Route::put('/products/{id}', [ProductController::class, 'update']);
    
        // Endpoint Eka Wijaya (Melihat semua user)
        // Materi: CRUD (Read)
        // Satpam: Harus login ('auth:api') + Role harus 'admin' ('role:admin')
        Route::get('/users', [UserController::class, 'index']);

    }); // Akhir grup khusus admin

}); // Akhir grup terproteksi (harus login)

Route::get('/login', function () {
    return response()->json([
        'error' => 'Anda belum login atau token tidak valid. (Unauthorized)'
    ], 401);
})->name('login');