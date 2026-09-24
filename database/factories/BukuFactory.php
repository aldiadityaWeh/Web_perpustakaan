<?php

namespace Database\Factories;

use App\Models\Buku;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Buku>
 */
class BukuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'isbn' => fake()->numerify('#############'), // Memastikan tepat 13 digit angka
            'judul' => fake()->sentence(3),
            'pengarang' => fake()->name(),
            'penerbit' => fake()->company(),
            'tahun_terbit' => fake()->numberBetween(1980, date('Y')), // Sesuai batasan min/max
            'kategori' => fake()->randomElement(['000', '100', '200', '300', '400', '500', '600', '700', '800', '900']),
            'stok' => fake()->numberBetween(0, 50),
            'rak' => 'Rak ' . fake()->bothify('?-##'), // Menghasilkan format seperti "Rak A-12"
        ];
    }
}
