<div>
    <div class="container">
        <div class="row my-3">
            <div class="col-12 d-flex gap-2">
                <button wire:click="pilihPembelian('lihat')" 
                    class="btn {{ $pilihanPembelian=='lihat' ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="fas fa-boxes"></i> Riwayat Pembelian
                </button>
                <button wire:click="pilihPembelian('detail')" 
                    class="btn {{ $pilihanPembelian=='detail' ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="fas fa-boxes"></i> Detail Pembelian
                </button>
                <button wire:click="pilihPembelian('tambah')" 
                    class="btn {{ $pilihanPembelian=='tambah' ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="fas fa-plus"></i> Tambah Pembelian
                </button>
                <button wire:loading class="btn btn-info">
                    <i class="fas fa-spinner fa-spin"></i> Loading...
                </button>
            </div>
        </div>

        @if($pilihanPembelian=='lihat')
            <div class="row">
                <div class="col-12">
                    <table class="table table-hover table-bordered text-center align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>No Faktur</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pembelian as $item)
                                @if($item !== null)
                                    <tr>
                                        <td>{{ $item->no_faktur }}</td>
                                        <td>{{ $item->tanggal }}</td>
                                        <td>{{ $item->jumlah }}</td>
                                        <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                                        <td>
                                            <button wire:click="pilihPembelian('detail', {{ $item->id }})" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> Detail
                                            </button>
                                            <button wire:click="hapusPembelian({{ $item->id }})" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        @elseif($pilihanPembelian=='detail')
            <div class="row">
                <div class="col-12">
                    <table class="table table-hover table-bordered text-center align-middle">
                        <thead class="table-secondary">
                            <tr>
                                <th>Barang</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($detailPembelian))
                                @foreach ($detailPembelian as $detail)
                                    <tr>
                                        <td>{{ $detail['nama'] }}</td>
                                        <td>{{ $detail['qty'] }}</td>
                                        <td>{{ $detail['harga'] }}</td>
                                        <td>{{ $detail['subtotal'] }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4">Belum ada barang ditambahkan.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        @elseif($pilihanPembelian=='tambah')
            <div class="row">
                <div class="col-12">
                    <form wire:submit.prevent="tambahPembelian">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="no_faktur" class="form-label">No Faktur</label>
                                    <input type="text" wire:model="no_faktur" class="form-control" id="no_faktur" placeholder="No Faktur">
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input type="date" wire:model="tanggal" class="form-control" id="tanggal" placeholder="Tanggal">
                                </div>
                                <div class="mb-3">
                                    <label for="nama_barang" class="form-label">Nama Barang</label>
                                    <input type="text" wire:model="nama_barang" class="form-control" id="nama_barang" placeholder="Nama Barang">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jumlah" class="form-label">Jumlah</label>
                                    <input type="number" wire:model="jumlah" class="form-control" id="jumlah" placeholder="Jumlah">
                                </div>
                                <div class="mb-3">
                                    <label for="total" class="form-label">Total</label>
                                    <input type="text" wire:model="total" class="form-control" id="total" placeholder="Total">
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('pembelian.simpan') }}" method="POST">
                         @csrf
                        <button type="submit">Simpan</button>
                        </form>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>

