<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Login extends Component
{
    #[Layout('components.layouts.login')]

    public $email, $password, $error = false;
    public function render()
    {
        return view('livewire.login');
    }

    public function login()
    {
        $user = User::where('email', $this->email)
            ->where('password', md5($this->password))
            ->first();

        if ($user) {
            Auth::login($user);
            return match ($user->role) {
                '0' => redirect()->route('dashboard-admin'),
                '1' => redirect()->route('dashboard-kasir'),
                default => redirect()->route('dashboard'),
            };
        }

        $this->error = true;
        session()->flash('error', 'Email atau Password salah');
    }
}
