<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    // Mendefinisikan nama tabel secara eksplisit (Menghilangkan huruf 's')
    protected $table = 'buku';

    // Mengizinkan semua kolom diisi (Mass Assignment)
    protected $guarded = ['id'];

    // Relasi: Satu Buku bisa memiliki banyak riwayat Peminjaman
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
