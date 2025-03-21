<?php

namespace App\Livewire\Admin\User;

use Livewire\Component;
use Livewire\WithPagination;

class User extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $user_id;
    public function render()
    {
        $users = \App\Models\User::paginate(5);
        return view('livewire.admin.user.user', ['user' => $users]);
    }
}
