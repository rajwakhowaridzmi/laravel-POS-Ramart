<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'barang_id';
    protected $keyType = 'int';

    public $incrementing = false;
    protected $fillable = [
        'barang_id',
        'kode_barang',
        'produk_id',
        'nama_barang',
        'satuan',
        'harga_jual',
        'stok',
        'status_barang',
        'user_id'
    ];
    public function produk() {
        return $this->belongsTo(Produk::class, 'produk_id', 'produk_id');
    }
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function detailPenjualan() {
        return $this->hasMany(DetailPenjualan::class, 'barang_id', 'barang_id');
    }
    public function detailPembelian() {
        return $this->hasMany(DetailPembelian::class, 'barang_id', 'barang_id');
    }
}
