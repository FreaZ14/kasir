<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pembelian as PembelianModel;
use App\Models\Barang as BarangModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\DetailPembelian as DetailPembelianModel;

class Pembelian extends Component
{
    public $id_barang, $jumlah;
    public $pilihanPembelian = 'tambah';
    public $no_faktur;
    public $tanggal;
    public $produkDitambahkan = [];
    public $dibayar = 0;
    public $kembalian = 0;
    public $total = 0;
    public $detailPembelian = [];
    public $id_pembelian;
    public $harga = 0;


    public function mount()
    {
        $this->generateNoFaktur();
        $this->tanggal = now()->format('Y-m-d');
    }

    public function generateNoFaktur()
    {
        $lastPembelian = PembelianModel::orderByDesc('no_faktur')->first();
        $lastNoFaktur = $lastPembelian ? $lastPembelian->no_faktur : 'PB000000';
        
        $newNoFaktur = 'PB' . sprintf('%06d', intval(substr($lastNoFaktur, 2)) + 1);
        
        while (PembelianModel::where('no_faktur', $newNoFaktur)->exists()) {
            $newNoFaktur = 'PB' . sprintf('%06d', intval(substr($newNoFaktur, 2)) + 1);
        }
        
        $this->no_faktur = $newNoFaktur;
    }

    public function getUniqueNoFakturAttribute()
    {
        return $this->no_faktur . '-' . str_pad(count($this->produkDitambahkan) + 1, 3, '0', STR_PAD_LEFT);
    }
    
    public function pilihPembelian($jenis)
    {
        $this->pilihanPembelian = $jenis;
        
    }

    public function tambahProduk()
    {
        $this->validate([
            'id_barang' => 'required|exists:barang,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $barang = BarangModel::find($this->id_barang);
        if (!$barang) return;    

        $total_harga = $barang->harga_jual * $this->jumlah;

        $this->produkDitambahkan[] = [
            'id' => $barang->id,
            'nama' => $barang->nama,
            'jumlah' => $this->jumlah,
            'harga' => $barang->harga_jual,
            'total_harga' => $total_harga,
        ];
        $this->hitungTotal();
        $this->reset(['id_barang', 'jumlah']);
    }

    public function prosesPembelian()
{
    if (empty($this->produkDitambahkan)) {
        session()->flash('message', 'Tambahkan produk terlebih dahulu.');
        return;
    }

    DB::transaction(function () {
        $pembelian = PembelianModel::create([
            'user_id' => Auth::id(),
            'no_faktur' => $this->no_faktur,
            'tanggal' => $this->tanggal,
            'jumlah' => count($this->produkDitambahkan),
            'total' => $this->totalPembelian(), 
        ]);

        $this->id_pembelian = $pembelian->id;

        foreach ($this->produkDitambahkan as $produk) {
            DetailPembelianModel::create([
            'id_pembelian' => $this->id_pembelian, 
            'id_barang' => $produk['id'],
            'qty' => $produk['jumlah'], 
            'harga' => $produk['harga'], 
            'created_at' => now(),
            'updated_at' => now(),
]);


            $barang = BarangModel::find($produk['id']);
            if ($barang) {
                $barang->stok += $produk['jumlah'];
                $barang->save();
            }
        }
    });

    $this->reset(['produkDitambahkan', 'total', 'dibayar', 'kembalian', 'id_pembelian']);
    session()->flash('message', 'Pembelian berhasil diproses.');
    return redirect()->to('/pembelian');
}

    
    public function hapusProduk($index)
    {
        unset($this->produkDitambahkan[$index]);
        $this->produkDitambahkan = array_values($this->produkDitambahkan);
        $this->hitungTotal();
    }

    public function hitungTotal()
    {
        $this->total = collect($this->produkDitambahkan)->sum('total_harga');
    }

    public function hitungKembalian()
    {
        $this->kembalian = max(0, (int)$this->dibayar - (int)$this->total);
    }

    public function totalPembelian()
    {
        return collect($this->produkDitambahkan)->sum('total_harga');
    }

    public function lihatDetail($noFaktur)
    {
        $this->no_faktur = $noFaktur;
        $this->pilihanPembelian = 'detail';
        $this->detailPembelian = $this->getDetailPembelian();
    }

    public function getDetailPembelian()
    {
        if (!$this->no_faktur) return [];

        return PembelianModel::where('no_faktur', $this->no_faktur)
            ->with('barang')
            ->get();
    }
    public function hapusDetailPembelian()
    {
        $this->detailPembelian = [];
        $barang->stok -= $produk['jumlah'];
    }

    public function render()
    {
        return view('livewire.pembelian', [
            'listBarang' => BarangModel::all(),
            'listFaktur' => PembelianModel::select('no_faktur', 'tanggal')->distinct()->get(),
            'detailPembelian' => $this->detailPembelian,
        ]);
    }
}



