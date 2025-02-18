<?php

namespace App\Livewire;

use App\Models\Barang;
use App\Models\Penjualan as PenjualanModel;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Penjualan extends Component
{
    public $pilihanPenjualan;
    public $no_faktur;
    public $tanggal;
    public $penjualan = [];
    public $searchBarang;
    public $listBarang = [];
    public $barang_id;
    public $jumlah;
    public $total;
    public $id_penjualan;

    protected $rules = [
        'id_penjualan' => 'required',
        'barang_id' => 'required',
        'no_faktur' => 'required',
        'tanggal' => 'required',
        'jumlah' => 'required|numeric',
        'total' => 'required|numeric',
    ];

    public function mount()
    {
        $this->pilihanPenjualan = 'form';
        $this->tanggal = (new \DateTime())->format('Y-m-d');
        $this->generateNoFaktur();
    }

    public function render()
    {
        return view('livewire.penjualan', [
            'pilihanPenjualan' => $this->pilihanPenjualan,
            'no_faktur' => $this->no_faktur,
            'tanggal' => $this->tanggal,
            'penjualan' => $this->penjualan,
            'searchBarang' => $this->searchBarang,
            'listBarang' => $this->listBarang,
        ]);
    }

    public function pilihPenjualan($pilihan)
    {
        $this->pilihanPenjualan = $pilihan;
    }

    public function pilihBarang($id)
    {
        $barang = Barang::findOrFail($id);
        $this->barang_id = $barang->id;
        $this->jumlah = 1;
    }

    private function generateNoFaktur()
    {
        $now = new \DateTime();
        $this->no_faktur = 'F' . $now->format('ymd') . '-' . str_pad($now->format('His'), 6, '0', STR_PAD_LEFT);
    }

    public function updatedSearchBarang()
    {
        $this->listBarang = Barang::where('nama_barang', 'LIKE', '%' . $this->searchBarang . '%')->get();
    }

    public function tambahPenjualan()
    {
        $this->validate();
    
        DB::beginTransaction();
        try {
            $penjualan = new PenjualanModel();
            $penjualan->id_penjualan = $this->id_penjualan;
            $penjualan->barang_id = $this->barang_id;
            $penjualan->no_faktur = $this->no_faktur; 
            $penjualan->tanggal = $this->tanggal;
            $penjualan->jumlah = $this->jumlah;
            $penjualan->total = $this->total;
            $penjualan->save();
    
            DB::commit();
            session()->flash('success', 'Penjualan berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function simpan()
    {
        $this->validate();
    
        DB::beginTransaction();
        try {
            $penjualan = new PenjualanModel();
            $penjualan->id_penjualan = $this->id_penjualan;
            $penjualan->barang_id = $this->barang_id;
            $penjualan->no_faktur = $this->no_faktur; 
            $penjualan->tanggal = $this->tanggal;
            $penjualan->jumlah = $this->jumlah;
            $penjualan->total = $this->total;
            $penjualan->save();
    
            DB::commit();
            session()->flash('success', 'Penjualan berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

