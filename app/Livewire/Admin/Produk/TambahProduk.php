<?php

namespace App\Livewire\Admin\Produk;

use App\Models\Produk;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class TambahProduk extends Component
{
    // Properti untuk menyimpan nama produk yang dimasukkan oleh user
    public $nama_produk;

    /**
     * Fungsi untuk menyimpan produk baru ke database
     * 
     * Proses ini mencakup validasi inputan, penyimpanan ke dalam tabel 'produk',
     * dan pemberian flash message sukses setelah berhasil.
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
            Produk::create([
                'nama_produk' => $this->nama_produk,
            ]);

            Log::channel('activitylog')->info('Produk berhasil ditambahkan', [
                'nama_produk' => $this->nama_produk,
            ]);

            session()->flash('success', 'Data Berhasil Ditambahkan');
            return redirect()->route('tambah-produk');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan produk', [
                'error' => $e->getMessage(),
                'input' => $this->nama_produk
            ]);

            session()->flash('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    /**
     * Fungsi untuk merender tampilan komponen Livewire
     * 
     * Fungsi ini mengembalikan view yang akan ditampilkan kepada pengguna,
     * yaitu form untuk menambahkan produk.
     */
    public function render()
    {
        return view('livewire.admin.produk.tambah-produk');
    }
}
