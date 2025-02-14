<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan'; 
    protected $primaryKey = 'penjualan_id';
    protected $keyType = 'int';

    public $incrementing = false;
    public $fillable = [
        'penjualan_id',
        'no_faktur',
        'tanggal_faktur',
        'total_bayar',
        'pelanggan_id',
        'user_id'
    ];
    public function pelanggan(){
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id', 'pelanggan_id');
    }
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    public function detailPenjualan(){
        return $this->hasMany(DetailPenjualan::class, 'penjualan_id', 'penjualan_id');
    }
}
