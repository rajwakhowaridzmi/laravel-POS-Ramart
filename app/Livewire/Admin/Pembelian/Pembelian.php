<?php

namespace App\Livewire\Admin\Pembelian;

use App\Models\Pemasok;
use App\Models\Pembelian as ModelsPembelian;
use Livewire\Component;

class Pembelian extends Component
{
    public $pembelian_id;
    public function render()
    {
        $pembelians = ModelsPembelian::all();
        return view('livewire.admin.pembelian.pembelian', ['pembelian' => $pembelians]);
    }
}
