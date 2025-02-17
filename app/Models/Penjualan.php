<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';
    protected $fillable = [
        'nama_barang',
        'no_faktur',
        'tanggal',
        'jumlah',
        'total',
    ];
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}

