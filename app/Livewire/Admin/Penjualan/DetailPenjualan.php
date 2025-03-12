<?php 
namespace App\Livewire\Admin\Penjualan;

use App\Models\Penjualan;
use Livewire\Component;

class DetailPenjualan extends Component
{
    public $penjualan_id, $penjualan;

    public function mount($penjualan_id = null)
    {
        if ($penjualan_id) {
            $this->penjualan = Penjualan::with('detailPenjualan.barang')->find($penjualan_id);
        }
    }

    public function render()
    {
        return view('livewire.admin.penjualan.detail-penjualan', [
            'penjualan' => $this->penjualan,
        ]);
    }
}
