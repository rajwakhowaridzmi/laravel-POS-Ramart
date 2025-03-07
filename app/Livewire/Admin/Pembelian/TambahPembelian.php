<?php

namespace App\Livewire\Admin\Pembelian;

use App\Models\Barang;
use App\Models\DetailPembelian;
use App\Models\Pemasok;
use App\Models\Pembelian;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TambahPembelian extends Component
{
    public $pemasok_id, $user_id, $barang_id = [];
    public $pemasok = [], $barang = [], $harga_beli, $jumlah, $sub_total, $total;

    public $searchPemasok = '', $filteredPemasok = [];
    public $searchBarang = '', $filteredBarang = [], $selectedBarang = [];
    
    public function mount()
    {
        $this->pemasok = Pemasok::all();
        $this->barang = Barang::all();
    }
    public function updatedSearchPemasok()
    {
        $this->filteredPemasok = !empty($this->searchPemasok)
            ? Pemasok::where('nama_pemasok', 'like', '%' . $this->searchPemasok . '%')->get()
            : [];
    }
    public function selectPemasok($pemasok_id, $nama_pemasok)
    {
        $this->pemasok_id = $pemasok_id;
        $this->searchPemasok = $nama_pemasok;
        $this->filteredPemasok = [];
    }
    public function resetPemasok()
    {
        $this->pemasok_id = null;
        $this->searchPemasok = '';
        $this->filteredPemasok = [];
    }
    public function updatedSearchBarang()
    {
        $this->filteredBarang = !empty($this->searchBarang)
            ? Barang::where('nama_barang', 'like', '%' . $this->searchBarang . '%')->get()
            : [];
    }
    public function selectBarang($barang_id, $nama_barang)
    {
        if (!collect($this->selectedBarang)->contains('barang_id', $barang_id)) {
            $this->selectedBarang[] = [
                'barang_id' => $barang_id,
                'nama_barang' => $nama_barang,
                'harga_beli' => null,
                'jumlah' => null,
                'sub_total' => null
            ];
        }

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

        if (in_array($field, ['harga_beli', 'jumlah'])) {
            $harga = $this->selectedBarang[$index]['harga_beli'] ?? 0;
            $jumlah = $this->selectedBarang[$index]['jumlah'] ?? 0;
            $this->selectedBarang[$index]['sub_total'] = $harga * $jumlah;
        }
        $this->total = $this->getTotalProperty();
    }


    public function getTotalProperty()
    {
        return array_sum(array_column($this->selectedBarang, 'sub_total'));
    }


    public function store()
    {
        $this->validate([
            'pemasok_id' => 'required|exists:pemasok,pemasok_id',
            'selectedBarang' => 'required|array|min:1',
            'selectedBarang.*.barang_id' => 'required|exists:barang,barang_id',
            'selectedBarang.*.harga_beli' => 'required|numeric|min:1',
            'selectedBarang.*.jumlah' => 'required|numeric|min:1',
        ]);

        try {
            DB::beginTransaction();

            $tanggal = now()->format('Ymd');
            $lastKode = Pembelian::whereDate('created_at', now())->latest('created_at')->first();

            $nomorUrut = 1;
            if ($lastKode) {
                $nomorUrut = (int) substr($lastKode->kode_masuk, -4) + 1;
            }

            $kodeMasuk = 'PBL' . $tanggal . str_pad($nomorUrut, 4, '0', STR_PAD_LEFT);

            $pembelian = Pembelian::create([
                'kode_masuk' => $kodeMasuk,
                'tanggal_masuk' => now()->format('Ymd'),
                'pemasok_id' => $this->pemasok_id,
                'user_id' => Auth::id(),
            ]);

            foreach ($this->selectedBarang as $barang) {
                DetailPembelian::create([
                    'pembelian_id' => $pembelian->pembelian_id,
                    'barang_id' => $barang['barang_id'],
                    'harga_beli' => $barang['harga_beli'],
                    'jumlah' => $barang['jumlah'],
                    'sub_total' => $barang['sub_total'],
                ]);
            }

            foreach ($this->selectedBarang as $barang) {
                $barangs = Barang::find($barang['barang_id']);
                if ($barangs) {
                    $barangs->increment('stok', $barang['jumlah']);
                }
            }

            DB::commit();


            session()->flash('success', 'Pembelian berhasil disimpan dengan kode ' . $kodeMasuk);
            return redirect()->route('pembelian');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.pembelian.tambah-pembelian');
    }
}
