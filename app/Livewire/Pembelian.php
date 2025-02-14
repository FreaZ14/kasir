<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pembelian as PembelianModel;
use App\Models\DetailPembelian as DetailPembelianModel;
use App\Models\Barang as BarangModel;

class Pembelian extends Component
{
    public $pembelian;
    public $pilihanPembelian = 'lihat';
    public $detailPembelian;
    public $barang;
    public $selectedBarang;
    public $qty;
    public $total;
    public $no_faktur;
    public $tanggal;

    public function mount()
    {
        $this->pembelian = PembelianModel::all();
        $this->barang = BarangModel::all();
        $this->no_faktur = 'INV' . now()->format('YmdHis');
        $this->tanggal = now()->toDateString();

    }

    public function pilihPembelian($pilih, $id = null)
    {
        $this->pilihanPembelian = $pilih;

        if ($pilih == 'detail' && $id) {
            $this->detailPembelian = DetailPembelianModel::where('pembelian_id', $id)->get();
        } elseif ($pilih == 'tambah') {
            // Reset fields for adding new entry
            $this->selectedBarang = null;
            $this->qty = null;
            $this->total = null;
        }
    }

    public function tambahPembelian()
    {
        $this->validate([
            'no_faktur' => 'required|unique:pembelian,no_faktur',
            'tanggal' => 'required|date',
            'selectedBarang' => 'required|exists:barang,id',
            'qty' => 'required|numeric|min:1',
            'total' => 'required|numeric|min:1',
        ]);

        $pembelian = new PembelianModel();
        $pembelian->user_id = auth()->user()->id;
        $pembelian->no_faktur = $this->no_faktur;
        $pembelian->tanggal = $this->tanggal;
        $pembelian->save();

        $detailPembelian = new DetailPembelianModel();
        $detailPembelian->pembelian_id = $pembelian->id;
        $detailPembelian->barang_id = $this->selectedBarang;
        $detailPembelian->qty = $this->qty;
        $detailPembelian->total = $this->total;
        $detailPembelian->save();

        $barang = BarangModel::find($this->selectedBarang);
        $barang->stok += $this->qty;
        $barang->save();

        session()->flash('message', 'Pembelian berhasil ditambahkan!');
        $this->pembelian = PembelianModel::all();
        $this->pilihanPembelian = 'lihat';
    }

    public function hapusPembelian($id)
    {
        $pembelian = PembelianModel::find($id);
        if ($pembelian) {
            $pembelian->delete();
            session()->flash('message', 'Pembelian berhasil dihapus!');
            $this->pembelian = PembelianModel::all();
        }
    }
    public function render()
    {
        return view('livewire.pembelian', [
            'pembelian' => $this->pembelian, 'barang' => $this->barang, 'detailPembelian' => $this->detailPembelian]);
    }
}

