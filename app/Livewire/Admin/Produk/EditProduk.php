<?php

namespace App\Livewire\Admin\Produk;

use App\Models\Produk;
use Livewire\Component;

class EditProduk extends Component
{
    public $produk_id, $nama_produk;
    public function mount($produk_id){
        $produk = Produk::find($produk_id);
        if (!$produk) {
            session()->flash('error', 'Data tidak ditemukan.');
            return redirect()->route('produk');
        }
        
        $this->nama_produk = $produk->nama_produk;
    }
    public function render()
    {
        return view('livewire.admin.produk.edit-produk');
    }
    public function update(){

        $this->validate([
            'nama_produk' => 'required|string|max:50',
        ]);

        $produk = Produk::find($this->produk_id);

        if (!$produk) {
            session()->flash('error', 'Data tidak ditemukan.');
            return redirect()->route('pemasok'); 
        }

        $produk->update([
            'nama_produk' => $this->nama_produk,
        ]);

        session()->flash('success', 'Data berhasil diupdate.');
        return redirect()->route('produk');
    }
}
