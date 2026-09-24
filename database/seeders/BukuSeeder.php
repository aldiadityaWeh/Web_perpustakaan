<?php

namespace Database\Seeders;

use App\Models\Buku;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        // Perintah untuk membuat 50 data dummy buku secara otomatis
        Buku::factory()->count(50)->create();
    }
}
