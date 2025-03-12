<?php

namespace Database\Seeders;

use App\Models\Pemasok;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class PemasokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Pemasok::truncate();
        Schema::enableForeignKeyConstraints();
        $file = File::get('');
        $data = json_decode($file);
        foreach($data as $item){
            Pemasok::create([
                'pemasok_id' => $item->pemasok_id
            ]);
        }
    }
}
