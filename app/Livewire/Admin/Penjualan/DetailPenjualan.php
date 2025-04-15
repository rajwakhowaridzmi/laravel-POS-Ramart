<?php 
namespace App\Livewire\Admin\Penjualan;

use App\Models\Penjualan;
use Livewire\Component;

class DetailPenjualan extends Component
{
    public $penjualan_id, $penjualan;

    /**
     * Fungsi ini dijalankan saat komponen pertama kali dimuat.
     * Jika parameter `penjualan_id` diberikan, fungsi ini akan mengambil 
     * data penjualan terkait dari database bersama dengan detail barang yang 
     * dijual melalui relasi yang ada.
     */
    public function mount($penjualan_id = null)
    {
        if ($penjualan_id) {
            $this->penjualan = Penjualan::with('detailPenjualan.barang')->find($penjualan_id);
        }
    }

    /**
     * Fungsi untuk merender tampilan komponen Livewire.
     * Mengirimkan data penjualan ke tampilan untuk ditampilkan.
     */
    public function render()
    {
        return view('livewire.admin.penjualan.detail-penjualan', [
            'penjualan' => $this->penjualan,
        ]);
    }
}
