<?php

namespace App\Livewire\Admin\Barang;

use App\Models\Barang;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EditBarang extends Component
{
    public $barang_id, $kode_barang, $nama_barang, $produk_id, $harga_jual, $stok, $status_barang, $user_id;
    public function mount($barang_id) {
        $barang = Barang::find($barang_id);
        if (!$barang) {
            session()->flash('error', 'Data Tidak Ditemukan');
            return redirect()->route('barang');
        }
        $this->kode_barang = $barang->kode_barang;
        $this->nama_barang = $barang->nama_barang;
        $this->produk_id = $barang->produk_id;
        $this->harga_jual = $barang->harga_jual;
        $this->stok = $barang->stok;
        $this->status_barang = $barang->status_barang;

    }
    public function update(){
        $this->validate([
            'kode_barang' => 'required|string|max:50',
            'nama_barang' => 'required|string|max:50',
            'produk_id' => 'required',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|numeric',
        ], [
            'kode_barang.required' => 'Kode barang tidak boleh kosong',
            'kode_barang.max' => 'Kode barang tidak boleh lebih dari 50 karakter',
            'nama_barang.required' => 'Nama barang tidak boleh kosong',
            'nama_barang.max' => 'Nama barang tidak boleh lebih dari 50 karakter',
            'produk_id.required' => 'Produk tidak boleh kosong',
            // 'produk_id.exists' => 'Produk tidak ditemukan',
            'harga_jual.required' => 'Harga jual tidak boleh kosong',
            'harga_jual.numeric' => 'Harga jual harus berupa angka',
            'stok.required' => 'Stok tidak boleh kosong',
            'stok.numeric' => 'Stok harus berupa angka',
        ]);

        $barang = Barang::find($this->barang_id);

        if (!$barang) {
            session()->flash('error', 'Data tidak ditemukan.');
            return redirect()->route('barang');
        }

        $barang->update([
            'kode_barang' => $this->kode_barang,
            'nama_barang' => $this->nama_barang,
            'produk_id' => $this->produk_id,
            'harga_jual' => $this->harga_jual,
            'stok' => $this->stok,
            'status_barang' => $this->status_barang,
        ]);

        session()->flash('success', 'Data berhasil diperbarui.');
        return redirect()->route('barang');
    }
    public function render()
    {
        $produks = Produk::all();
        return view('livewire.admin.barang.edit-barang', ['produk' => $produks]);
    }
}
