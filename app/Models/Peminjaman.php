<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    // Mendefinisikan nama tabel secara eksplisit
    protected $table = 'peminjaman';

    protected $guarded = ['id'];

    // Relasi: Transaksi ini milik 1 Buku
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    // Relasi: Transaksi ini milik 1 Anggota
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
}
