<?php

namespace App\Livewire\Admin\Vendor;

use App\Models\Pemasok as ModelsPemasok;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class Pemasok extends Component
{
    use WithPagination;
    public $pemasok_id;
    protected $paginationTheme = 'bootstrap';

    /**
     * Menampilkan daftar pemasok dengan pagination.
     * Mengambil data pemasok dari database dan menampilkan halaman dengan data tersebut.
     */
    public function render()
    {
        $pemasoks = ModelsPemasok::paginate(5);
        return view('livewire.admin.vendor.pemasok', ['pemasok' => $pemasoks]);
    }

    /**
     * Menghapus data pemasok berdasarkan ID.
     */
    public function delete()
    {
        try {
            $pemasok = ModelsPemasok::find($this->pemasok_id);

            if ($pemasok) {
                $pemasok->delete();
                session()->flash('success', 'Data Berhasil di Hapus');
            } else {
                session()->flash('error', 'Data pemasok tidak ditemukan.');
            }

            $this->pemasok_id = null;

            $this->dispatch('closeModal');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data pemasok', [
                'error' => $e->getMessage(),
                'pemasok_id' => $this->pemasok_id
            ]);

            session()->flash('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    /**
     * ID pemasok yang akan dihapus.
     * Dipanggil saat pengguna mengklik tombol konfirmasi untuk menghapus.
     */
    public function confirmDelete($pemasok_id)
    {
        $this->pemasok_id = $pemasok_id;
    }
}
