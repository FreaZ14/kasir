<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Pembelian as PembelianModel;
use Illuminate\Support\Facades\Auth;

class Pembelian extends Component
{
    public $nama_barang, $jumlah, $total;
    public $detailPembelian = [];
    public $pilihanPembelian = 'tambah';
    public $no_faktur;
    public $tanggal;
    public $editId;

    public function mount()
    {
        $this->detailPembelian = $this->getDetailPembelian();
        $this->generateNoFaktur();
        $this->tanggal = now()->format('Y-m-d');
    }

    public function getDetailPembelian()
    {
        return PembelianModel::latest()->get();
    }

    public function generateNoFaktur()
    {
        $lastPembelian = PembelianModel::latest()->first();
        $lastNoFaktur = $lastPembelian ? $lastPembelian->no_faktur : 'PB000000';
        $this->no_faktur = 'PB' . sprintf('%06d', intval(substr($lastNoFaktur, 2)) + 1);
    }

    public function tambahPembelian()
    {
        $this->validate([
            'nama_barang' => 'required',
            'jumlah' => 'required|integer|min:1',
            'total' => 'required|numeric|min:1',
        ]);

        PembelianModel::create([
            'user_id' => Auth::id(),
            'nama_barang' => $this->nama_barang,
            'no_faktur' => $this->no_faktur,
            'tanggal' => $this->tanggal,
            'jumlah' => $this->jumlah,
            'total' => $this->total,
        ]);

        $this->reset(['nama_barang', 'jumlah', 'total']);
        $this->detailPembelian = $this->getDetailPembelian();
        session()->flash('message', 'Pembelian berhasil ditambahkan.');
    }

    public function editPembelian($id)
    {
        $pembelian = PembelianModel::find($id);
        if ($pembelian) {
            $this->editId = $id;
            $this->nama_barang = $pembelian->nama_barang;
            $this->jumlah = $pembelian->jumlah;
            $this->total = $pembelian->total;
            $this->pilihanPembelian = 'edit';
        }
    }

    public function updatePembelian()
    {
        $this->validate([
            'nama_barang' => 'required',
            'jumlah' => 'required|integer|min:1',
            'total' => 'required|numeric|min:1',
        ]);

        $pembelian = PembelianModel::find($this->editId);
        if ($pembelian) {
            $pembelian->update([
                'nama_barang' => $this->nama_barang,
                'jumlah' => $this->jumlah,
                'total' => $this->total,
            ]);

            $this->reset(['nama_barang', 'jumlah', 'total', 'editId']);
            $this->detailPembelian = $this->getDetailPembelian();
            $this->pilihanPembelian = 'tambah';
            session()->flash('message', 'Pembelian berhasil diperbarui.');
        }
    }

    public function hapusPembelian($id)
    {
        $pembelian = PembelianModel::find($id);
        if ($pembelian) {
            $pembelian->delete();
            $this->detailPembelian = $this->getDetailPembelian();
            session()->flash('message', 'Pembelian berhasil dihapus.');
        }
    }

    public function pilihPembelian($pilihan)
    {
        $this->pilihanPembelian = $pilihan;
    }

    public function render()
    {
        return view('livewire.pembelian');
    }
}

