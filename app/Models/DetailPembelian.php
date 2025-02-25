<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    protected $table = 'detail_pembelian';
    protected $fillable = ['id_pembelian', 'id_barang', 'qty', 'harga'];
}
