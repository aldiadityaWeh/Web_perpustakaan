<?php

namespace Database\Factories;

use App\Models\Anggota;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Anggota>
 */
class AnggotaFactory extends Factory
{
    public function definition(): array
    {
        return [
            // NIS dibatasi maksimal 10 digit sesuai validasi
            'nis' => fake()->unique()->numerify('##########'),
            'nama_lengkap' => fake()->name(),
            // Kelas dibatasi dari 1A sampai 6C
            'kelas' => fake()->randomElement(['1A','1B','1C','2A','2B','2C','3A','3B','3C','4A','4B','4C','5A','5B','5C','6A','6B','6C']),
            'jenis_kelamin' => fake()->randomElement(['L', 'P']),
            'alamat' => fake()->address(),
            'status' => fake()->randomElement(['Aktif', 'Tidak Aktif']),
        ];
    }
}
