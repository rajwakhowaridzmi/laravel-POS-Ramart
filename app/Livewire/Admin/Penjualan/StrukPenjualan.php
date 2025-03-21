<?php
namespace App\Livewire\Admin\Penjualan;

use Livewire\Component;

class StrukPenjualan extends Component
{
    public $penjualan = [];
    public $penjualan_id, $pelanggan_id, $total, $jumlah_bayar, $kembalian, $barang;
    public $showModal = false; // Modal awalnya tersembunyi

    protected $listeners = ['cetakStruk' => 'loadStruk'];

    public function loadStruk($data)
    {
        $this->penjualan_id = $data['penjualan_id'] ?? null;
        $this->pelanggan_id = $data['pelanggan_id'] ?? null;
        $this->total = $data['total'] ?? 0;
        $this->jumlah_bayar = $data['jumlah_bayar'] ?? 0;
        $this->kembalian = $data['kembalian'] ?? 0;
        $this->barang = $data['barang'] ?? [];

        $this->showModal = true; // Tampilkan modal struk
    }

    public function closeModal()
    {
        $this->showModal = false; // Sembunyikan modal
    }

    public function render()
    {
        return view('livewire.admin.penjualan.struk-penjualan');
    }
}
