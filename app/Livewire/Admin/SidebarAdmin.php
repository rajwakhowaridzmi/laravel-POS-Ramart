<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SidebarAdmin extends Component
{
    public $role;
    public function mount() {
        $this->role = Auth::user()->role ?? '0';
    }
    public function render()
    {
        return view('livewire.admin.sidebar-admin');
    }
}
