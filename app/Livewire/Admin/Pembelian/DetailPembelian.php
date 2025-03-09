<?php

namespace App\Livewire\Admin\Pembelian;

use App\Models\Pembelian;
use Livewire\Component;

class DetailPembelian extends Component
{
    public $pembelian_id, $detail_pembelian = [], $pembelian;

    public function mount($pembelian_id)
    {
        $this->pembelian = Pembelian::with('detailPembelian')->find($pembelian_id);
    }

    public function render()
    {
        return view('livewire.admin.pembelian.detail-pembelian', [
            'detail_pembelian' => $this->detail_pembelian,
        ]);
    }
}
