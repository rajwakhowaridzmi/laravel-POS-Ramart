<?php

namespace App\Livewire\Admin\Laporan;

use App\Models\Barang;
use App\Models\Produk;
use Livewire\Component;

class LaporanBarang extends Component
{
    public $filterProduk, $filterStatus;
    public $barangs = [];

    public function mount()
    {
        // Load all data when the component is first mounted
        $this->barangs = Barang::all();
    }

    public function filterData()
    {
        $query = Barang::query();

        // Filter Produk
        if ($this->filterProduk) {
            $query->where('produk_id', $this->filterProduk);
        }

        // Filter Status hanya diterapkan jika filterStatus bukan null
        if ($this->filterStatus) {
            $query->where('status_barang', $this->filterStatus);
        }

        $this->barangs = $query->get(); 
    }

    public function render()
    {
        // Return data for filter options
        return view('livewire.admin.laporan.laporan-barang', [
            'produks' => Produk::all(),
        ]);
    }
}
