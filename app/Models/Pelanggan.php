<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'pelanggan_id';
    protected $keyType = 'int';

    public $incrementing = false;
    public $fillable = [
        'pelanggan_id',
        'kode_pelanggan',
        'nama',
        'alamat',
        'no_telp',
        'email',
        'member_status',
        'total_poin'
    ];
    public function pelanggan() {
        return $this->hasMany(Pelanggan::class, 'pelanggan_id', 'pelanggan_id');
    }
    public function poinPelanggan() {
        return $this->hasMany(PoinPelanggan::class, 'pelanggan_id', 'pelanggan_id');
    }
}
