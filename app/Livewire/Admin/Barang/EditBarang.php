<?php

namespace App\Livewire\Admin\Barang;

use App\Models\Barang;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class EditBarang extends Component
{
    use WithFileUploads;
    public $barang_id, $kode_barang, $nama_barang, $produk_id, $stok, $status_barang, $user_id, $persentase, $harga_beli, $gambar, $gambar_lama;
    public function mount($barang_id)
    {
        $barang = Barang::find($barang_id);
        if (!$barang) {
            session()->flash('error', 'Data Tidak Ditemukan');
            return redirect()->route('barang');
        }
        $this->kode_barang = $barang->kode_barang;
        $this->nama_barang = $barang->nama_barang;
        $this->produk_id = $barang->produk_id;
        $this->status_barang = $barang->status_barang;
        $this->persentase = $barang->persentase;
        $this->harga_beli = $barang->harga_beli;
        $this->gambar_lama = $barang->gambar;
    }
    public function update()
    {
        $this->validate([
            'kode_barang' => 'required|string|max:50',
            'nama_barang' => 'required|string|max:50',
            'produk_id' => 'required',
            'status_barang' => 'required',
            'persentase' => 'required',
            'gambar' => 'nullable|image|max:2048',
        ], [
            'kode_barang.required' => 'Kode barang tidak boleh kosong',
            'kode_barang.max' => 'Kode barang tidak boleh lebih dari 50 karakter',
            'nama_barang.required' => 'Nama barang tidak boleh kosong',
            'nama_barang.max' => 'Nama barang tidak boleh lebih dari 50 karakter',
            'produk_id.required' => 'Produk tidak boleh kosong',
            'status_barang.required' => 'Status barang tidak boleh kosong',
            'persentase.required' => 'Persentase tidak boleh kosong',
        ]);


        $barang = Barang::find($this->barang_id);

        
        
        if (!$barang) {
            session()->flash('error', 'Data tidak ditemukan.');
            return redirect()->route('barang');
        }
        
        if ($this->gambar instanceof TemporaryUploadedFile) {
            $gambarPath = $this->gambar->store('barang', 'public');
        } else {
            $gambarPath = $this->gambar_lama;
        }
        
        $harga_jual_baru = $this->harga_beli * (1 + $this->persentase / 100);
        DB::table('barang')
            ->where('barang_id', $this->barang_id)
            ->update([
                'kode_barang' => $this->kode_barang,
                'nama_barang' => $this->nama_barang,
                'produk_id' => $this->produk_id,
                'status_barang' => $this->status_barang,
                'persentase' => $this->persentase,
                'harga_jual' => $harga_jual_baru,
                'gambar' => $gambarPath,
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
