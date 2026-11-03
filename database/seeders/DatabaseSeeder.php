<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat 1 Akun Admin Utama
        User::create([
            'name' => 'Kepala Perpustakaan',
            'email' => 'pwksdnciseureuh@gmail.com',
            'password' => Hash::make('AdminPerpus123'),
            'role' => 'admin', // Baris ini ditambahkan agar menjadi Admin
        ]);
    }
}
