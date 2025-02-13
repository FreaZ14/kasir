<div>
<div class="container">
        <div class="row my-2">
            <div class="col-12">
                <button wire:click="pilihBarang('lihat')" 
                    class="btn {{ $pilihanBarang=='lihat' ? 'btn-primary' : 'btn-outline-primary' }}">
                    Semua Barang
                </button>
                <button wire:click="pilihBarang('tambah')" 
                    class="btn {{ $pilihanBarang=='tambah' ? 'btn-primary' : 'btn-outline-primary' }}">
                    Tambah Barang
                </button>
                <button wire:loading class="btn btn-info">
                    Loading....
                </button>
            </div>
        </div>
</div>
