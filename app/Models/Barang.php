<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang'; // Sesuaikan dengan nama tabel di database
    protected $fillable = ['nama', 'stok', 'harga_jual', 'satuan', 'keterangan', 'gambar'];
}
