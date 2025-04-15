<?php

namespace App\Livewire\Admin\Vendor;

use App\Models\Pemasok;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class TambahPemasok extends Component
{
    public $nama_pemasok, $alamat, $no_telp, $email;

    /**
     * menyimpan data pemasok baru.
     * Melakukan validasi input dan menyimpan data ke database.
     */
    public function store()
    {
        $this->validate([
            'nama_pemasok' => 'required|string|max:50|unique:pemasok,nama_pemasok',
            'alamat' => 'required|string|max:200',
            'no_telp' => 'required|string|max:20|unique:pemasok,no_telp',
            'email' => 'required|string|email|max:255|unique:pemasok,email'
        ], [
            'nama_pemasok.required' => 'Nama Pemasok tidak boleh kosong',
            'nama_pemasok.max' => 'Nama Pemasok tidak boleh lebih dari 50',
            'nama_pemasok.unique' => 'Nama Pemasok sudah terdaftar',
            'alamat.required' => 'Alamat tidak boleh kosong',
            'alamat.max' => 'Alamat tidak boleh lebih dari 200',
            'no_telp.required' => 'No Telp tidak boleh kosong',
            'no_telp.max' => 'No Telp tidak boleh lebih dari 20',
            'no_telp.unique' => 'No Telp sudah digunakan',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Format email tidak valid',
            'email.max' => 'Email tidak boleh lebih dari 255',
            'email.unique' => 'Email sudah digunakan',
        ]);

        try {
            Pemasok::create([
                'nama_pemasok' => $this->nama_pemasok,
                'alamat' => $this->alamat,
                'no_telp' => $this->no_telp,
                'email' => $this->email,
            ]);

            Log::info('Data pemasok berhasil ditambahkan', [
                'nama_pemasok' => $this->nama_pemasok
            ]);

            session()->flash('success', 'Data Berhasil Ditambahkan');
            return redirect()->route('pemasok');

        } catch (\Exception $e) {
            Log::error('Gagal menambahkan pemasok', [
                'error' => $e->getMessage(),
                'input' => [
                    'nama_pemasok' => $this->nama_pemasok,
                    'alamat' => $this->alamat,
                    'no_telp' => $this->no_telp,
                    'email' => $this->email,
                ]
            ]);

            session()->flash('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    /**
     * Menampilkan halaman form tambah pemasok.
     */
    public function render()
    {
        return view('livewire.admin.vendor.tambah-pemasok');
    }
}
