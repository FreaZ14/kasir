<div class="container">
    <div class="row my-3">
        <div class="col-12 d-flex gap-2">
            <button wire:click="pilihPembelian('tambah')" 
                class="btn {{ $pilihanPembelian=='tambah' ? 'btn-primary' : 'btn-outline-primary' }}">
                <i class="fas fa-plus"></i> Pembelian Baru
            </button>
            <button wire:click="pilihPembelian('detail')" 
                class="btn {{ $pilihanPembelian=='detail' ? 'btn-primary' : 'btn-outline-primary' }}">
                <i class="fas fa-boxes"></i> Detail Pembelian
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <h5><strong>Informasi Pembelian</strong></h5>
            <table class="table table-bordered">
                <tr><th>No Faktur</th><td>{{ $no_faktur }}</td></tr>
                <tr><th>Tanggal</th><td>{{ $tanggal }}</td></tr>
            </table>
        </div>
        <div class="col-md-6">
            <h5><strong>Daftar Produk</strong></h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listBarang as $barang)
                        <tr>
                            <td>{{ $barang->nama }}</td>
                            <td>Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5">
            <h5><strong>Tambah Produk</strong></h5>
            <div class="d-flex gap-2">
                <select wire:model="id_barang" class="form-select">
                    <option value="">-- Pilih Produk --</option>
                    @foreach ($listBarang as $barang)
                        <option value="{{ $barang->id }}">{{ $barang->nama }}</option>
                    @endforeach
                </select>
                <input type="number" wire:model="jumlah" class="form-control" placeholder="Qty">
                <button wire:click="tambahProduk" class="btn btn-success">+</button>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-5">
            <h5><strong>Produk yang Ditambahkan</strong></h5>
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produkDitambahkan as $produk)
                    @php
                        $barang = App\Models\Barang::find($produk['id']);
                    @endphp
                    <tr>
                        <td>{{ $produk['nama'] ?? 'Tanpa Nama' }}</td>
                        <td>{{ $produk['jumlah'] ?? 0 }}</td>
                        <td>Rp {{ number_format($barang->harga_jual * $produk['jumlah'], 0, ',', '.') }}</td>
                        <td>
                            <button wire:click="hapusProduk({{ $loop->index }})" class="btn btn-danger btn-sm">Hapus</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <button wire:click="hitungTotal" class="btn btn-primary">Lanjut</button>
    <div class="row mt-3">
        <div class="col-md-6">
            <h5><strong>Total Pembelian</strong></h5>
            <table class="table table-bordered">
                <tr>
                    <td>Total</td>
                    <td><input type="text" wire:model="total" class="form-control" readonly></td>
                </tr>
                <tr>
                    <td>Dibayar</td>
                    <td><input type="number" wire:model="dibayar" wire:keyup="hitungKembalian" class="form-control"></td>
                </tr>
                <tr>
                    <td>Kembalian</td>
                    <td><input type="text" wire:model="kembalian" class="form-control" readonly></td>
                </tr>
            </table>
            <button wire:click="prosesPembelian" class="btn btn-primary w-100">Proses</button>
        </div>
    </div>
</div>

