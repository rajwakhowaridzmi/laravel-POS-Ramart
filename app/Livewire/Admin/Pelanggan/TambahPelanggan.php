<?php

namespace App\Livewire\Admin\Pelanggan;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class TambahPelanggan extends Component
{
    public $nama, $alamat, $no_telp, $email;

    /**
     * Menyimpan data pelanggan baru ke database.
     * Melakukan validasi input, generate kode pelanggan, dan menyimpan data ke tabel.
     */
    public function store()
    {
        $this->validate([
            'nama' => 'required|string|max:50',
            'alamat' => 'required|string|max:200',
            'no_telp' => 'required|string|max:20',
            'email' => 'required|email|max:50',
        ], [
            'nama.required' => 'Nama Pelanggan tidak boleh kosong',
            'nama.max' => 'Nama Pelanggan tidak boleh lebih dari 50 karakter',
            'alamat.required' => 'Alamat Pelanggan tidak boleh kosong',
            'alamat.max' => 'Alamat Pelanggan tidak boleh lebih dari 200 karakter',
            'no_telp.required' => 'No Telepon Pelanggan tidak boleh kosong',
            'no_telp.max' => 'No Telepon Pelanggan tidak boleh lebih dari 20 karakter',
            'email.required' => 'Email Pelanggan tidak boleh kosong',
            'email.email' => 'Email Pelanggan tidak valid',
            'email.max' => 'Email Pelanggan tidak boleh lebih dari 50 karakter',
        ]);

        $tahunSekarang = date('Y');

        try {
            $noUrutBaru = DB::table('pelanggan')
                ->select(DB::raw("IFNULL(MAX(SUBSTRING(kode_pelanggan, 8, 5)), 0) + 1 AS no_urut"))
                ->whereRaw("SUBSTRING(kode_pelanggan, 4, 4) = ?", [$tahunSekarang])
                ->value('no_urut');

            $noUrutBaru = str_pad($noUrutBaru, 5, '0', STR_PAD_LEFT);

            $kodePelanggan = "PLG" . $tahunSekarang . $noUrutBaru;

            DB::table('pelanggan')->insert([
                'kode_pelanggan' => $kodePelanggan,
                'nama' => $this->nama,
                'alamat' => $this->alamat,
                'no_telp' => $this->no_telp,
                'email' => $this->email,
                'member_status' => '1',
                'total_poin' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            session()->flash('success', 'Data Berhasil Ditambahkan');

            return redirect()->route('pelanggan');
        } catch (\Exception $e) {
            Log::error('Gagal menambahkan data pelanggan', [
                'error' => $e->getMessage(),
                'input' => [
                    'nama' => $this->nama,
                    'alamat' => $this->alamat,
                    'no_telp' => $this->no_telp,
                    'email' => $this->email,
                ]
            ]);

            session()->flash('error', 'Terjadi kesalahan saat menambahkan data.');
        }
    }

    /**
     * Menampilkan form untuk tambah pelanggan
     */
    public function render()
    {
        return view('livewire.admin.pelanggan.tambah-pelanggan');
    }
}
