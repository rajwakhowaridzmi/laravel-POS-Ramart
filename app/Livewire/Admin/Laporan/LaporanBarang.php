<?php

namespace App\Livewire\Admin\Laporan;

use App\Exports\BarangExport;
use App\Models\Barang;
use App\Models\Produk;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class LaporanBarang extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $filterProduk, $filterStatus = '';
    public $searchBarang = '';

    public function mount()
    {
        $this->filterData();
    }

    public function filterData()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Barang::query()
            ->leftJoin('detail_penjualan', 'barang.barang_id', '=', 'detail_penjualan.barang_id')
            ->select(
                'barang.barang_id',
                'barang.kode_barang',
                'barang.produk_id',
                'barang.persentase',
                'barang.nama_barang',
                'barang.harga_jual',
                'barang.harga_beli',
                'barang.stok',
                'barang.status_barang',
                // 'barang.gambar',
                DB::raw('COALESCE(SUM(detail_penjualan.jumlah), 0) as total_terjual'),
                DB::raw('COALESCE((barang.harga_jual - barang.harga_beli) * SUM(detail_penjualan.jumlah), 0) as keuntungan')
            )
            ->groupBy(
                'barang.barang_id',
                'barang.kode_barang',
                'barang.produk_id',
                'barang.persentase',
                'barang.nama_barang',
                'barang.harga_jual',
                'barang.harga_beli',
                'barang.stok',
                'barang.status_barang',
                // 'barang.gambar',
            );


        if ($this->filterProduk) {
            $query->where('produk_id', $this->filterProduk);
        }

        if (isset($this->filterStatus) && $this->filterStatus !== '') {
            $query->where('status_barang', $this->filterStatus);
        }

        if (!empty($this->searchBarang)) {
            $query->where(function ($q) {
                $q->where('nama_barang', 'like', '%' . $this->searchBarang . '%')
                    ->orWhere('kode_barang', 'like', '%' . $this->searchBarang . '%');
            });
        }
        $barangs = $query->paginate(5);

        return view('livewire.admin.laporan.laporan-barang', [
            'barangs' => $barangs,
            'produks' => Produk::all(),
        ]);
    }

    public function exportPdf()
    {
        $query = Barang::query()
            ->leftJoin('detail_penjualan', 'barang.barang_id', '=', 'detail_penjualan.barang_id')
            ->select(
                'barang.barang_id',
                'barang.kode_barang',
                'barang.produk_id',
                'barang.persentase',
                'barang.nama_barang',
                'barang.harga_jual',
                'barang.harga_beli',
                'barang.stok',
                'barang.status_barang',
                // 'barang.gambar',
                DB::raw('COALESCE(SUM(detail_penjualan.jumlah), 0) as total_terjual'),
                DB::raw('COALESCE((barang.harga_jual - barang.harga_beli) * SUM(detail_penjualan.jumlah), 0) as keuntungan')
            )
            ->groupBy(
                'barang.barang_id',
                'barang.kode_barang',
                'barang.produk_id',
                'barang.persentase',
                'barang.nama_barang',
                'barang.harga_jual',
                'barang.harga_beli',
                'barang.stok',
                'barang.status_barang',
                // 'barang.gambar',
            );


        if ($this->filterProduk) {
            $query->where('produk_id', $this->filterProduk);
        }

        if (isset($this->filterStatus) && $this->filterStatus !== '') {
            $query->where('status_barang', $this->filterStatus);
        }

        if (!empty($this->searchBarang)) {
            $query->where(function ($q) {
                $q->where('nama_barang', 'like', '%' . $this->searchBarang . '%')
                    ->orWhere('kode_barang', 'like', '%' . $this->searchBarang . '%');
            });
        }

        $barangs = $query->get();

        foreach ($barangs as $barang) {
            $barang->nama_barang = mb_convert_encoding($barang->nama_barang, 'UTF-8', 'auto');
        }

        $statusMapping = [
            0 => 'Ditarik',
            1 => 'Dijual',
        ];

        // Buat PDF dengan data yang difilter
        $pdf = Pdf::loadView('livewire.admin.laporan.pdf.laporan-barang', compact('barangs', 'statusMapping'))
            ->setPaper('a4', 'landscape'); // Ubah ke landscape

        // Download PDF
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'laporan_barang_' . now()->format('YmdHis') . '.pdf');
    }
    public function exportExcel()
    {
        return Excel::download(new BarangExport($this->filterProduk, $this->filterStatus, $this->searchBarang), 'laporan_barang_' . now()->format('YmdHis') . '.xlsx');
    }
}
