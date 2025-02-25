<?php

namespace App\Livewire\Kasir;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SidebarKasir extends Component
{
    public $role;
    public function mount() {
        $this->role = Auth::user()->role ?? '1';
    }
    public function render()
    {
        return view('livewire.kasir.sidebar-kasir');
    }
}
