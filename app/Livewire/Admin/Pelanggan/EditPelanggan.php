<?php

namespace App\Livewire\Admin\Pelanggan;

use App\Models\Pelanggan;
use Livewire\Component;

class EditPelanggan extends Component
{
    public $pelanggan_id, $kodePelanggan, $nama, $alamat, $no_telp, $email;
    public function mount($pelanggan_id) {
        $pelanggan = Pelanggan::find($pelanggan_id);
        if (!$pelanggan) {
            session()->flash('error', 'Data Tidak Ditemukan');
            return redirect()->route('pelanggan');
        }
        $this->nama = $pelanggan->nama;
        $this->alamat = $pelanggan->alamat;
        $this->no_telp = $pelanggan->no_telp;
        $this->email = $pelanggan->email;
    }
    public function render()
    {
        return view('livewire.admin.pelanggan.edit-pelanggan');
    }
    public function update(){
        $this->validate([
            'nama' => 'required|string|max:50',
            'alamat' => 'required|string|max:200',
            'no_telp' => 'required|string|max:20',
            'email' => 'required|email|max:50',
        ]);

        $pelanggan = Pelanggan::find($this->pelanggan_id);

        if (!$pelanggan) {
            session()->flash('error', 'Data tidak ditemukan.');
            return redirect()->route('pelanggan'); 
        }
        $pelanggan->update([
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'no_telp' => $this->no_telp,
            'email' => $this->email
        ]);
        session()->flash('success', 'Data berhasil diupdate.');
        return redirect()->route('pelanggan');
    }
}
