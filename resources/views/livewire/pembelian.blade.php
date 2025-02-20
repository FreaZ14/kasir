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
            <button wire:loading class="btn btn-info">
                <i class="fas fa-spinner fa-spin"></i> Loading...
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @if($pilihanPembelian=='detail')
                <div wire:poll>
                    <table class="table table-hover table-bordered text-center">
                        <thead class="table-secondary">
                            <tr>
                                <th>ID Pembelian</th>
                                <th>ID Barang</th>
                                <th>Nama Barang</th>
                                <th>No Faktur</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Total Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($detailPembelian as $detail)
                                <tr>
                                    <td>{{ $detail->id }}</td> 
                                    <td>{{ $detail->id_barang }}</td>
                                    <td>{{ $detail->barang->nama ?? '-' }}</td> 
                                    <td>{{ $detail->no_faktur }}</td>
                                    <td>{{ $detail->tanggal }}</td>
                                    <td>{{ $detail->jumlah }}</td>
                                    <td>{{ number_format($detail->total, 0, ',', '.') }}</td>
                                    <td>
                                        <button wire:click="editPembelian({{ $detail->id }})" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button wire:click="hapusPembelian({{ $detail->id }})" class="btn btn-danger btn-sm">
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
                </div>
            @endif
        </div>

        @if($pilihanPembelian=='tambah' || $pilihanPembelian=='edit')
            <div class="col-md-12">
                <h4 class="text-center mt-3">Form Pembelian</h4>
                <form wire:submit.prevent="{{ $pilihanPembelian == 'tambah' ? 'tambahPembelian' : 'updatePembelian' }}">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Nama Barang</th>
                                <td>
                                    <select wire:model="id_barang" class="form-select">
                                        <option value="">Pilih Barang</option>
                                        @foreach ($listBarang as $barang)
                                            <option value="{{ $barang->id }}">{{ $barang->nama }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>No Faktur</th>
                                <td>
                                    <input type="text" wire:model="no_faktur" class="form-control" readonly>
                                </td>
                            </tr>
                            <tr>
                                <th>Tanggal</th>
                                <td>
                                    <input type="date" wire:model="tanggal" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <th>Jumlah</th>
                                <td>
                                    <input type="number" wire:model="jumlah" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <th>Total Harga</th>
                                <td>
                                    <input type="text" wire:model="total" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <button type="submit" class="btn btn-primary w-100">
                                        {{ $pilihanPembelian == 'tambah' ? 'Beli' : 'Simpan' }}
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        @endif
    </div>
</div>
