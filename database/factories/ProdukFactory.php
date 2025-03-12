<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produk>
 */
class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_produk' => fake()->randomElement(['Obat', 'Bumbu', 'Makanan', 'Mie', 'Sabun', 'Kebutuhan Bayi', 'Parfume', 'Es Krim'])
        ];
    }
}
