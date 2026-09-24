<?php

namespace Database\Seeders;

use App\Models\Anggota;
use Illuminate\Database\Seeder;

class AnggotaSeeder extends Seeder
{
    public function run(): void
    {
        // Data anggota spesifik
        Anggota::create([
            'nis' => '1000000001',
            'nama_lengkap' => 'Aldi Aditya',
            'kelas' => '6A',
            'jenis_kelamin' => 'L',
            'alamat' => 'Purwakarta',
            'status' => 'Aktif'
        ]);

        Anggota::create([
            'nis' => '1000000002',
            'nama_lengkap' => 'Ahmad Sabani',
            'kelas' => '6B',
            'jenis_kelamin' => 'L',
            'alamat' => 'Purwakarta',
            'status' => 'Aktif'
        ]);

        Anggota::create([
            'nis' => '1000000003',
            'nama_lengkap' => 'Haura',
            'kelas' => '6C',
            'jenis_kelamin' => 'P',
            'alamat' => 'Purwakarta',
            'status' => 'Aktif'
        ]);

        // Hasilkan 47 data anggota sekolah dasar secara acak
        Anggota::factory(47)->create();
    }
}
