<?php

namespace App\Livewire\Admin\Vendor;

use App\Models\Pemasok as ModelsPemasok;
use Livewire\Component;
use Livewire\WithPagination;

class Pemasok extends Component
{
    use WithPagination;
    public $pemasok_id;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $pemasoks = ModelsPemasok::paginate(5);
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
