<div>
    <div class="row">
        <div class="col-md-12">
            <div class="row mb-3">
                <div class="col-md-3 offset-md-2 d-flex gap-3">
                    <button wire:click="pilihPenjualan('form')" 
                        class="btn {{ $pilihanPenjualan=='form' ? 'btn-primary' : 'btn-outline-primary' }} w-10 mt-4">
                        <i class="fas fa-plus"></i> Form Penjualan
                    </button>
                    <button wire:click="pilihPenjualan('detail')" 
                        class="btn {{ $pilihanPenjualan=='detail' ? 'btn-primary' : 'btn-outline-primary' }} w-10 mt-4">
                        <i class="fas fa-boxes"></i> Detail Penjualan
                    </button>
                </div>
            </div>
            @if($pilihanPenjualan == 'form')
                <h3 class="text-center">Form Penjualan</h3>
                <div style="overflow-x: auto;">
                    <table class="table table-striped table-hover table-bordered" style="background-color: #f7f7f7; width: 70%; margin: 0 auto;">
                        <tbody>
                            <tr>
                                <td style="width: 150px;">
                                    <label for="no_faktur" class="form-label">No Faktur</label>
                                </td>
                                <td>
                                    <input type="text" wire:model="no_faktur" class="form-control" id="no_faktur">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="nama_barang" class="form-label">Nama Barang</label>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <select wire:model="nama_barang" class="form-select" id="nama_barang">
                                            <option value="">Pilih Barang</option>
                                            @foreach ($barang ?? [] as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#barangModal">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                </td>
                                <td>
                                    <input type="date" wire:model="tanggal" class="form-control" id="tanggal">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="jumlah" class="form-label">Jumlah</label>
                                </td>
                                <td>
                                    <input type="number" wire:model="jumlah" class="form-control" id="jumlah">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="total" class="form-label">Total</label>
                                </td>
                                <td>
                                    <input type="text" wire:model="total" class="form-control" id="total">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <button type="submit" class="btn btn-primary w-100">Beli</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <form wire:submit.prevent="tambahPenjualan"></form>
            @endif
            @if($pilihanPenjualan == 'detail')
                <h3 class="text-center">Detail Penjualan</h3>
                <table class="table table-striped table-bordered table-hover" style="background-color: #f0f0f0; width: 80%; margin: 0 auto;">
                    <thead>
                        <tr>
                            <th class="text-center">Barang</th>
                            <th class="text-center">Qty</th>
                            <th class="text-center">Harga</th>
                            <th class="text-center">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penjualan ?? [] as $item)
                            <tr>
                                <td class="text-center">{{ $item->barang }}</td>
                                <td class="text-center">{{ $item->qty }}</td>
                                <td class="text-center">{{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td class="text-center">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada penjualan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <div class="modal fade" id="barangModal" tabindex="-1" aria-labelledby="barangModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="barangModalLabel">Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-bordered table-hover" style="background-color: #f7f7f7;">
                        <thead>
                            <tr>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Stok</th>
                                <th class="text-center">Harga Jual</th>
                                <th class="text-center">Satuan</th>
                                <th class="text-center">Keterangan</th>
                                <th class="text-center">Gambar</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barang ?? [] as $item)
                                <tr>
                                    <td class="text-center">{{ $item->nama }}</td>
                                    <td class="text-center">{{ $item->stok }}</td>
                                    <td class="text-center">{{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                                    <td class="text-center">{{ $item->satuan }}</td>
                                    <td class="text-center">{{ $item->keterangan }}</td>
                                    <td class="text-center">
                                        @if($item->gambar)
                                            <img src="{{ asset('storage/' . $item->gambar) }}" class="rounded" width="100">
                                        @else
                                            <span class="text-muted">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button wire:click="pilihBarang({{ $item->id }})" class="btn btn-primary">Pilih</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

