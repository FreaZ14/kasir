<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailPembelian extends Model
{
    use HasFactory;
    protected $table = 'detail_pembelian';
    protected $fillable = ['id', 'id_pembelian', 'id_barang', 'qty', 'harga'];

    public function barang()
{
    return $this->belongsTo(Barang::class, 'id_barang');
}

}


