<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PoinPelanggan extends Model
{
    protected $table = 'poin_pelanggan';
    protected $primaryKey = 'poin_pelanggan_id';
    public $incrementing = false;
    protected $fillable = [
        'poin_pelanggan_id',
        'pelanggan_id',
        'penjualan_id',
        'poin_didapat',
    ];
    public function pelanggan(){
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id', 'pelanggan_id');
    }
    public function penjualan(){
        return $this->belongsTo(Penjualan::class, 'penjualan_id', 'penjualan_id');
    }
}
