<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Penjualan as PenjualanModel;
use App\Models\Barang as BarangModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Penjualan extends Component
{
    public $id_penjualan, $id_barang, $jumlah, $total;
    public $detailPenjualan = [];
    public $pilihanPenjualan = 'tambah';
    public $no_faktur;
    public $tanggal;
    public $editId;

    public function mount()
    {
        $this->detailPenjualan = $this->getDetailPenjualan();
        $this->generateNoFaktur();
        $this->tanggal = now()->format('Y-m-d');
    }

    public function getDetailPenjualan()
    {
        return PenjualanModel::with('barang')->latest()->get();
    }

    public function generateNoFaktur()
    {
        $lastPenjualan = PenjualanModel::latest()->first();
        $lastNoFaktur = $lastPenjualan ? $lastPenjualan->no_faktur : 'PJ00';
        $this->no_faktur = 'PJ' . sprintf('%06d', intval(substr($lastNoFaktur, 2)) + 1);
    }

    public function tambahPenjualan()
    {
        $this->validate([
            'id_barang' => 'required',
            'no_faktur' => 'required',
            'tanggal' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'total' => 'required|numeric|min:0',
        ]);
        
        DB::transaction(function () {
            $penjualan = PenjualanModel::create([
                'user_id' => Auth::id(),
                'id_barang' => $this->id_barang,
                'no_faktur' => $this->no_faktur,
                'tanggal' => $this->tanggal,
                'jumlah' => $this->jumlah,
                'total' => $this->total,
            ]);

            $barang = BarangModel::find($this->id_barang);
            $barang->stok -= $this->jumlah;
            $barang->save();
        });

        $this->reset(['id_barang', 'jumlah', 'total', 'editId']);
        $this->pilihanPenjualan = 'tambah';
        session()->flash('message', 'Penjualan berhasil ditambahkan.');
        $this->detailPenjualan = $this->getDetailPenjualan();
    }

    public function editPenjualan($id)
    {
        $penjualan = PenjualanModel::find($id);
        if ($penjualan) {
            $this->editId = $id;
            $this->id_barang = $penjualan->id_barang;
            $this->jumlah = $penjualan->jumlah;
            $this->total = $penjualan->total;
            $this->pilihanPenjualan = 'edit';
        }
    }

    public function updatePenjualan()
    {
        $this->validate([
            'id_barang' => 'required|exists:barang,id',
            'jumlah' => 'required|integer|min:1',
            'total' => 'required|numeric|min:1',
        ]);

        $penjualan = PenjualanModel::find($this->editId);
        if ($penjualan) {
            $penjualan->update([
                'id_barang' => $this->id_barang,
                'jumlah' => $this->jumlah,
                'total' => $this->total,
            ]);

            $barang = BarangModel::find($this->id_barang);
            $barang->stok -= $penjualan->jumlah - $this->jumlah;
            $barang->save();

            $this->reset(['id_barang', 'jumlah', 'total', 'editId']);
            $this->detailPenjualan = $this->getDetailPenjualan();
            $this->pilihanPenjualan = 'tambah';
            session()->flash('message', 'Penjualan berhasil diperbarui.');
        }
    }

    public function hapusPenjualan($id)
    {
        $penjualan = PenjualanModel::find($id);
        if ($penjualan) {
            $penjualan->delete();
            $this->detailPenjualan = $this->getDetailPenjualan();
            session()->flash('message', 'Penjualan berhasil dihapus.');
        }
    }

    public function pilihPenjualan($pilihan)
    {
        $this->pilihanPenjualan = $pilihan;
    }

    public function render()
    {
        $listBarang = BarangModel::all();
        return view('livewire.penjualan', [
            'listBarang' => $listBarang,
            'no_faktur' => $this->no_faktur,
            'tanggal' => $this->tanggal,
            'pilihanPenjualan' => $this->pilihanPenjualan,
            'detailPenjualan' => $this->detailPenjualan,
        ]);
    }
}

