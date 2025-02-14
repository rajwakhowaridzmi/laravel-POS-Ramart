<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    protected $table = 'detail_penjualan';
    protected $primaryKey = 'detail_penjualan_id';
    protected $keyType = 'int';

    public $incrementing = false;
    protected $fillable = [
        'detail_penjualan_id',
        'penjualan_id',
        'barang_id',
        'harga_jual',
        'jumlah',
        'sub_total'
    ];
    public function penjualan() {
        return $this->belongsTo(Penjualan::class, 'penjualan_id', 'penjualan_id');
    }
    public function barang() {
        return $this->belongsTo(Barang::class, 'barang_id', 'barang_id');
    }
}
