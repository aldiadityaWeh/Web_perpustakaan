<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat akun Admin tetap agar Anda selalu bisa login
        User::factory()->create([
            'name' => 'Admin Perpustakaan',
            'email' => 'admin@perpus.local',
        ]);

        // 2. Eksekusi factory User acak
        User::factory(20)->create();

        // 3. Panggil seeder terpisah untuk tabel-tabel lain secara berurutan
        $this->call([
            BukuSeeder::class,
            AnggotaSeeder::class,
        ]);
    }
}
