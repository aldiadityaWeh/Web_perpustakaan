<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';

    protected $guarded = ['id'];

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }

    // FUNGSI PENERJEMAH ANGKA KE TEKS KATEGORI
   public function getNamaKategoriAttribute()
    {
        // Standar Klasifikasi Dewey Decimal (DDC)
        $kategoriDDC = [
            '000' => 'Komputer, Informasi & Referensi',
            '100' => 'Filsafat & Psikologi',
            '200' => 'Agama',
            '300' => 'Ilmu Sosial',
            '400' => 'Bahasa',
            '500' => 'Sains & Matematika',
            '600' => 'Teknologi & Ilmu Terapan',
            '700' => 'Kesenian & Rekreasi',
            '800' => 'Sastra',
            '900' => 'Sejarah & Geografi',
        ];

        // Cocokkan kode (misal '000') dengan teksnya
        return $kategoriDDC[$this->kategori] ?? 'Kategori Tidak Diketahui';
    }
}
