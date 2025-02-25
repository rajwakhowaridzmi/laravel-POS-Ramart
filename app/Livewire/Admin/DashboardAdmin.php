<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashboardAdmin extends Component
{
    public function mount() {
        if (Auth::user()->role !== '0') {
            abort(403, 'Akses ditolak');
        }
    }
    public function render()
    {
        return view('livewire.admin.dashboard-admin');
    }
}
