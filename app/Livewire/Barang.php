<?php

namespace App\Livewire;

use Livewire\Component;

class Barang extends Component
{

    public $pilihanBarang = 'lihat';
    public function render()
    {
        return view('livewire.barang');
    }

    public function pilihBarang($barang)
    {
        $this->pilihanBarang = $barang;
    }

}
