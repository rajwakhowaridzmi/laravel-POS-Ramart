<?php

namespace App\Livewire\Admin\User;

use Livewire\Component;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class TambahUser extends Component
{
    public $nama, $email, $password, $role;

    // Fungsi untuk menyimpan data dan validasi
    public function store()
    {
        // Validasi input menggunakan format yang Anda inginkan
        $this->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:0,1',
        ], [
            'nama.required' => 'Nama tidak boleh kosong',
            'nama.string' => 'Nama harus berupa teks',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password harus minimal 6 karakter',
            'role.required' => 'Role tidak boleh kosong',
            'role.in' => 'Role harus bernilai 0 atau 1',
        ]);

        try {
            // Menyimpan data user baru setelah validasi
            User::create([
                'nama' => $this->nama,
                'email' => $this->email,
                'password' => md5($this->password), // Menggunakan MD5 untuk password
                'role' => $this->role,
            ]);

            // Memberikan feedback sukses
            session()->flash('success', 'User berhasil ditambahkan!');
            
            // Mengarahkan setelah data disimpan (misalnya ke halaman daftar user)
            return redirect()->route('user'); // Sesuaikan dengan rute yang sesuai
        } catch (\Exception $e) {
            // Menangani kesalahan lain
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.user.tambah-user');
    }
}
