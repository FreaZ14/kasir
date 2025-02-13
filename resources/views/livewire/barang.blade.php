<div>
    <div class="container">
        <div class="row my-3">
            <div class="col-12 d-flex gap-2">
                <button wire:click="pilihBarang('lihat')" 
                    class="btn {{ $pilihanBarang=='lihat' ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="fas fa-boxes"></i> Semua Barang
                </button>
                <button wire:click="pilihBarang('tambah')" 
                    class="btn {{ $pilihanBarang=='tambah' ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="fas fa-plus"></i> Tambah Barang
                </button>
                <button wire:loading class="btn btn-info">
                    <i class="fas fa-spinner fa-spin"></i> Loading...
                </button>
            </div>
        </div>

        @if($pilihanBarang=='lihat')
            <div class="row">
                <div class="col-12">
                    <table class="table table-hover table-bordered text-center align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>Nama</th>
                                <th>Stok</th>
                                <th>Harga Jual</th>
                                <th>Satuan</th>
                                <th>Keterangan</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barang as $item)
                                @if($item !== null)
                                    <tr>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->stok }}</td>
                                        <td>Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                                        <td>{{ $item->satuan }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                        <td>
                                            @if($item->gambar)
                                                <img src="{{ asset('storage/' . $item->gambar) }}" class="rounded" width="100">
                                            @else
                                                <span class="text-muted">Tidak ada</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button wire:click="pilihBarang('edit', {{ $item->id }})" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button wire:click="hapusBarang({{ $item->id }})" class="btn btn-danger btn-sm">
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

        @elseif($pilihanBarang=='tambah' || $pilihanBarang=='edit')
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <h4 class="card-title mb-3">
                                {{ $pilihanBarang == 'tambah' ? 'Tambah Barang' : 'Edit Barang' }}
                            </h4>
                            <form wire:submit.prevent="{{ $pilihanBarang == 'tambah' ? 'tambahBarang' : 'editBarang' }}">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" wire:model="nama" class="form-control" id="nama" placeholder="Nama Barang">
                                </div>
                                <div class="mb-3">
                                    <label for="stok" class="form-label">Stok</label>
                                    <input type="number" wire:model="stok" class="form-control" id="stok" placeholder="Jumlah Stok">
                                </div>
                                <div class="mb-3">
                                    <label for="harga_jual" class="form-label">Harga Jual</label>
                                    <input type="number" wire:model="harga_jual" class="form-control" id="harga_jual" placeholder="Harga Jual">
                                </div>
                                <div class="mb-3">
                                    <label for="satuan" class="form-label">Satuan</label>
                                    <input type="text" wire:model="satuan" class="form-control" id="satuan" placeholder="Satuan (pcs, kg, dll)">
                                </div>
                                <div class="mb-3">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <textarea wire:model="keterangan" class="form-control" id="keterangan" placeholder="Keterangan"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="gambar" class="form-label">Gambar</label>
                                    <input type="file" wire:model="gambar" class="form-control" id="gambar">
                                    <div wire:loading wire:target="gambar">Uploading...</div>

                                    @if($gambar)
                                        <img src="{{ $gambar->temporaryUrl() }}" class="img-thumbnail mt-2" width="150">
                                    @elseif($pilihanBarang == 'edit' && $gambarLama)
                                        <img src="{{ asset('storage/' . $gambarLama) }}" class="img-thumbnail mt-2" width="150">
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
