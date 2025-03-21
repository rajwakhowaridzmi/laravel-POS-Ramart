<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Produk::truncate();
        Schema::enableForeignKeyConstraints();
        $file = File::get('');
        $data = json_decode($file);
        foreach($data as $item){
            Produk::create([
                'produk_id' => $item->produk_id
            ]);
        }
    }
}
