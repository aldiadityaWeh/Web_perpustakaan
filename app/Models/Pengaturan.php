<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_sekolah',
        'alamat_sekolah',
        'kepala_perpustakaan',
        'nip_kepala',
        'denda_per_hari',
        'maksimal_hari_pinjam',
        'maksimal_buku_pinjam',
    ];
}
