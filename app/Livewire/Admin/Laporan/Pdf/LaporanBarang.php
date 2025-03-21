<?php
namespace App\Livewire\Admin\Laporan\Pdf;

use App\Models\Barang;
use Livewire\Component;
use Barryvdh\DomPDF\Facade as PDF; // Pastikan ini sudah di-import

class LaporanBarang extends Component
{
    // Method untuk menampilkan halaman view
    public function render()
    {
        return view('livewire.admin.laporan.pdf.laporan-barang');
    }

}
