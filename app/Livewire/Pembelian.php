<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pembelian as PembelianModel;
use App\Models\Barang as BarangModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Pembelian extends Component
{
    public $id_barang, $jumlah, $total;
    public $pilihanPembelian = 'tambah';
    public $no_faktur;
    public $tanggal;
    public $produkDitambahkan = [];
    public $dibayar = 0;
    public $kembalian = 0;

    public function mount()
    {
        $this->generateNoFaktur();
        $this->tanggal = now()->format('Y-m-d');
    }

    public function generateNoFaktur()
    {
        $lastPembelian = PembelianModel::latest()->first();
        $lastNoFaktur = $lastPembelian ? $lastPembelian->no_faktur : 'PB00';
        $this->no_faktur = 'PB' . sprintf('%06d', intval(substr($lastNoFaktur, 2)) + 1);
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

    public function prosesPembelian()
    {
        if (empty($this->produkDitambahkan)) {
            session()->flash('message', 'Tambahkan produk terlebih dahulu.');
            return;
        }

        DB::transaction(function () {
            foreach ($this->produkDitambahkan as $produk) {
                PembelianModel::create([
                    'user_id' => Auth::id(),
                    'id_barang' => $produk['id_barang'],
                    'no_faktur' => $this->no_faktur,
                    'tanggal' => $this->tanggal,
                    'jumlah' => $produk['jumlah'],
                    'total' => $produk['total'],
                ]);

                $barang = BarangModel::find($produk['id_barang']);
                $barang->stok += $produk['jumlah'];
                $barang->save();
            }
        });

        $this->reset(['produkDitambahkan']);
        $this->generateNoFaktur();
        session()->flash('message', 'Pembelian berhasil diproses.');
    }

    public function render()
    {
        $listBarang = BarangModel::all();
        return view('livewire.pembelian', [
            'listBarang' => $listBarang,
            'no_faktur' => $this->no_faktur,
            'tanggal' => $this->tanggal,
            'produkDitambahkan' => $this->produkDitambahkan,
            'barangList' => BarangModel::all(),
            'dibayar' => $this->dibayar,
        ]);
    }
        public function hapusProduk($index)
    {
        unset($this->produkDitambahkan[$index]);
        $this->produkDitambahkan = array_values($this->produkDitambahkan);
    }
    public function hitungTotal()
    {
        $this->total = collect($this->produkDitambahkan)->sum('total_harga');
    }

    public function hitungKembalian()
    {
        $this->kembalian = max(0, $this->dibayar - $this->total);
    }

    
}
