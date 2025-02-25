<?php

namespace App\Livewire\Admin\Produk;

use App\Models\Produk;
use Livewire\Component;

class TambahProduk extends Component
{
    public $nama_produk;
    public function store(){
        $this->validate([
            'nama_produk' => 'required|string|max:50'
        ], [
            'nama_produk.required' => 'Nama produk tidak boleh kosong',
            'nama_produk.max' => 'Nama produk tidak boleh lebih dari 50',
        ]);

        Produk::create([
            'nama_produk' => $this->nama_produk,
        ]);

        session()->flash('success', 'Data Berhasil Ditambahkan');
        return redirect()->route('produk');
    }
    public function render()
    {
        return view('livewire.admin.produk.tambah-produk');
    }
}
