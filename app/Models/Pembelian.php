<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelian'; // Nama tabel di database

    protected $fillable = [
        'user_id','nama_barang', 'no_faktur', 'tanggal', 'jumlah', 'total'
    ];
}
