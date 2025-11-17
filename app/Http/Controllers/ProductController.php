<?php

namespace App\Http\Controllers;

// HAPUS 'use Illuminate\Routing\Controller;' DARI SINI

use Illuminate\Http\Request; // <-- Pastikan ini ada
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class ProductController extends Controller // <-- Ini sekarang sudah benar
{
    /**
     * =============================================
     * Endpoint Citra Lestari (Get All Products)
     * Materi: CRUD (Read), Format JSON
     * =============================================
     */
    public function index()
    {
        // 1. CRUD - READ (sesuai materi PDF 04)
        // Ambil semua data dari Model Product
        $products = Product::all();

        // 2. Kembalikan data sebagai JSON (sesuai materi PDF 02)
        return response()->json($products, 200); // 200 OK
    }

    /**
     * =============================================
     * Endpoint Dewi Anggraini (Update Product)
     * Materi: CRUD (Update), Validasi, Error 404 & 422
     * =============================================
     */
    public function update(Request $request, $id)
    {
        // 1. VALIDASI INPUT (sesuai materi PDF 06)
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required|string|max:255',
            'stok' => 'required|integer|min:0', // 'min:0' agar stok tidak minus
            'harga' => 'required|integer|min:0', // 'min:0' agar harga tidak minus
        ]);

        // 2. ERROR HANDLING jika validasi gagal (sesuai materi PDF 06)
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422); // 422 Unprocessable Entity
        }

        // 3. Cari produk berdasarkan $id
        $product = Product::find($id);

        // 4. ERROR HANDLING jika produk tidak ada (sesuai materi PDF 06)
        if (!$product) {
            return response()->json(['error' => 'Produk tidak ditemukan (Not Found)'], 404); // 404 Not Found
        }

        // 5. CRUD - UPDATE (sesuai materi PDF 04)
        $product->update([
            'nama_produk' => $request->nama_produk,
            'stok' => $request->stok,
            'harga' => $request->harga,
        ]);

        // 6. Beri respon sukses
        return response()->json([
            'message' => 'Produk berhasil diperbarui',
            'data' => $product
        ], 200); // 200 OK
    }
}