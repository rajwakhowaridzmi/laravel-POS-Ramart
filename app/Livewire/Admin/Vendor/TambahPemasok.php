<?php

namespace App\Livewire\Admin\Vendor;

use App\Models\Pemasok;
use Livewire\Component;

class TambahPemasok extends Component
{
    public $nama_pemasok, $alamat, $no_telp, $email;
    public function store(){
        $this->validate([
            'nama_pemasok' => 'required|string|max:50',
            'alamat' => 'required|string|max:200',
            'no_telp' => 'required|string|max:20',
            'email' => 'required|string|email|max:255'
        ], [
            'nama_pemasok.required' => 'Nama Pemasok tidak boleh kosong',
            'nama_pemasok.max' => 'Nama Pemasok tidak boleh lebih dari 50',
            'alamat.required' => 'Alamat tidak boleh kosong',
            'alamat.max' => 'Alamat tidak boleh lebih dari 200',
            'no_telp.required' => 'No Telp tidak boleh kosong',
            'no_telp.max' => 'No Telp tidak boleh lebih dari 20',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Format email tidak valid',
            'email.max' => 'Email tidak boleh lebih dari 255',
        ]);

        Pemasok::create([
            'nama_pemasok' => $this->nama_pemasok,
            'alamat' => $this->alamat,
            'no_telp' => $this->no_telp,
            'email' => $this->email,
        ]);

        session()->flash('success', 'Data Berhasil Ditambahkan');
        return redirect()->route('pemasok');
    }
    public function render()
    {
        return view('livewire.admin.vendor.tambah-pemasok');
    }
}
