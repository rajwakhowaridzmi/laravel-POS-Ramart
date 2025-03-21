<?php

namespace App\Livewire\Admin\Penjualan;

use App\Models\Penjualan as ModelsPenjualan;
use Livewire\Component;
use Livewire\WithPagination;

class Penjualan extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $penjualan_id;
    public function render()
    {
        $penjualans = ModelsPenjualan::orderBy('tgl_faktur','desc')->paginate(10);
        return view('livewire.admin.penjualan.penjualan', ['penjualan' => $penjualans]);
    }
}
