<?php

namespace App\Livewire\Kasir;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashboardKasir extends Component
{
    public function mount() {
        if (Auth::user()->role !== '1') {
            abort(403, 'Akses ditolak');
        }
    }
    public function render()
    {
        return view('livewire.kasir.dashboard-kasir');
    }
}
