<?php

namespace App\Livewire;

use App\Models\Barang;
use Livewire\Component;

class Penjualan extends Component
{
    public $pilihanPenjualan;
    public $no_faktur;
    public $tanggal;
    public $penjualan;
    public $searchBarang;
    public $listBarang = [];

    public function mount()
    {
        $this->pilihanPenjualan = 'form';
        $this->tanggal = (new \DateTime())->format('Y-m-d');
        $this->generateNoFaktur();
        $this->penjualan = []; // Initialize with an empty array or fetch data from a model
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

    private function generateNoFaktur()
    {
        $now = new \DateTime();
        $this->no_faktur = 'F' . $now->format('ymd') . '-' . str_pad($now->format('His'), 6, '0', STR_PAD_LEFT);
    }

    public function updatedSearchBarang()
    {
        $this->listBarang = Barang::where('nama_barang', 'LIKE', '%' . $this->searchBarang . '%')->get();
    }
}

