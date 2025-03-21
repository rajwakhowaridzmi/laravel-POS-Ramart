<?php

namespace App\Livewire\Admin\Laporan;

use App\Exports\PenjualanExport;
use App\Models\Penjualan;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class LaporanPenjualan extends Component
{
    use WithPagination;

    public $penjualan_id;
    public $searchQuery, $startDate, $endDate;
    protected $paginationTheme = 'bootstrap';

    public function updatingSearchQuery()
    {
        $this->resetPage();
    }

    public function updatingStartDate()
    {
        $this->resetPage();
    }

    public function updatingEndDate()
    {
        $this->resetPage();
    }

    public function filterData()
    {
        // Filter berdasarkan query pencarian dan tanggal
        $this->resetPage();
    }

    public function render()
    {
        $penjualans = Penjualan::query()
            ->when($this->searchQuery, function ($query) {
                $query->where('no_faktur', 'like', '%' . $this->searchQuery . '%')
                    ->orWhereHas('pelanggan', function ($q) {
                        $q->where('nama', 'like', '%' . $this->searchQuery . '%');
                    });
            })
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereBetween('tgl_faktur', [$this->startDate, $this->endDate]);
            })
            ->orderBy('tgl_faktur', 'desc')
            ->paginate(5);

        return view('livewire.admin.laporan.laporan-penjualan', ['penjualan' => $penjualans]);
    }
    public function exportPdf()
    {
        // Query untuk mengambil data penjualan dengan relasi pelanggan
        $query = Penjualan::with('pelanggan') // Tambahkan ini untuk memuat pelanggan
            ->when($this->searchQuery, function ($query) {
                $query->where('no_faktur', 'like', '%' . $this->searchQuery . '%')
                    ->orWhereHas('pelanggan', function ($q) {
                        $q->where('nama', 'like', '%' . $this->searchQuery . '%');
                    });
            })
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereBetween('tgl_faktur', [$this->startDate, $this->endDate]);
            })
            ->orderBy('tgl_faktur')
            ->get();

        // Pastikan data nama pelanggan diubah ke encoding UTF-8 dan menangani null
        foreach ($query as $penjualan) {
            // Gunakan nullsafe operator untuk mencegah error
            $penjualan->pelanggan_name = $penjualan->pelanggan?->nama ?? 'Nama tidak tersedia';
        }

        // Buat PDF dengan data penjualan
        $pdf = Pdf::loadView('livewire.admin.laporan.pdf.laporan-penjualan', compact('query'))
            ->setPaper('a4', 'potrait');

        // Download PDF menggunakan streamDownload
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'laporan_penjualan_' . now()->format('YmdHis') . '.pdf');
    }
    public function exportExcel()
{
    return Excel::download(new PenjualanExport($this->searchQuery, $this->startDate, $this->endDate), 'laporan_penjualan_' . now()->format('YmdHis') . '.xlsx');
}
}
