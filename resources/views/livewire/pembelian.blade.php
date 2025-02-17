<div class="container">
    <div class="row my-3">
        <div class="col-12 d-flex gap-2">
            <button wire:click="pilihPembelian('tambah')" 
                class="btn {{ $pilihanPembelian=='tambah' ? 'btn-primary' : 'btn-outline-primary' }}">
                <i class="fas fa-plus"></i> Tambah Pembelian Baru
            </button>
            <button wire:click="pilihPembelian('detail')" 
                class="btn {{ $pilihanPembelian=='detail' ? 'btn-primary' : 'btn-outline-primary' }}">
                <i class="fas fa-boxes"></i> Detail Pembelian
            </button>
        </div>
    </div>

    @if($pilihanPembelian=='tambah')
        <form wire:submit.prevent="tambahPembelian">
            <div class="row">
                <div class="col-md-9">
                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" wire:model="nama_barang" class="form-control" id="nama_barang">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="no_faktur" class="form-label">No Faktur</label>
                        <input type="text" wire:model="no_faktur" class="form-control" id="no_faktur">
                    </div>
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" wire:model="tanggal" class="form-control" id="tanggal">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" wire:model="jumlah" class="form-control" id="jumlah">
                    </div>
                    <div class="mb-3">
                        <label for="total" class="form-label">Total</label>
                        <input type="text" wire:model="total" class="form-control" id="total">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Beli</button>
        </form>
    @elseif($pilihanPembelian=='edit')
    <h1 class="text-center display-1">Edit Pembelian</h1>
        <form wire:submit.prevent="updatePembelian">
            <div class="row">
                <div class="col-md-9">
                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" wire:model="nama_barang" class="form-control" id="nama_barang">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="no_faktur" class="form-label">No Faktur</label>
                        <input type="text" wire:model="no_faktur" class="form-control" id="no_faktur">
                    </div>
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" wire:model="tanggal" class="form-control" id="tanggal">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" wire:model="jumlah" class="form-control" id="jumlah">
                    </div>
                    <div class="mb-3">
                        <label for="total" class="form-label">Total</label>
                        <input type="text" wire:model="total" class="form-control" id="total">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Simpan</button>
        </form>
    @else
        <table class="table table-hover table-bordered text-center">
            <thead class="table-secondary">
                <tr>
                    <th>Nama Barang</th>
                    <th>No Faktur</th>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($detailPembelian as $detail)
                    <tr>
                        <td>{{ $detail->nama_barang }}</td>
                        <td>{{ $detail->no_faktur }}</td>
                        <td>{{ $detail->tanggal }}</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td>{{ number_format($detail->total, 0, ',', '.') }}</td>
                        <td>
                            <button wire:click="editPembelian({{ $detail->id }})" 
                                class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button wire:click="hapusPembelian({{ $detail->id }})" 
                                class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Belum ada pembelian.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endif
</div>

