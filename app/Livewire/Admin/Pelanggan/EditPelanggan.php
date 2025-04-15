<?php

namespace App\Livewire\Admin\Pelanggan;

use App\Models\Pelanggan;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class EditPelanggan extends Component
{
    public $pelanggan_id, $kodePelanggan, $nama, $alamat, $no_telp, $email;

    /**
     * Mengambil data pelanggan berdasarkan ID yang diterima.
     */
    public function mount($pelanggan_id)
    {
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

    /**
     * Menampilkan form edit pelanggan.
     */
    public function render()
    {
        return view('livewire.admin.pelanggan.edit-pelanggan');
    }

    /**
     * Mengupdate data pelanggan.
     * Melakukan validasi input dan menyimpan perubahan ke database.
     */
    public function update()
    {
        $this->validate([
            'nama' => 'required|string|max:50',
            'alamat' => 'required|string|max:200',
            'no_telp' => 'required|string|max:20',
            'email' => 'required|email|max:50',
        ], [
            'nama.required' => 'Nama Pelanggan tidak boleh kosong',
            'nama.max' => 'Nama Pelanggan tidak boleh lebih dari 50 karakter',
            'alamat.required' => 'Alamat tidak boleh kosong',
            'alamat.max' => 'Alamat tidak boleh lebih dari 200 karakter',
            'no_telp.required' => 'No Telepon tidak boleh kosong',
            'no_telp.max' => 'No Telepon tidak boleh lebih dari 20 karakter',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Format email tidak valid',
            'email.max' => 'Email tidak boleh lebih dari 50 karakter',
        ]);

        try {
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
        } catch (\Exception $e) {
            Log::error('Gagal mengupdate data pelanggan', [
                'error' => $e->getMessage(),
                'input' => [
                    'id' => $this->pelanggan_id,
                    'nama' => $this->nama,
                    'alamat' => $this->alamat,
                    'no_telp' => $this->no_telp,
                    'email' => $this->email,
                ]
            ]);

            session()->flash('error', 'Terjadi kesalahan saat mengupdate data.');
        }
    }
}
