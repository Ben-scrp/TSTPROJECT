<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject; // <-- 1. Import kontrak JWT

class User extends Authenticatable implements JWTSubject // <-- 2. Implement kontrak JWT
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi massal.
     * Kita tambahkan 'role' di sini.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // <-- 3. Tambahkan 'role'
    ];

    /**
     * Kolom yang disembunyikan saat di-return sebagai JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Tipe data kolom.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Otomatis hash password
    ];

    // --- FUNGSI WAJIB DARI JWTSubject ---

    /**
     * Mendapatkan identifier (primary key) untuk token JWT.
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Mendapatkan data custom yang ingin dimasukkan ke dalam Payload JWT.
     * Sesuai PDF 11, kita masukkan 'role' di sini.
     */
    public function getJWTCustomClaims()
    {
        return [
            'name' => $this->name,
            'role' => $this->role // <-- 4. Masukkan 'role' ke token
        ];
    }
}