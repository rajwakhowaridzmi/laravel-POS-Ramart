<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    protected $table = 'detail_pembelian';
    protected $primaryKey = 'detail_pembelian_id';
    protected $keyType = 'int';

    public $incrementing = false;
    protected $fillable = [
        'detail_pembelian_id',
        'pembelian_id',
        'barang_id',
        'harga_beli',
        'jumlah',
        'sub_total'
    ];
    public function pembelian() {
        return $this->belongsTo(Pembelian::class, 'pembelian_id', 'pembelian_id');
    }
    public function barang() {
        return $this->belongsTo(Barang::class, 'barang_id', 'barang_id');
    }
}
