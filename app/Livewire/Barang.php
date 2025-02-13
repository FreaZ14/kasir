<?php 
namespace App\Livewire;

use Livewire\Component;
use App\Models\Barang as BarangModel;

class Barang extends Component
{
    public $pilihanBarang = 'lihat';
    public $barang;
    public $nama;
    public $stok;
    public $harga_jual;
    public $satuan;
    public $keterangan;
    public $gambar;
    public $barangId;

    public function mount()
    {
        $this->barang = BarangModel::all();
    }

    public function pilihBarang($pilih, $id = null)
    {
        $this->pilihanBarang = $pilih;

        if ($pilih == 'edit' && $id) {
            $barang = BarangModel::find($id);
            if ($barang) {
                $this->barangId = $barang->id;
                $this->nama = $barang->nama;
                $this->stok = $barang->stok;
                $this->harga_jual = $barang->harga_jual;
                $this->satuan = $barang->satuan;
                $this->keterangan = $barang->keterangan;
                $this->gambar = $barang->gambar;
            }
        } elseif ($pilih == 'tambah') {
            $this->resetInputFields();
        }
    }

    public function tambahBarang()
    {
        BarangModel::create([
            'nama' => $this->nama,
            'stok' => $this->stok,
            'harga_jual' => $this->harga_jual,
            'satuan' => $this->satuan,
            'keterangan' => $this->keterangan,
            'gambar' => $this->gambar,
        ]);

        session()->flash('message', 'Barang berhasil ditambahkan!');
        $this->resetInputFields();
        $this->barang = BarangModel::all();
        $this->pilihanBarang = 'lihat';
    }

    public function editBarang()
    {
        $barang = BarangModel::find($this->barangId);
        if ($barang) {
            $barang->update([
                'nama' => $this->nama,
                'stok' => $this->stok,
                'harga_jual' => $this->harga_jual,
                'satuan' => $this->satuan,
                'keterangan' => $this->keterangan,
                'gambar' => $this->gambar,
            ]);

            session()->flash('message', 'Barang berhasil diperbarui!');
            $this->resetInputFields();
            $this->barang = BarangModel::all();
            $this->pilihanBarang = 'lihat';
        }
    }

    public function hapusBarang($id)
    {
        $barang = BarangModel::find($id);
        if ($barang) {
            $barang->delete();
            session()->flash('message', 'Barang berhasil dihapus!');
            $this->barang = BarangModel::all();
        }
    }

    public function resetInputFields()
    {
        $this->nama = '';
        $this->stok = '';
        $this->harga_jual = '';
        $this->satuan = '';
        $this->keterangan = '';
        $this->gambar = '';
        $this->barangId = null;
    }

    public function render()
    {
        return view('livewire.barang');
    }
}
