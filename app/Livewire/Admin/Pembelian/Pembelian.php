<?php

namespace App\Livewire\Admin\Pembelian;

use App\Models\Pemasok;
use App\Models\Pembelian as ModelsPembelian;
use Livewire\Component;
use Livewire\WithPagination;

class Pembelian extends Component
{
    use WithPagination;
    public $pembelian_id;
    protected $paginationTheme = 'bootstrap';

      /**
     * Merender data pembelian dan mengirimkannya ke tampilan.
     */
    public function render()
    {
        $pembelians = ModelsPembelian::orderBy('tanggal_masuk', 'desc')->paginate(10);
        return view('livewire.admin.pembelian.pembelian', ['pembelian' => $pembelians]);
    }
}
