<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $table = 'pembelian';
    protected $primaryKey = 'pembelian_id';
    protected $keyType = 'int';

    // public $incrementing = false;
    protected $fillable = [
        'pembelian_id',
        'kode_masuk',
        'tanggal_masuk',
        'pemasok_id',
        'user_id'
    ];
    public function pemasok(){
        return $this->belongsTo(Pemasok::class, 'pemasok_id', 'pemasok_id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    public function detailPembelian() {
        return $this->hasMany(DetailPembelian::class, 'pembelian_id', 'pembelian_id');
    }
}
