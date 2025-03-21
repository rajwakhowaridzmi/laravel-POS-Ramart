<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    protected $table = 'pengajuan';
    protected $primaryKey = 'pengajuan_id';
    protected $keyType = 'int';

    public $fillable = [
        'pengajuan_id',
        'pelanggan_id',
        'user_id',
        'nama_barang',
        'tgl_pengajuan',
        'jumlah',
        'status'
    ];

    public function pelanggan() {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id', 'pelanggan_id');
    }
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
