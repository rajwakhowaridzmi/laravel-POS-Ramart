<?php

namespace App\Livewire\Admin\Produk;

use App\Models\Produk as ModelsProduk;
use Livewire\Component;
use Livewire\WithPagination;

class Produk extends Component
{
    use WithPagination;
    public $produk_id;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $produks = ModelsProduk::paginate(5);
        return view('livewire.admin.produk.produk', ['produk' => $produks]);
    }

    public function delete(){
        $produk = ModelsProduk::find($this->produk_id);

        if($produk) {
            $produk->delete();
            session()->flash('success', 'Data Berhasil di Hapus');
        }

        $this->produk_id = null;

        $this->dispatch('closeModal');
    }

    public function confirmDelete($produk_id){
        $this->produk_id = $produk_id;
    }
}


