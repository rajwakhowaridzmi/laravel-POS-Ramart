<?php

namespace App\Livewire\Admin\Pelanggan;

use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Models\Pelanggan as ModelsPelanggan;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Pelanggan extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $pelanggan_id;
    public $selectedPelangganId;

public function confirmToggleStatus($pelanggan_id)
{
    $this->selectedPelangganId = $pelanggan_id;
    $this->dispatch('showToggleStatusModal');
}

public function toggleMemberStatus()
{
    $pelanggan = DB::table('pelanggan')->where('pelanggan_id', $this->selectedPelangganId)->first();

    if ($pelanggan) {
        $newStatus = $pelanggan->member_status == '1' ? '0' : '1';
        DB::table('pelanggan')->where('pelanggan_id', $this->selectedPelangganId)->update(['member_status' => $newStatus]);

        session()->flash('success', 'Status member berhasil diubah!');
    }

    $this->dispatch('closeModal');
}

    public function render()
    {
        $pelanggans = ModelsPelanggan::orderBy('pelanggan_id', 'asc')->paginate(5);
        return view('livewire.admin.pelanggan.pelanggan', ['pelanggans' => $pelanggans]);
    }
    
    public function delete(){
        $pelanggan = ModelsPelanggan::find($this->pelanggan_id);

        if($pelanggan) {
            $pelanggan->delete();
            session()->flash('success', 'Data Berhasil di Hapus');
        }

        $this->pelanggan_id = null;

        $this->dispatch('closeModal');
    }

    public function confirmDelete($pelanggan_id){
        $this->pelanggan_id = $pelanggan_id;
    }
    public function exportPdf()
    {
        $pelanggans = ModelsPelanggan::all();

        // Setup DomPDF
        $dompdf = new Dompdf();
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf->setOptions($options);

        // Generate HTML content
        $html = view('livewire.admin.laporan.pdf.pelanggan-pdf', compact('pelanggans'))->render();

        // Load HTML content into DomPDF
        $dompdf->loadHtml($html);

        // Set paper size
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF (first pass)
        $dompdf->render();

        // Stream the file to the browser
        return $dompdf->stream('daftar_pelanggan.pdf');
    }

}
