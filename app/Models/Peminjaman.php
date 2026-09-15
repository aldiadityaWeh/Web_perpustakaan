<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    // Mendefinisikan nama tabel secara eksplisit agar Laravel tidak kebingungan
    protected $table = 'peminjaman';

    // Mengizinkan semua kolom untuk diisi (Mass Assignment), KECUALI kolom 'id'
    // Ini adalah cara yang jauh lebih praktis daripada menggunakan $fillable
    protected $guarded = ['id'];

    /**
     * Relasi: Transaksi ini milik 1 Buku
     * (Setiap peminjaman pasti terkait dengan 1 buku spesifik)
     */
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    /**
     * Relasi: Transaksi ini milik 1 Anggota (Siswa)
     * (Setiap peminjaman pasti dilakukan oleh 1 siswa tertentu)
     */
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
}
