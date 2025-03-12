<?php

namespace App\Livewire\Admin\Penjualan;

use App\Models\Barang;
use App\Models\DetailPenjualan;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TambahPenjualan extends Component
{
    public $pelanggan_id, $pelanggan = [];
    public $barang = [], $barang_id, $harga_jual, $jummlah, $sub_total, $total, $status_barang, $kode_barang;

    public $searchBarang = '', $filteredBarang = [], $selectedBarang = [];
    public $searchPelanggan = '', $filteredPelanggan = [];

    public $jumlah_bayar, $kembalian;
    public function mount()
    {
        $this->pelanggan = Pelanggan::all();
        $this->barang = Barang::all();
    }
    public function updatedSearchBarang()
    {
        $this->filteredBarang = !empty($this->searchBarang)
            ? Barang::where('nama_barang', 'like', '%' . $this->searchBarang . '%')
            ->orWhere('kode_barang', 'like', '%' . $this->searchBarang . '%')
            ->get()
            : ['Barang Tidak Ditemukan'];
    }

    public function selectBarang($barang_id, $nama_barang, $kode_barang)
    {
        $barang = Barang::find($barang_id); // Ambil data barang dari database
        $harga_jual = $barang ? $barang->harga_jual : 0;
        $stok = $barang ? $barang->stok : 0; // Ambil stok dari database
        $jumlah = 1; // Set jumlah default 1
        $sub_total = $harga_jual * $jumlah; // Hitung subtotal langsung

        if (!collect($this->selectedBarang)->contains('barang_id', $barang_id)) {
            $this->selectedBarang[] = [
                'barang_id' => $barang_id,
                'nama_barang' => $nama_barang,
                'kode_barang' => $kode_barang,
                'harga_jual' => $harga_jual,
                'stok' => $stok, // Simpan stok barang
                'jumlah' => $jumlah,
                'sub_total' => $sub_total
            ];
        }

        $this->total = $this->getTotalProperty(); // Update total penjualan

        $this->searchBarang = '';
        $this->filteredBarang = [];
    }

    public function resetBarang($index)
    {
        unset($this->selectedBarang[$index]);
        $this->selectedBarang = array_values($this->selectedBarang);
    }
    public function updatedSelectedBarang($value, $key)
    {
        list($index, $field) = explode('.', $key);

        if ($field === 'jumlah') {
            $stok = (int) $this->selectedBarang[$index]['stok'];
            $jumlah = (int) $value;

            if ($jumlah > $stok) {
                $this->selectedBarang[$index]['jumlah'] = $stok;
            }

            if ($jumlah < 1) {
                $this->selectedBarang[$index]['jumlah'] = 1;
            }
        }

        if (in_array($field, ['harga_jual', 'jumlah'])) {
            $harga = (float) $this->selectedBarang[$index]['harga_jual'] ?? 0;
            $jumlah = (int) $this->selectedBarang[$index]['jumlah'] ?? 0;
            $this->selectedBarang[$index]['sub_total'] = $harga * $jumlah;
        }

        $this->total = $this->getTotalProperty();
    }
    public function getTotalProperty()
    {
        return array_sum(array_column($this->selectedBarang, 'sub_total'));
    }
    public function updatedSearchPelanggan()
    {
        $this->filteredPelanggan = !empty($this->searchPelanggan)
            ? Pelanggan::where('nama', 'like', '%' . $this->searchPelanggan . '%')->get()
            : ['Pelanggan Tidak Ditemukan'];
    }
    public function selectPelanggan($pelanggan_id, $nama)
    {
        $this->pelanggan_id = $pelanggan_id;
        $this->searchPelanggan = $nama;
        $this->filteredPelanggan = [];
    }
    public function resetPelanggan()
    {
        $this->pelanggan_id = null;
        $this->searchPelanggan = '';
        $this->filteredPelanggan = [];
    }
    public function updatedJumlahBayar()
{
    if ($this->jumlah_bayar >= $this->total) {
        $this->kembalian = $this->jumlah_bayar - $this->total;
    } else {
        $this->kembalian = 0;
    }
}
    public function store(){
        $this->validate([
            'selectedBarang' => 'required|array|min:1',
            'selectedBarang.*.jumlah' => 'required|numeric|min:1',
            'jumlah_bayar'=> 'required|numeric|min:'.$this->total,
        ]);
        try{
            $tanggal = now()->format('Ymd');
            $lastTransaction = Penjualan::whereDate('created_at', today())->latest()->first();
            $lastId = $lastTransaction ? (int) substr($lastTransaction->no_faktur, -4) : 0;
    
            $noFaktur = 'INV-' . $tanggal . '-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);

            $penjualan = Penjualan::create([
                'no_faktur' => $noFaktur,
                'tgl_faktur' => now()->format('Ymd'),
                'total_bayar' => $this->total,
                'pelanggan_id' => $this->pelanggan_id,
                'user_id' => Auth::id(),
            ]);

            foreach ($this->selectedBarang as $barang) {
                $barangModel = Barang::find($barang['barang_id']);
                if ($barangModel) {
                    $barangModel->stok -= $barang['jumlah'];
                    $barangModel->save();
    
                    DetailPenjualan::create([
                        'penjualan_id' => $penjualan->penjualan_id,
                        'barang_id' => $barang['barang_id'],
                        'harga_jual' => $barang['harga_jual'],
                        'jumlah' => $barang['jumlah'],
                        'sub_total' => $barang['sub_total'],
                    ]);
                }
            }

            DB::commit();

            session()->flash('success', 'Transaksi Penjualan Berhasil');
            return redirect()->route('penjualan');
        } catch (\Exception $e){
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.admin.penjualan.tambah-penjualan');
    }
}
