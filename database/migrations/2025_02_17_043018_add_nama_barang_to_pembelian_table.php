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
        if (Schema::hasTable('pembelian')) {
            Schema::table('pembelian', function (Blueprint $table) {
                $table->string('nama_barang')->after('id_barang')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('pembelian')) {
            Schema::table('pembelian', function (Blueprint $table) {
                $table->dropColumn('nama_barang');
            });
        }
    }
};

