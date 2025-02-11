<div>
    
    <div class="container">
        <div class="row my-4">
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
            @elseif($pilihanMenu=='tambah')
            @elseif($pilihanMenu=='edit')
            @elseif($pilihanMenu=='hapus')
            @endif
            </div>
    </div>
</div>
