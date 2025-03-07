<?php

use App\Http\Middleware\RoleMiddleware;
use App\Livewire\Admin\Barang\Barang;
use App\Livewire\Admin\Barang\EditBarang;
use App\Livewire\Admin\Barang\TambahBarang;
use App\Livewire\Admin\DashboardAdmin;
use App\Livewire\Admin\Pelanggan\EditPelanggan;
use App\Livewire\Admin\Pelanggan\Pelanggan;
use App\Livewire\Admin\Pelanggan\TambahPelanggan;
use App\Livewire\Admin\Pembelian\Pembelian;
use App\Livewire\Admin\Pembelian\TambahPembelian;
use App\Livewire\Admin\Produk\EditProduk;
use App\Livewire\Admin\Produk\Produk;
use App\Livewire\Admin\Produk\TambahProduk;
use App\Livewire\Admin\Vendor\EditPemasok;
use App\Livewire\Admin\Vendor\Pemasok as VendorPemasok;
use App\Livewire\Admin\Vendor\TambahPemasok;
use App\Livewire\Dashboard;
use App\Livewire\Kasir\DashboardKasir;
use App\Livewire\Login;
use App\Models\Pemasok;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', Login::class)->name('login');

Route::middleware(['auth', RoleMiddleware::class.':0'])->group(function () {
    Route::get('/dashboard-admin', DashboardAdmin::class)->name('dashboard-admin');
    Route::get('/pemasok', VendorPemasok::class)->name('pemasok');
    Route::get('/tambah-pemasok', TambahPemasok::class)->name('tambah-pemasok');
    Route::get('/edit-pemasok/{pemasok_id}', EditPemasok::class)->name('edit-pemasok');

    Route::get('/produk', Produk::class)->name('produk');
    Route::get('/tambah-produk', TambahProduk::class)->name('tambah-produk');
    Route::get('/edit-produk/{produk_id}', EditProduk::class)->name('edit-produk');

    Route::get('/pelanggan', Pelanggan::class)->name('pelanggan');
    Route::get('/tambah-pelanggan', TambahPelanggan::class)->name('tambah-pelanggan');
    Route::get('/edit-pelanggan/{pelanggan_id}', EditPelanggan::class)->name('edit-pelanggan');

    Route::get('/barang', Barang::class)->name('barang');
    Route::get('/tambah-barang', TambahBarang::class)->name('tambah-barang');
    Route::get('/edit-barang/{barang_id}', EditBarang::class)->name('edit-barang');

    Route::get('/pembelian', Pembelian::class)->name('pembelian');
    Route::get('/tambah-pembelian', TambahPembelian::class)->name('tambah-pembelian');
});

Route::middleware(['auth', RoleMiddleware::class.':1'])->group(function () {
    Route::get('/dashboard-kasir', DashboardKasir::class)->name('dashboard-kasir');
});

