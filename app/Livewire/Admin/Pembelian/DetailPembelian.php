<?php

namespace App\Livewire\Admin\Pembelian;

use App\Models\Pembelian;
use Livewire\Component;

class DetailPembelian extends Component
{
    public $pembelian_id, $detail_pembelian = [], $pembelian;

     /**
     * Mengambil data pembelian beserta detail pembeliannya berdasarkan ID.
     */
    public function mount($pembelian_id)
    {
        $this->pembelian = Pembelian::with('detailPembelian')->find($pembelian_id);
    }

    /**
     * Merender tampilan detail pembelian.
     */
    public function render()
    {
        return view('livewire.admin.pembelian.detail-pembelian', [
            'detail_pembelian' => $this->detail_pembelian,
        ]);
    }
}
