<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_pembelian', function (Blueprint $table) {
            $table->id();
            $table->foreignid('id_pembelian')->constrained('pembelian')->onDelete('cascade');
            $table->foreignid('id_barang')->constrained('barang')->onDelete('cascade');
            $table->integer('qty');
            $table->integer('harga')->unsigned();
            $table->timestamps();
        });
    }
                        // <th>ID</th>
                        // <th>ID Pembelian</th>
                        // <th>Nama Barang</th>
                        // <th>Qty</th>
                        // <th>Total Harga</th>

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pembelian');
    }
};

