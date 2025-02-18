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
            <button wire:loading class="btn btn-info">
                <i class="fas fa-spinner fa-spin"></i> Loading...
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @if($pilihanPembelian=='detail')
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-secondary">
                        <tr>
                            <th>ID Pembelian</th>
                            <th>ID Barang</th>
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
                                <td>{{ $detail->id_pembelian }}</td>
                                <td>{{ $detail->id_barang }}</td>
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
                                <td colspan="8">Belum ada pembelian.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @endif
        </div>
        @if($pilihanPembelian=='tambah' || $pilihanPembelian=='edit')
            <div class="col-md-6 offset-md-3">
                <h4 class="text-center mt-3">Form Pembelian</h4>
                <form wire:submit.prevent="{{ $pilihanPembelian == 'tambah' ? 'tambahPembelian' : 'updatePembelian' }}">
                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" wire:model="nama_barang" class="form-control" id="nama_barang">
                    </div>
                    <div class="mb-3">
                        <label for="id_pembelian" class="form-label">ID Pembelian</label>
                        <input type="number" wire:model="id_pembelian" class="form-control" id="id_pembelian">
                    </div>
                    <div class="mb-3">
                        <label for="id_barang" class="form-label">ID Barang</label>
                        <input type="number" wire:model="id_barang" class="form-control" id="id_barang">
                    </div>
                    <div class="mb-3">
                        <label for="no_faktur" class="form-label">No Faktur</label>
                        <input type="text" wire:model="no_faktur" class="form-control" id="no_faktur">
                    </div>
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" wire:model="tanggal" class="form-control" id="tanggal">
                    </div>
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" wire:model="jumlah" class="form-control" id="jumlah">
                    </div>
                    <div class="mb-3">
                        <label for="total" class="form-label">Total</label>
                        <input type="text" wire:model="total" class="form-control" id="total">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        {{ $pilihanPembelian == 'tambah' ? 'Beli' : 'Simpan' }}
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>

