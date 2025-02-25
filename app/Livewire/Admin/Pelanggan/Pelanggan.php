<?php

namespace App\Livewire\Admin\Pelanggan;

use App\Models\Pelanggan as ModelsPelanggan;
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
}
