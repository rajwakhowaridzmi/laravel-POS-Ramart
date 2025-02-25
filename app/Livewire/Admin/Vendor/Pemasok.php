<?php

namespace App\Livewire\Admin\Vendor;

use App\Models\Pemasok as ModelsPemasok;
use Livewire\Component;

class Pemasok extends Component
{
    public $pemasok_id;
    public function render()
    {
        $pemasoks = ModelsPemasok::all();
        return view('livewire.admin.vendor.pemasok', ['pemasok' => $pemasoks ]);
    }
    public function delete(){
        $pemasok = ModelsPemasok::find($this->pemasok_id);

        if($pemasok) {
            $pemasok->delete();
            session()->flash('success', 'Data Berhasil di Hapus');
        }

        $this->pemasok_id = null;

        $this->dispatch('closeModal');
    }

    public function confirmDelete($pemasok_id){
        $this->pemasok_id = $pemasok_id;
    }
}
