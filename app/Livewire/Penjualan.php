<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Penjualan as PenjualanModel;
use App\Models\Barang as BarangModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Penjualan extends Component
{
    public $id_barang, $jumlah, $total;
    public $pilihanPenjualan = 'tambah';
    public $no_faktur;
    public $tanggal;
    public $produkDitambahkan = [];

    public function mount()
    {
        $this->generateNoFaktur();
        $this->tanggal = now()->format('Y-m-d');
    }

    public function generateNoFaktur()
    {
        $lastPenjualan = PenjualanModel::latest()->first();
        $lastNoFaktur = $lastPenjualan ? $lastPenjualan->no_faktur : 'PJ00';
        $this->no_faktur = 'PJ' . sprintf('%06d', intval(substr($lastNoFaktur, 2)) + 1);
    }

    public function tambahProduk()
    {
        $this->validate([
            'id_barang' => 'required|exists:barang,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $barang = BarangModel::find($this->id_barang);
        if (!$barang) return;    
        
        $harga = (int) $barang->harga;
        $total = $harga * (int) $this->jumlah;

        $this->produkDitambahkan[] = [
            'id' => $barang->id,
            'nama' => $barang->nama,
            'jumlah' => $this->jumlah,
            'harga' => $barang->harga,
            'total_harga' => $barang->harga * $this->jumlah, 
        ];

        $this->reset(['id_barang', 'jumlah']);
    }

    public function prosesPenjualan()
    {
        if (empty($this->produkDitambahkan)) {
            session()->flash('message', 'Tambahkan produk terlebih dahulu.');
            return;
        }

        DB::transaction(function () {
            foreach ($this->produkDitambahkan as $produk) {
                PenjualanModel::create([
                    'user_id' => Auth::id(),
                    'id_barang' => $produk['id_barang'],
                    'no_faktur' => $this->no_faktur,
                    'tanggal' => $this->tanggal,
                    'jumlah' => $produk['jumlah'],
                    'total' => $produk['total'],
                ]);

                $barang = BarangModel::find($produk['id_barang']);
                $barang->stok -= $produk['jumlah'];
                $barang->save();
            }
        });

        $this->reset(['produkDitambahkan']);
        $this->generateNoFaktur();
        session()->flash('message', 'Penjualan berhasil diproses.');
    }

    public function render()
    {
        $listBarang = BarangModel::all();
        return view('livewire.penjualan', [
            'listBarang' => $listBarang,
            'no_faktur' => $this->no_faktur,
            'tanggal' => $this->tanggal,
            'produkDitambahkan' => $this->produkDitambahkan,
        ]);
    }
        public function hapusProduk($index)
    {
        unset($this->produkDitambahkan[$index]);
        $this->produkDitambahkan = array_values($this->produkDitambahkan);
    }

}

