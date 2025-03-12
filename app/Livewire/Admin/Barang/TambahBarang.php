<?php

namespace App\Livewire\Admin\Barang;

use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class TambahBarang extends Component
{
    public $kode_barang, $nama_barang, $produk_id, $stok, $status_barang, $user_id, $gambar;
    public $persentase = '';

    use WithFileUploads;
    public function store()
    {
        // Validasi input
        $this->validate([
            'kode_barang' => 'required|string|max:50',
            'nama_barang' => 'required|string|max:50',
            'produk_id' => 'required',
            'persentase' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'kode_barang.required' => 'Kode barang tidak boleh kosong',
            'nama_barang.required' => 'Nama barang tidak boleh kosong',
            'produk_id.required' => 'Produk tidak boleh kosong',
            'persentase.required' => 'Persentase tidak boleh kosong',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus jpg, jpeg, atau png',
            'gambar.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        // Ambil user_id dari auth
        $user_id = Auth::user()->user_id;

        $gambarPath = null;
        if ($this->gambar) {
            $gambarPath = $this->gambar->store('barang', 'public'); // Simpan ke storage/public/barang
        }


        DB::beginTransaction(); // Memulai transaksi

        try {
            // Menyimpan data barang ke dalam database
            DB::table('barang')->insert([
                'kode_barang' => $this->kode_barang,
                'nama_barang' => $this->nama_barang,
                'produk_id' => $this->produk_id,
                'harga_beli' => 0,
                'harga_jual' => 0,
                'persentase' => $this->persentase,
                'stok' => 0,
                'status_barang' => '1',
                'gambar' => $gambarPath,
                'user_id' => $user_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit(); // Menyimpan perubahan jika tidak ada error

            session()->flash('success', 'Barang berhasil ditambahkan!');
            return redirect()->route('barang');
        } catch (\Exception $e) {
            DB::rollBack(); // Membatalkan perubahan jika terjadi error

            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
            return back(); // Kembali ke halaman sebelumnya
        }
    }

    // Render untuk menampilkan data produk yang ada
    public function render()
    {
        $produks = Produk::all(); // Ambil semua data produk
        return view('livewire.admin.barang.tambah-barang', ['produk' => $produks]);
    }
}
