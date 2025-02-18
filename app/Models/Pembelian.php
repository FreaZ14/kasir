<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelian';

    protected $fillable = [
        'user_id','id_barang', 'id_pembelian', 'nama_barang', 'no_faktur', 'tanggal', 'jumlah', 'total'
    ];
}

