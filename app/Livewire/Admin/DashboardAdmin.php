<?php

namespace App\Livewire\Admin;

use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\Pembelian;
use App\Models\Penjualan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DashboardAdmin extends Component
{
    public $totalBarang, $totalPelanggan, $totalPenjualan, $totalPembelian, $totalTerjual, $keuntungan, $chartData;
    public function mount()
    {
        if (Auth::user()->role !== '0') {
            abort(403, 'Akses ditolak');
        }

        $this->totalBarang = Barang::count();
        $this->totalPelanggan = Pelanggan::count();
        $this->totalPenjualan = Penjualan::count();
        $this->totalPembelian = Pembelian::count();

        $penjualan = DB::table('detail_penjualan')
            ->join('barang', 'detail_penjualan.barang_id', '=', 'barang.barang_id')
            ->selectRaw('
                COALESCE(SUM(detail_penjualan.jumlah), 0) as total_terjual,
                COALESCE(SUM((barang.harga_jual - barang.harga_beli) * detail_penjualan.jumlah), 0) as keuntungan
            ')
            ->first();

        $this->totalTerjual = $penjualan->total_terjual;
        $this->keuntungan = $penjualan->keuntungan;

        $this->chartData = [
            'dates' => DB::table('penjualan')
                ->selectRaw('DATE(tgl_faktur) as date')
                ->groupBy('date')
                ->orderBy('date')
                ->pluck('date')->toArray(),

            // Jumlah transaksi penjualan per hari
            'jumlah_transaksi_penjualan' => DB::table('penjualan')
                ->selectRaw('DATE(tgl_faktur) as date, COUNT(*) as jumlah')
                ->groupBy('date')
                ->orderBy('date')
                ->pluck('jumlah')->toArray(),

            // Jumlah transaksi pembelian per hari
            'jumlah_transaksi_pembelian' => DB::table('pembelian')
                ->selectRaw('DATE(tanggal_masuk) as date, COUNT(*) as jumlah')
                ->groupBy('date')
                ->orderBy('date')
                ->pluck('jumlah')->toArray(),

            // **Pendapatan per hari dihitung dengan benar**
            'pendapatan' => DB::table('detail_penjualan')
                ->join('barang', 'detail_penjualan.barang_id', '=', 'barang.barang_id')
                ->join('penjualan', 'detail_penjualan.penjualan_id', '=', 'penjualan.penjualan_id')
                ->selectRaw('DATE(penjualan.tgl_faktur) as date, 
                             COALESCE(SUM((detail_penjualan.jumlah * barang.harga_jual) - 
                                          (detail_penjualan.jumlah * barang.harga_beli)), 0) as pendapatan')
                ->groupBy('date')
                ->orderBy('date')
                ->pluck('pendapatan')->toArray(),
        ];

        $this->dispatch('updateChart', $this->chartData);
    }

    public function render()
    {
        return view('livewire.admin.dashboard-admin');
    }
}
