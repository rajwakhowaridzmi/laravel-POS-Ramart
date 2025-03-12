<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $data = DB::table('barang')
            ->inRandomOrder()
            ->select('produk_id')
            ->first();
        $user = DB::table('user')
            ->inRandomOrder()
            ->select('user_id')
            ->first();

        return [
            'kode_barang' => fake()->unique()->numberBetween(1, 9999999),
            'produk_id' => $data->produk_id,
            'nama_barang' => fake()->word(),
            'harga_beli' => 0,
            'harga_jual' => 0,
            'stok' => 0,
            'persentase' => fake()->numberBetween(1, 100),
            'status_barang' => fake()->randomElement(['0', '1']),
            'user_id' => $user->user_id,
        ];
    }
}
