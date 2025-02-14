<div>
    <div class="container">
        <div class="row my-2">
            <div class="col-12">
                <button wire:click="pilihMenu('lihat')" 
                    class="btn {{ $pilihanMenu=='lihat' ? 'btn-primary' : 'btn-outline-primary' }}">
                    Semua Pengguna
                </button>
                <button wire:click="pilihMenu('tambah')" 
                    class="btn {{ $pilihanMenu=='tambah' ? 'btn-primary' : 'btn-outline-primary' }}">
                    Tambah Pengguna
                </button>
                <button wire:loading class="btn btn-info">
                    Loading....
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
            @if($pilihanMenu=='lihat')
            <div class="card border-primary">
                <div class="card-header">
                    Semua Pengguna
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Peran</th>
                        <th>Data</th>
                        </thead>
                        <tbody>
                            @foreach($semuaPengguna as $pengguna)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pengguna->name }}</td>
                                <td>{{ $pengguna->email }}</td>
                                <td>{{ $pengguna->peran }}</td>
                                <td>
                                    <button wire:click="pilihEdit({{ $pengguna->id }})" 
                                        class="btn {{ $pilihanMenu=='edit' ? 'btn-primary' : 'btn-outline-primary' }}">
                                        Edit Pengguna
                                    </button>
                                    @if(auth()->user()->peran == 'Admin')
                                    <button wire:click="pilihHapus({{ $pengguna->id }})" 
                                        class="btn {{ $pilihanMenu=='hapus' ? 'btn-danger' : 'btn-outline-danger' }}">
                                        Hapus Pengguna
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @elseif($pilihanMenu=='hapus')
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    Hapus Pengguna
                </div>
                <div class="card-body">
                    Anda yakin akan menghapus Pengguna ini?
                    <p>Nama : {{ $penggunaTerpilih->name }}</p>
                    @if(auth()->user()->peran == 'Admin')
                    <button class="btn btn-danger" wire:click='hapus'>Hapus</button> 
                    @endif
                    <button class="btn btn-secondary" wire:click='batal'>Batal</button> 
                </div>
            </div>
            @endif
            </div>
        </div>
    </div>
</div>
