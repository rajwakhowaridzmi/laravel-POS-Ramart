<?php

namespace App\Livewire\Admin\Laporan;

use App\Exports\PembelianExport;
use App\Models\Pembelian;
use App\Models\Pemasok;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Response;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class LaporanPembelian extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $searchQuery = '';
    public $startDate;
    public $endDate;
    public $pemasokFilter = ''; // Filter Pemasok

    public function filterData()
    {
        $this->render();
    }
    public function render()
    {
        // Ambil semua pemasok
        $pemasoks = Pemasok::all();

        // Ambil data pembelian dengan filter
        $pembelians = Pembelian::with('detailPembelian.barang')
            ->when($this->searchQuery, function ($query) {
                return $query->whereHas('detailPembelian.barang', function ($query) {
                    $query->where('nama_barang', 'like', '%' . $this->searchQuery . '%');
                });
            })
            ->when($this->startDate && $this->endDate, function ($query) {
                return $query->whereBetween('tanggal_masuk', [$this->startDate, $this->endDate]);
            })
            ->when($this->pemasokFilter, function ($query) {
                return $query->whereHas('pemasok', function ($query) {
                    $query->where('pemasok_id', $this->pemasokFilter); // Filter berdasarkan id pemasok
                });
            })
            ->paginate(10);

        return view('livewire.admin.laporan.laporan-pembelian', [
            'pembelian' => $pembelians,
            'pemasoks' => $pemasoks // Kirim data pemasok ke view
        ]);
    }

    public function exportPdf()
    {
        // Ambil data pembelian yang akan diekspor
        $pembelian = Pembelian::with('detailPembelian.barang')
            ->when($this->searchQuery, function ($query) {
                return $query->whereHas('detailPembelian.barang', function ($query) {
                    $query->where('nama_barang', 'like', '%' . $this->searchQuery . '%');
                });
            })
            ->when($this->startDate && $this->endDate, function ($query) {
                return $query->whereBetween('tanggal_masuk', [$this->startDate, $this->endDate]);
            })
            ->when($this->pemasokFilter, function ($query) {
                return $query->whereHas('pemasok', function ($query) {
                    $query->where('pemasok_id', $this->pemasokFilter);
                });
            })
            ->get();

        $pdf = FacadePdf::loadView('livewire.admin.laporan.pdf.laporan-pembelian', compact('pembelian'))
            ->setPaper('a4', 'landscape');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'laporan_pembelian_' . now()->format('YmdHis') . '.pdf');
    }
    public function exportExcel()
    {
        return Excel::download(new PembelianExport, 'laporan_pembelian.xlsx');
    }
}
