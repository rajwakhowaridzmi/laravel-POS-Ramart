<?php

namespace App\Livewire\Admin\Pengajuan;

use App\Exports\PengajuanExport;
use App\Models\Pelanggan;
use App\Models\Pengajuan as ModelsPengajuan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Pengajuan extends Component
{
    use WithPagination;

    public $pengajuan_id, $pelanggan_id, $nama_barang, $jumlah, $nama;
    public $searchPelanggan = '';
    public $filteredPelanggan = [];
    protected $paginationTheme = 'bootstrap';

    public function showModal()
    {
        $this->resetInputFields();
        $this->dispatch('show-pengajuan-modal'); // Perubahan di sini
    }

    public function updatedSearchPelanggan()
    {
        if (!empty($this->searchPelanggan)) {
            $this->filteredPelanggan = Pelanggan::where('nama', 'like', '%' . $this->searchPelanggan . '%')->get();
        } else {
            $this->filteredPelanggan = [];
        }
    }

    public function selectPelanggan($id, $nama)
    {
        $this->pelanggan_id = $id;
        $this->searchPelanggan = $nama;
        $this->filteredPelanggan = [];
    }

    public function resetPelanggan()
    {
        $this->pelanggan_id = null;
        $this->searchPelanggan = '';
    }

    public function resetForm()
    {
        $this->reset(['pelanggan_id', 'searchPelanggan', 'nama_barang', 'jumlah']);
    }

    public function store()
    {
        $this->validate([
            'pelanggan_id' => 'required',
            'nama_barang' => 'required',
            'jumlah' => 'required|numeric',
        ]);

        ModelsPengajuan::create([
            'pelanggan_id' => $this->pelanggan_id,
            'user_id' => Auth::id(),
            'nama_barang' => $this->nama_barang,
            'jumlah' => $this->jumlah,
            'tgl_pengajuan' => now(),
            'status' => '0',
        ]);

        session()->flash('success', 'Pengajuan berhasil ditambahkan');
        $this->dispatch('close-pengajuan-modal');
        $this->resetInputFields();
    }
    public function edit($pengajuan_id)
    {
        $pengajuan = ModelsPengajuan::findOrFail($pengajuan_id);
        $this->pengajuan_id = $pengajuan->pengajuan_id;
        $this->nama = $pengajuan->pelanggan->nama;
        $this->nama_barang = $pengajuan->nama_barang;
        $this->jumlah = $pengajuan->jumlah;

        $this->dispatch('show-edit-modal');
    }

    public function update()
    {
        $this->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
        ]);

        ModelsPengajuan::where('pengajuan_id', $this->pengajuan_id)->update([
            'nama_barang' => $this->nama_barang,
            'jumlah' => $this->jumlah,
        ]);

        session()->flash('success', 'Pengajuan berhasil diperbarui.');
        $this->dispatch('close-edit-modal');
    }
    private function resetInputFields()
    {
        $this->pelanggan_id = null;
        $this->nama_barang = null;
        $this->jumlah = null;
    }
    public function toggleTerpenuhi($pengajuan_id)
    {
        $pengajuan = ModelsPengajuan::find($pengajuan_id);

        if ($pengajuan) {
            $pengajuan->status = $pengajuan->status == '1' ? '0' : '1';
            $pengajuan->save();
        }
    }

    public function closeEditModal()
    {
        $this->dispatch('close-edit-modal');
    }

    public function confirmDelete($id)
    {
        $this->pengajuan_id = $id;
        $this->dispatch('show-hapus-modal');
    }

    public function deletePengajuan()
    {
        if ($this->pengajuan_id) {
            ModelsPengajuan::where('pengajuan_id', $this->pengajuan_id)->delete();
            session()->flash('success', 'Data pengajuan berhasil dihapus.');

            // Reset ID dan tutup modal
            $this->pengajuan_id = null;
            $this->dispatch('close-hapus-modal');
        }
    }
    public function exportPdf()
    {
        $pengajuans = ModelsPengajuan::all();

        $pdf = Pdf::loadView('livewire.admin.pengajuan.export-pdf', ['pengajuan' => $pengajuans]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'daftar_pengajuan.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new PengajuanExport, 'daftar_pengajuan.xlsx');
    }
    public function render()
    {
        $pengajuans = ModelsPengajuan::paginate(5);
        $pelanggans = Pelanggan::all();
        return view('livewire.admin.pengajuan.pengajuan', ['pengajuan' => $pengajuans, 'pelanggan' => $pelanggans]);
    }
}
