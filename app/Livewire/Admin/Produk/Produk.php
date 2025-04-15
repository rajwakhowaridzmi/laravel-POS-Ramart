<?php

namespace App\Livewire\Admin\Produk;

use App\Models\Produk as ModelsProduk;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class Produk extends Component
{
    use WithPagination;

    public $produk_id, $nama_produk;

    protected $paginationTheme = 'bootstrap';

    /**
     * Fungsi utama untuk merender tampilan komponen Livewire.
     * Mengambil data produk dengan pagination 5 data per halaman.
     */
    public function render()
    {
        $produks = ModelsProduk::paginate(5);
        return view('livewire.admin.produk.produk', [
            'produk' => $produks
        ]);
    }

    /**
     * Menyimpan data produk baru ke database.
     * Memvalidasi input, menyimpan data, dan mengirim flash message.
     */
    public function store()
    {
        $this->validate([
            'nama_produk' => 'required|string|max:50|unique:produk,nama_produk',
        ], [
            'nama_produk.required' => 'Nama produk tidak boleh kosong',
            'nama_produk.max' => 'Nama produk tidak boleh lebih dari 50 karakter',
            'nama_produk.unique' => 'Nama produk sudah terdaftar, silakan gunakan nama lain',
        ]);
        

        try {
            ModelsProduk::create([
                'nama_produk' => $this->nama_produk,
            ]);

            Log::info('Produk berhasil ditambahkan', [
                'nama_produk' => $this->nama_produk
            ]);

            $this->reset('nama_produk');
            $this->dispatch('closeModal');
            session()->flash('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan produk', [
                'error' => $e->getMessage(),
                'input' => $this->nama_produk
            ]);

            session()->flash('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    /**
     * Reset semua input form.
     * Digunakan sebelum membuka modal tambah/edit.
     */
    public function resetForm()
    {
        $this->reset(['produk_id', 'nama_produk']);
    }

    /**
     * Menampilkan modal tambah produk.
     * Mereset form terlebih dahulu sebelum menampilkan modal.
     */
    public function showTambahProdukModal()
    {
        $this->resetForm();
        $this->dispatch('openTambahModal');
    }

    /**
     * Mengambil data produk berdasarkan ID untuk proses edit.
     * Lalu menampilkan modal edit dengan data terisi.
     */
    public function editProduk($produk_id)
    {
        $produk = ModelsProduk::findOrFail($produk_id);

        $this->produk_id = $produk->produk_id;
        $this->nama_produk = $produk->nama_produk;

        $this->dispatch('openEditModal');
    }

    /**
     * Menyimpan perubahan (update) data produk.
     */
    public function update()
    {
        $this->validate([
            'nama_produk' => 'required|string|max:50|unique:produk,nama_produk',
        ], [
            'nama_produk.required' => 'Nama produk tidak boleh kosong',
            'nama_produk.max' => 'Nama produk tidak boleh lebih dari 50 karakter',
            'nama_produk.unique' => 'Nama produk sudah terdaftar, silakan gunakan nama lain',
        ]);        

        try {
            $produk = ModelsProduk::findOrFail($this->produk_id);

            $produk->update([
                'nama_produk' => $this->nama_produk,
            ]);

            session()->flash('success', 'Produk berhasil diperbarui.');
            $this->dispatch('closeModal');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui produk', [
                'error' => $e->getMessage(),
                'produk_id' => $this->produk_id,
                'input' => $this->nama_produk
            ]);

            session()->flash('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    /**
     * Menghapus produk berdasarkan ID yang disimpan.
     */
    public function delete()
    {
        try {
            $produk = ModelsProduk::findOrFail($this->produk_id);
            $produk->delete();

            session()->flash('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus produk', [
                'error' => $e->getMessage(),
                'produk_id' => $this->produk_id
            ]);

            session()->flash('error', 'Terjadi kesalahan saat menghapus data.');
        }

        $this->produk_id = null;
        $this->dispatch('closeModal');
    }

    /**
     * Menyimpan ID produk yang akan dihapus,konfirmasi delete.
     */
    public function confirmDelete($produk_id)
    {
        $this->produk_id = $produk_id;
    }
}
