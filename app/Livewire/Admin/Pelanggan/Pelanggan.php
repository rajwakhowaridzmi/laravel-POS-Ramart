<?php

namespace App\Livewire\Admin\Pelanggan;

use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Models\Pelanggan as ModelsPelanggan;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class Pelanggan extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $pelanggan_id;
    public $selectedPelangganId;

    /**
     * Menampilkan daftar pelanggan dengan paginasi
     */
    public function render()
    {
        $pelanggans = ModelsPelanggan::orderBy('pelanggan_id', 'asc')->paginate(5);
        return view('livewire.admin.pelanggan.pelanggan', ['pelanggans' => $pelanggans]);
    }

    /**
     * Menampilkan konfirmasi sebelum mengubah status member
     */
    public function confirmToggleStatus($pelanggan_id)
    {
        $this->selectedPelangganId = $pelanggan_id;
        $this->dispatch('showToggleStatusModal');
    }

    /**
     * Mengubah status member pelanggan (aktif atau tidak)
     */
    public function toggleMemberStatus()
    {
        try {
            $pelanggan = DB::table('pelanggan')->where('pelanggan_id', $this->selectedPelangganId)->first();

            if ($pelanggan) {
                $newStatus = $pelanggan->member_status == '1' ? '0' : '1';
                DB::table('pelanggan')->where('pelanggan_id', $this->selectedPelangganId)->update(['member_status' => $newStatus]);

                session()->flash('success', 'Status member berhasil diubah!');
            }
        } catch (\Exception $e) {
            Log::error('Gagal mengubah status member', [
                'error' => $e->getMessage(),
                'pelanggan_id' => $this->selectedPelangganId,
            ]);
            session()->flash('error', 'Terjadi kesalahan saat mengubah status member.');
        }

        $this->dispatch('closeModal');
    }

    /**
     * Menampilkan konfirmasi sebelum menghapus data pelanggan
     */
    public function confirmDelete($pelanggan_id)
    {
        $this->pelanggan_id = $pelanggan_id;
    }

    /**
     * Menghapus data pelanggan berdasarkan ID
     */
    public function delete()
    {
        try {
            $pelanggan = ModelsPelanggan::find($this->pelanggan_id);

            if ($pelanggan) {
                $pelanggan->delete();
                session()->flash('success', 'Data Berhasil di Hapus');
            }
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data pelanggan', [
                'error' => $e->getMessage(),
                'pelanggan_id' => $this->pelanggan_id,
            ]);
            session()->flash('error', 'Terjadi kesalahan saat menghapus data.');
        }

        $this->pelanggan_id = null;
        $this->dispatch('closeModal');
    }
    public function exportPdf()
    {
        $pelanggans = ModelsPelanggan::all();

        $dompdf = new Dompdf();
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf->setOptions($options);

        $html = view('livewire.admin.laporan.pdf.pelanggan-pdf', compact('pelanggans'))->render();

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        return $dompdf->stream('daftar_pelanggan.pdf');
    }
}
