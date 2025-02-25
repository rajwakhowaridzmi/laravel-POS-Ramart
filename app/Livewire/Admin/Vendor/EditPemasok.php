<?php

namespace App\Livewire\Admin\Vendor;

use App\Models\Pemasok;
use Livewire\Component;

class EditPemasok extends Component
{
    public $pemasok_id, $nama_pemasok, $alamat, $no_telp, $email;
    public function mount($pemasok_id){
        $pemasok = Pemasok::find($pemasok_id);
        if (!$pemasok) {
            session()->flash('error', 'Data tidak ditemukan.');
            return redirect()->route('pemasok');
        }
        
        $this->nama_pemasok = $pemasok->nama_pemasok;
        $this->alamat = $pemasok->alamat;
        $this->no_telp = $pemasok->no_telp;
        $this->email = $pemasok->email;
    }
    public function render()
    {
        return view('livewire.admin.vendor.edit-pemasok');
    }
    public function update(){

        $this->validate([
            'nama_pemasok' => 'required|string|max:50',
            'alamat' => 'required|string|max:200',
            'no_telp' => 'required|string|max:20',
            'email' => 'required|string|email|max:255'
        ]);

        // dd($this->nama_pemasok, $this->alamat, $this->no_telp, $this->email);

        $pemasok = Pemasok::find($this->pemasok_id);

        if (!$pemasok) {
            session()->flash('error', 'Data tidak ditemukan.');
            return redirect()->route('pemasok'); 
        }

        $pemasok->update([
            'nama_pemasok' => $this->nama_pemasok,
            'alamat' => $this->alamat,
            'no_telp' => $this->no_telp,
            'email' => $this->email,
        ]);

        session()->flash('success', 'Data berhasil diupdate.');
        return redirect()->route('pemasok');
    }
}
