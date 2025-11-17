<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // 👇 INI WAJIB ADA untuk izin update massal
    protected $fillable = [
        'nama_produk',
        'stok',
        'harga',
    ];
}