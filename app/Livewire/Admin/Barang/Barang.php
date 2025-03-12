<?php

namespace App\Livewire\Admin\Barang;

use App\Models\Barang as ModelsBarang;
use App\Models\Produk;
use Livewire\Component;
use Livewire\WithPagination;

class Barang extends Component
{
    use WithPagination;
    public $barang_id, $produk_id;
    public $paginationTheme = 'bootstrap';
    public function render()
    {
        $barangs = ModelsBarang::paginate(5);
        $produks = Produk::all();
        return view('livewire.admin.barang.barang', ['barang' => $barangs, 'produk' => $produks]);
    }
    public function delete(){
        $barang = ModelsBarang::find($this->barang_id);

        if($barang) {
            $barang->delete();
            session()->flash('success', 'Data Berhasil di Hapus');
        }

        $this->barang_id = null;

        $this->dispatch('closeModal');
    }

    public function confirmDelete($barang_id){
        $this->barang_id = $barang_id;
    }
}
