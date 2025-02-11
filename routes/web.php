<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Beranda;
use App\Livewire\User;
use App\Livewire\Laporan;
use App\Livewire\Barang;
use App\Livewire\Pembelian;
use App\Livewire\Penjualan;
use App\Livewire\DetailPenjualan;
use App\Livewire\DetailPembelian;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', Beranda::class)->middleware(['auth'])->name('home');
Route::get('/user', User::class)->middleware(['auth'])->name('user');
Route::get('/laporan', Laporan::class)->middleware(['auth'])->name('laporan');
Route::get('/barang', Barang::class)->middleware(['auth'])->name('barang');
Route::get('/pembelian', Pembelian::class)->middleware(['auth'])->name('pembelian');
Route::get('/penjualan', Penjualan::class)->middleware(['auth'])->name('penjualan');
Route::get('/detail-penjualan', DetailPenjualan::class)->middleware(['auth'])->name('detail-penjualan');
Route::get('/detail-pembelian', DetailPembelian::class)->middleware(['auth'])->name('detail-pembelian');
