<div>
    <div>
        <div>
            <main id="main" class="main">
                <div class="pagetitle">
                    <h1>Pembelian</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item">Pages</li>
                            <li class="breadcrumb-item active">Blank</li>
                        </ol>
                    </nav>
                </div><!-- End Page Title -->
                @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <section class="section">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Tambah Pembelian</h5>

                                    <!-- General Form Elements -->
                                    <form wire:submit.prevent="store">
                                        <div class="row mb-3">
                                            <label for="pemasok_id" class="col-sm-2 col-form-label">Pemasok</label>
                                            <div class="col-sm-10">
                                                <div class="dropdown">
                                                    <div class="input-group">
                                                        <input type="text"
                                                            wire:model.live="searchPemasok"
                                                            class="form-control"
                                                            placeholder="Cari Pemasok..."
                                                            @if($pemasok_id) readonly @endif>
                                                        @if($pemasok_id)
                                                        <button class="btn btn-primary" type="button" wire:click="resetPemasok">X</button>
                                                        @endif
                                                    </div>
                                                    @if(!empty($filteredPemasok) && !empty($searchPemasok) && !$pemasok_id)
                                                    <div class="dropdown-menu w-100 show" style="max-height: 200px; overflow-y: auto;">
                                                        @foreach ($filteredPemasok as $pemasoks)
                                                        <a class="dropdown-item" href="#" wire:click.prevent="selectPemasok('{{ $pemasoks->pemasok_id }}', '{{ $pemasoks->nama_pemasok }}')">
                                                            {{ $pemasoks->nama_pemasok }}
                                                        </a>
                                                        @endforeach
                                                    </div>
                                                    @endif
                                                    <input type="hidden" wire:model="pemasok_id">
                                                </div>
                                                @error('pemasok_id')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="barang_id" class="col-sm-2 col-form-label">Barang</label>
                                            <div class="col-sm-10">
                                                <div class="dropdown">
                                                    <div class="input-group">
                                                        <input type="text"
                                                            wire:model.live="searchBarang"
                                                            class="form-control"
                                                            placeholder="Cari Barang...">
                                                    </div>

                                                    @if(!empty($filteredBarang) && !empty($searchBarang))
                                                    <div class="dropdown-menu w-100 show" style="max-height: 200px; overflow-y: auto;">
                                                        @foreach ($filteredBarang as $barang)
                                                        <a class="dropdown-item" href="#"
                                                            wire:click.prevent="selectBarang('{{ $barang->barang_id }}', '{{ $barang->nama_barang }}')">
                                                            {{ $barang->nama_barang }}
                                                        </a>
                                                        @endforeach
                                                    </div>
                                                    @endif
                                                </div>

                                                @if(!empty($selectedBarang))
                                                <div class="mt-3">
                                                    <div class="form-control p-2">
                                                        @foreach($selectedBarang as $index => $barang)
                                                        <div class="w-100 border rounded p-2 bg-light mb-2">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <strong>Nama Barang : {{ $barang['nama_barang'] }}</strong>
                                                                <button type="button" class="btn btn-sm btn-danger p-0 px-1" wire:click="resetBarang({{ $index }})">X</button>
                                                            </div>

                                                            <!-- Input Harga Beli -->
                                                            <div class="mt-2">
                                                                <label class="form-label">Harga Beli</label>
                                                                <input type="number" step="0.01" class="form-control" wire:model.live.debounce.500ms="selectedBarang.{{ $index }}.harga_beli" placeholder="Masukkan Harga Beli">
                                                            </div>

                                                            <!-- Input Jumlah Barang -->
                                                            <div class="mt-2">
                                                                <label class="form-label">Jumlah Barang</label>
                                                                <input type="number" class="form-control" wire:model.live.debounce.500ms="selectedBarang.{{ $index }}.jumlah" placeholder="Masukkan Jumlah Barang">
                                                            </div>

                                                            <!-- Input Subtotal (Live Update) -->
                                                            <div class="mt-2">
                                                                <label class="form-label">Subtotal</label>
                                                                <input type="text" class="form-control bg-white" wire:model.live="selectedBarang.{{ $index }}.sub_total" placeholder="Subtotal" readonly>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>

                                                    <!-- Total Keseluruhan -->
                                                    <div class="mt-3 p-2 border-top">
                                                        <h5 class="text-end">Total: <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></h5>
                                                    </div>
                                                </div>
                                                @endif
                                                @error('selectedBarang')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>



                                        <div class="col-sm-12 text-end">
                                            <button type="submit" class="btn btn-primary">Tambah</button>
                                            <a wire:navigate href="/pembelian" class="btn btn-outline-primary">Batal</a>
                                        </div>

                                    </form><!-- End General Form Elements -->

                                    @if (session()->has('message'))
                                    <div class="alert alert-success mt-3">
                                        {{ session('message') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </div>
</div>