<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemasok extends Model
{
    protected $table = 'pemasok';
    protected $primaryKey = 'pemasok_id';
    protected $keyType = 'int';

    public $incrementing = false;
    protected $fillable = [
        'pemasok_id',
        'nama_pemasok',
        'alamat',
        'no_telp',
        'email'
    ];
    public function pembelian() {
        return $this->hasMany(Pembelian::class, 'pemasok_id', 'pemasok_id');
    }
}
