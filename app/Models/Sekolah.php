<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    // Beri tahu Laravel nama tabel aslinya
    protected $table = 'sekolah';
    
    // Izinkan semua kolom diisi, kecuali ID
    protected $guarded = ['id'];

    /*
    |--------------------------------------------------------------------------
    | RELASI MULTI-TENANCY (SaaS)
    |--------------------------------------------------------------------------
    */

    // 1. Satu Sekolah bisa punya banyak Admin (Users)
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // 2. Satu Sekolah bisa punya banyak Buku
    public function bukus()
    {
        return $this->hasMany(Buku::class);
    }

    // 3. Satu Sekolah bisa punya banyak Anggota/Siswa
    public function anggotas()
    {
        return $this->hasMany(Anggota::class);
    }

    // 4. Satu Sekolah bisa punya banyak Transaksi Peminjaman
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }
}