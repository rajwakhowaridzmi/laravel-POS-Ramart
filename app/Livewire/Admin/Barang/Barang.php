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
    protected $paginationTheme = 'bootstrap';

    /**
     * Merender halaman daftar barang.
     * Mengambil data barang dengan pagination dan seluruh data produk.
     */
    public function render()
    {
        $barangs = ModelsBarang::paginate(5);
        $produks = Produk::all();
        return view('livewire.admin.barang.barang', ['barang' => $barangs, 'produk' => $produks]);
    }

    /**
     * Menghapus data barang berdasarkan ID.
     * Jika data ditemukan, akan dihapus dan ditampilkan pesan sukses.
     * Setelah itu, memicu event untuk menutup modal.
     */
    public function delete()
    {
        $barang = ModelsBarang::find($this->barang_id);

        if ($barang) {
            $barang->delete();
            session()->flash('success', 'Data Berhasil di Hapus');
        }

        $this->barang_id = null;

        $this->dispatch('closeModal');
    }

    /**
     * Menyimpan ID barang yang akan dihapus,
     * digunakan untuk konfirmasi sebelum penghapusan.
     */
    public function confirmDelete($barang_id)
    {
        $this->barang_id = $barang_id;
    }
}
