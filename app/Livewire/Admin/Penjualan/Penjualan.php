<?php

namespace App\Livewire\Admin\Penjualan;

use App\Models\Penjualan as ModelsPenjualan;
use Livewire\Component;

class Penjualan extends Component
{
    public $penjualan_id;
    public function render()
    {
        $penjualans = ModelsPenjualan::all();
        return view('livewire.admin.penjualan.penjualan', ['penjualan' => $penjualans]);
    }
}
