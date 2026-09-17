<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengaturan;

class PengaturanSeeder extends Seeder
{
    public function run(): void
    {
        // Mengecek agar tidak ada data ganda jika seeder dijalankan 2x
        if (Pengaturan::count() == 0) {
            Pengaturan::create([
                'nama_sekolah' => 'SDN 6 Cisereuh',
                'alamat_sekolah' => 'Jl. Contoh Alamat Sekolah No. 123, Kabupaten Purwakarta, Jawa Barat',
                'kepala_perpustakaan' => 'Agung Prastiyo',
                'nip_kepala' => '198001012005011001',
                'denda_per_hari' => 1000,
                'maksimal_hari_pinjam' => 7,
                'maksimal_buku_pinjam' => 3,
            ]);
        }
    }
}
