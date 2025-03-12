<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk'; 
    protected $primaryKey = 'produk_id';
    protected $keyType = 'int';

    public $incrementing = false;
    
    protected $fillable = [
        'produk_id',
        'nama_produk',
    ];
    
    public function barang()
    {
        return $this->hasMany(Barang::class, 'produk_id', 'produk_id');
    }
}
