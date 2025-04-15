<?php

namespace App\Livewire\Admin\Vendor;

use App\Models\Pemasok;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class EditPemasok extends Component
{
    public $pemasok_id, $nama_pemasok, $alamat, $no_telp, $email;

    /**
     * Mengambil data pemasok berdasarkan ID.
     * Jika pemasok tidak ditemukan, pengguna akan diarahkan kembali dengan pesan error.
     */
    public function mount($pemasok_id)
    {
        $pemasok = Pemasok::find($pemasok_id);

        if (!$pemasok) {
            session()->flash('error', 'Data tidak ditemukan.');
            return redirect()->route('pemasok');
        }

        // Mengisi data input form dengan data pemasok yang ditemukan
        $this->nama_pemasok = $pemasok->nama_pemasok;
        $this->alamat = $pemasok->alamat;
        $this->no_telp = $pemasok->no_telp;
        $this->email = $pemasok->email;
    }

    /**
     * Menampilkan tampilan halaman form edit pemasok.
     */
    public function render()
    {
        return view('livewire.admin.vendor.edit-pemasok');
    }

    /**
     * Mengupdate data pemasok.
     * Melakukan validasi input dan menyimpan perubahan ke database.
     */
    public function update()
    {
        $this->validate([
            'nama_pemasok' => 'required|string|max:50',
            'alamat' => 'required|string|max:200',
            'no_telp' => 'required|string|max:20',
            'email' => 'required|string|email|max:255'
        ]);

        try {
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
            
        } catch (\Exception $e) {
            Log::error('Gagal mengupdate data pemasok', [
                'error' => $e->getMessage(),
                'input' => [
                    'nama_pemasok' => $this->nama_pemasok,
                    'alamat' => $this->alamat,
                    'no_telp' => $this->no_telp,
                    'email' => $this->email,
                ]
            ]);

            session()->flash('error', 'Terjadi kesalahan saat mengupdate data.');
        }
    }
}
