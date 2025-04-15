<?php

namespace App\Livewire\Admin\Penjualan;

use App\Models\Barang;
use App\Models\DetailPenjualan;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Services\ThermalPrinterService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class TambahPenjualan extends Component
{
    public $pelanggan_id, $pelanggan = [];
    public $barang = [], $barang_id, $harga_jual, $jummlah, $sub_total, $total, $status_barang, $kode_barang;

    public $searchBarang = '', $filteredBarang = [], $selectedBarang = [];
    public $searchPelanggan = '', $filteredPelanggan = [];

    public $jumlah_bayar, $kembalian;

    public $showStruk = false;
    public $penjualanData = [];

    public $kodeBarangInput = '';

    /**
     * Menambahkan barang ke daftar keranjang berdasarkan kode yang diinput.
     * 
     * - Jika barang ditemukan dan sudah ada di keranjang, jumlah ditambah (jika stok mencukupi).
     * - Jika belum ada, barang ditambahkan dengan jumlah awal 1.
     * - Jika tidak ditemukan, tampilkan pesan error.
     * - Total harga diperbarui setiap perubahan.
     */
    public function tambahBarangDenganKode()
    {
        try {
            $barang = Barang::where('kode_barang', $this->kodeBarangInput)->first();

            if ($barang) {
                // Cek apakah barang sudah ada di selectedBarang
                $index = collect($this->selectedBarang)->search(function ($item) use ($barang) {
                    return $item['barang_id'] === $barang->barang_id;
                });

                if ($index !== false) {
                    // Barang sudah ada → tambah jumlah
                    if ($this->selectedBarang[$index]['jumlah'] < $barang->stok) {
                        $this->selectedBarang[$index]['jumlah'] += 1;
                        $this->selectedBarang[$index]['sub_total'] = $this->selectedBarang[$index]['jumlah'] * $this->selectedBarang[$index]['harga_jual'];
                    }
                } else {
                    // Barang belum ada → tambahkan baru
                    $this->selectedBarang[] = [
                        'barang_id' => $barang->barang_id,
                        'nama_barang' => $barang->nama_barang,
                        'kode_barang' => $barang->kode_barang,
                        'harga_jual' => $barang->harga_jual,
                        'stok' => $barang->stok,
                        'jumlah' => 1,
                        'sub_total' => $barang->harga_jual
                    ];
                }

                // Update total setiap kali barang ditambahkan
                $this->total = $this->getTotalProperty();
            } else {
                session()->flash('error', 'Barang dengan kode tersebut tidak ditemukan.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
            Log::error('Gagal tambah barang dengan kode: ' . $e->getMessage());
        } finally {
            // Reset input kode barang setelah proses
            $this->kodeBarangInput = '';
        }
    }

    /**
     * Fungsi ini dipanggil ketika komponen pertama kali dimuat
     * untuk menginisialisasi data pelanggan dan barang yang digunakan
     * dalam penjualan.
     */
    public function mount()
    {
        $this->pelanggan = Pelanggan::where('member_status', 1)->get();
        $this->barang = Barang::all();
    }

    /**
     * Fungsi untuk memfilter data barang berdasarkan input pencarian.
     * Fungsi ini akan dipanggil setiap kali nilai `searchBarang` diperbarui.
     */
    public function updatedSearchBarang()
    {
        $this->filteredBarang = !empty($this->searchBarang)
            ? Barang::where('nama_barang', 'like', '%' . $this->searchBarang . '%')
            ->orWhere('kode_barang', 'like', '%' . $this->searchBarang . '%')
            ->get()
            : ['Barang Tidak Ditemukan'];
    }

    /**
     * Fungsi ini digunakan untuk memilih barang dan menambahkannya ke dalam
     * daftar barang yang dipilih. Fungsi ini juga menghitung subtotal untuk 
     * barang yang dipilih.
     */
    public function selectBarang($barang_id, $nama_barang, $kode_barang)
    {
        $barang = Barang::find($barang_id);
        $harga_jual = $barang ? $barang->harga_jual : 0;
        $stok = $barang ? $barang->stok : 0;
        $jumlah = 1;
        $sub_total = $harga_jual * $jumlah;

        if (!collect($this->selectedBarang)->contains('barang_id', $barang_id)) {
            $this->selectedBarang[] = [
                'barang_id' => $barang_id,
                'nama_barang' => $nama_barang,
                'kode_barang' => $kode_barang,
                'harga_jual' => $harga_jual,
                'stok' => $stok,
                'jumlah' => $jumlah,
                'sub_total' => $sub_total
            ];
        }

        $this->total = $this->getTotalProperty();

        $this->searchBarang = '';
        $this->filteredBarang = [];
    }

    /**
     * Fungsi untuk menghapus barang dari daftar barang yang dipilih.
     * Fungsi ini akan menghapus barang berdasarkan index yang diberikan.
     */

    public function resetBarang($index)
    {
        unset($this->selectedBarang[$index]);
        $this->selectedBarang = array_values($this->selectedBarang);
    }

    /**
     * Fungsi ini menangani pembaruan jumlah atau harga pada barang yang dipilih.
     * Jika perubahan terjadi pada jumlah, maka fungsi ini akan memverifikasi
     * jumlah barang yang valid dan menghitung ulang subtotal.
     */
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

    /**
     * Fungsi ini menghitung total dari seluruh barang yang dipilih berdasarkan
     * nilai sub_total masing-masing barang.
     */
    public function getTotalProperty()
    {
        return array_sum(array_column($this->selectedBarang, 'sub_total'));
    }

    /**
     * Fungsi untuk memfilter pelanggan berdasarkan input pencarian.
     * Fungsi ini akan dipanggil setiap kali nilai `searchPelanggan` diperbarui.
     */
    public function updatedSearchPelanggan()
    {
        $this->filteredPelanggan = !empty($this->searchPelanggan)
            ? Pelanggan::where('nama', 'like', '%' . $this->searchPelanggan . '%')
            ->orWhere('no_telp', 'like', '%' . $this->searchPelanggan . '%')
            ->get()
            : ['Pelanggan Tidak Ditemukan'];
    }

    /**
     * Fungsi ini untuk memilih pelanggan dan mengisinya ke dalam input pencarian.
     * Fungsi ini akan menyetel `pelanggan_id` dan `searchPelanggan` ke nilai yang dipilih.
     */
    public function selectPelanggan($pelanggan_id, $nama)
    {
        $this->pelanggan_id = $pelanggan_id;
        $this->searchPelanggan = $nama;
        $this->filteredPelanggan = [];
    }

    /**
     * Fungsi untuk mereset pemilihan pelanggan.
     * Fungsi ini akan mengatur ulang nilai `pelanggan_id` dan `searchPelanggan`.
     */
    public function resetPelanggan()
    {
        $this->pelanggan_id = null;
        $this->searchPelanggan = '';
        $this->filteredPelanggan = [];
    }

    /**
     * Fungsi untuk menghitung kembalian yang akan diberikan kepada pelanggan.
     * Fungsi ini dipanggil setiap kali nilai `jumlah_bayar` diperbarui.
     */
    public function updatedJumlahBayar()
    {
        if ($this->jumlah_bayar >= $this->total) {
            $this->kembalian = $this->jumlah_bayar - $this->total;
        } else {
            $this->kembalian = 0;
        }
    }

    /**
     * Fungsi untuk menyimpan data penjualan ke dalam database.
     * Fungsi ini akan menyimpan data penjualan dan detail barang yang terjual,
     * serta mengurangi stok barang yang terjual.
     */
    public function store()
    {
        $this->validate([
            'selectedBarang' => 'required|array|min:1',
            'selectedBarang.*.jumlah' => 'required|numeric|min:1',
            'jumlah_bayar' => 'required|numeric|min:' . $this->total,
        ]);

        DB::beginTransaction();
        $printerService = new ThermalPrinterService();

        try {
            $tanggal = now()->format('Ymd');
            $lastTransaction = Penjualan::whereDate('created_at', today())->latest()->first();
            $lastId = $lastTransaction ? (int) substr($lastTransaction->no_faktur, -4) : 0;

            $noFaktur = 'INV-' . $tanggal . '-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);

            // Simpan data penjualan
            $penjualan = Penjualan::create([
                'no_faktur' => $noFaktur,
                'tgl_faktur' => now()->format('Ymd'),
                'total_bayar' => $this->total,
                'pelanggan_id' => $this->pelanggan_id,
                'user_id' => Auth::id(),
            ]);

            // Simpan detail penjualan dan update stok barang
            foreach ($this->selectedBarang as $barang) {
                $barangModel = Barang::find($barang['barang_id']);
                if ($barangModel) {
                    // Update stok barang
                    $barangModel->stok -= $barang['jumlah'];
                    $barangModel->save();

                    // Simpan detail penjualan untuk barang
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

            // Menyimpan data yang akan ditampilkan pada struk
            $this->penjualanData = [
                'penjualan_id' => $penjualan->penjualan_id,
                'no_faktur' => $penjualan->no_faktur,
                'pelanggan_id' => $penjualan->pelanggan_id,
                'pelanggan' => Pelanggan::find($penjualan->pelanggan_id),
                'kasir' => Auth::user(),
                'total' => $this->total,
                'jumlah_bayar' => $this->jumlah_bayar,
                'kembalian' => $this->jumlah_bayar - $this->total,
                'barang' => $this->selectedBarang,
            ];

            // Print struk
            $printerService->printStruk($this->penjualanData);

            session()->flash('success', 'Transaksi Penjualan Berhasil');
            return redirect()->route('penjualan');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    /**
     * Fungsi untuk menampilkan atau menyembunyikan struk penjualan.
     * Fungsi ini akan mengubah status `showStruk` antara true dan false.
     */
    public function cetakStruk()
    {
        $this->showStruk = false;
        return redirect()->route('penjualan');
    }


    // {
    //     $this->validate([
    //         'selectedBarang' => 'required|array|min:1',
    //         'selectedBarang.*.jumlah' => 'required|numeric|min:1',
    //         'jumlah_bayar' => 'required|numeric|min:' . $this->total,
    //     ]);

    //     DB::beginTransaction();

    //     try {
    //         $tanggal = now()->format('Ymd');
    //         $lastTransaction = Penjualan::whereDate('created_at', today())->latest()->first();
    //         $lastId = $lastTransaction ? (int) substr($lastTransaction->no_faktur, -4) : 0;

    //         $noFaktur = 'INV-' . $tanggal . '-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);

    //         $penjualan = Penjualan::create([
    //             'no_faktur' => $noFaktur,
    //             'tgl_faktur' => now()->format('Ymd'),
    //             'total_bayar' => $this->total,
    //             'pelanggan_id' => $this->pelanggan_id,
    //             'user_id' => Auth::id(),
    //         ]);

    //         foreach ($this->selectedBarang as $barang) {
    //             $barangModel = Barang::find($barang['barang_id']);
    //             if ($barangModel) {
    //                 $barangModel->stok -= $barang['jumlah'];
    //                 $barangModel->save();

    //                 DetailPenjualan::create([
    //                     'penjualan_id' => $penjualan->penjualan_id,
    //                     'barang_id' => $barang['barang_id'],
    //                     'harga_jual' => $barang['harga_jual'],
    //                     'jumlah' => $barang['jumlah'],
    //                     'sub_total' => $barang['sub_total'],
    //                 ]);
    //             }
    //         }

    //         DB::commit();

    //         // Simpan data struk & tampilkan modal
    //         $this->penjualanData = [
    //             'penjualan_id' => $penjualan->penjualan_id,
    //             'pelanggan_id' => $penjualan->pelanggan_id,
    //             'total' => $this->total,
    //             'jumlah_bayar' => $this->jumlah_bayar,
    //             'kembalian' => $this->jumlah_bayar - $this->total,
    //             'barang' => $this->selectedBarang,
    //         ];

    //         $this->showStruk = true; // Tampilkan modal struk

    //         session()->flash('success', 'Transaksi Penjualan Berhasil, Cetak Struk Dulu!');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
    //     }
    // }

    // public function cetakStruk()
    // {
    //     // Cetak struk dan redirect ke halaman penjualan
    //     $this->showStruk = false;
    //     return redirect()->route('penjualan');
    // }



    /**
     * Fungsi utama untuk merender tampilan komponen Livewire.
     */
    public function render()
    {
        return view('livewire.admin.penjualan.tambah-penjualan');
    }
}
