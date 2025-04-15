<?php

use App\Http\Middleware\RoleMiddleware;
use App\Livewire\Admin\Barang\Barang;
use App\Livewire\Admin\Barang\EditBarang;
use App\Livewire\Admin\Barang\TambahBarang;
use App\Livewire\Admin\DashboardAdmin;
use App\Livewire\Admin\Laporan\LaporanBarang;
use App\Livewire\Admin\Laporan\LaporanPembelian;
use App\Livewire\Admin\Laporan\LaporanPenjualan;
use App\Livewire\Admin\Pelanggan\EditPelanggan;
use App\Livewire\Admin\Pelanggan\Pelanggan;
use App\Livewire\Admin\Pelanggan\TambahPelanggan;
use App\Livewire\Admin\Pembelian\DetailPembelian;
use App\Livewire\Admin\Pembelian\Pembelian;
use App\Livewire\Admin\Pembelian\TambahPembelian;
use App\Livewire\Admin\Pengajuan\Pengajuan;
use App\Livewire\Admin\Pengajuan\TambahPengajuan;
use App\Livewire\Admin\Penjualan\DetailPenjualan;
use App\Livewire\Admin\Penjualan\Penjualan;
use App\Livewire\Admin\Penjualan\StrukPenjualan;
use App\Livewire\Admin\Penjualan\TambahPenjualan;
use App\Livewire\Admin\Produk\EditProduk;
use App\Livewire\Admin\Produk\Produk;
use App\Livewire\Admin\Produk\TambahProduk;
use App\Livewire\Admin\User\TambahUser;
use App\Livewire\Admin\User\User;
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
    Route::get('/user', User::class)->name('user');

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
    Route::get('/detail-pembelian/{pembelian_id}', DetailPembelian::class)->name('detail-pembelian');

    Route::get('/penjualan', Penjualan::class)->name('penjualan');
    Route::get('/tambah-penjualan', TambahPenjualan::class)->name('tambah-penjualan');
    Route::get('/detail-penjualan/{penjualan_id}', DetailPenjualan::class)->name('detail-penjualan');

    Route::get('/laporan-barang', LaporanBarang::class)->name('laporan-barang');
    Route::get('/laporan-penjualan', LaporanPenjualan::class)->name('laporan-penjualan');
    Route::get('/laporan-pembelian', LaporanPembelian::class)->name('laporan_pembelian');

    Route::get('/pengajuan', Pengajuan::class)->name('pengajuan');

    Route::get('/struk/${penjualan_id}', StrukPenjualan::class)->name('struk-penjualan');

    Route::get('/tambah-user', TambahUser::class)->name('tambah-user');
});

Route::middleware(['auth', RoleMiddleware::class.':1'])->group(function () {
    Route::get('/kasir/dashboard', DashboardKasir::class)->name('dashboard-kasir');

    Route::get('/kasir/penjualan', Penjualan::class)->name('penjualan-kasir');
    Route::get('/kasir/tambah-penjualan', TambahPenjualan::class)->name('tambah-penjualan-kasir');
    Route::get('/kasir/detail-penjualan/{penjualan_id}', DetailPenjualan::class)->name('detail-penjualan-kasir');

    Route::get('/kasir/pelanggan', Pelanggan::class)->name('pelanggan-kasir');
    Route::get('/kasir/tambah-pelanggan', TambahPelanggan::class)->name('tambah-pelanggan-kasir');
    Route::get('/kasir/edit-pelanggan/{pelanggan_id}', EditPelanggan::class)->name('edit-pelanggan-kasir');

    Route::get('/kasir/pengajuan', Pengajuan::class)->name('pengajuan-kasir');
});

