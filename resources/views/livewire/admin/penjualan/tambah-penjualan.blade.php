<div>
    <div>
        <div>
            <main id="main" class="main">
                <div class="pagetitle">
                    <h1>Penjualan</h1>
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
                                    <h5 class="card-title">Tambah Penjualan</h5>

                                    <!-- General Form Elements -->
                                    <form wire:submit.prevent="store">
                                        <div class="row mb-3">
                                            <label for="pelanggan_id" class="col-sm-2 col-form-label">Pelanggan</label>
                                            <div class="col-sm-10">
                                                <div class="dropdown">
                                                    <div class="input-group">
                                                        <input type="text"
                                                            wire:model.live="searchPelanggan"
                                                            class="form-control"
                                                            placeholder="Cari Pelanggan..."
                                                            @if($pelanggan_id) readonly @endif>
                                                        @if($pelanggan_id)
                                                        <button class="btn btn-primary" type="button" wire:click="resetPelanggan">X</button>
                                                        @endif
                                                    </div>
                                                    @if(!empty($filteredPelanggan) && !empty($searchPelanggan) && !$pelanggan_id)
                                                    <div class="dropdown-menu w-100 show" style="max-height: 200px; overflow-y: auto;">
                                                        @foreach ($filteredPelanggan as $pelanggans)
                                                        <a class="dropdown-item" href="#" wire:click.prevent="selectPelanggan('{{ $pelanggans->pelanggan_id }}', '{{ $pelanggans->nama }}')">
                                                            {{ $pelanggans->nama }}
                                                        </a>
                                                        @endforeach
                                                    </div>
                                                    @endif
                                                    <input type="hidden" wire:model="pelanggan_id">
                                                </div>
                                                @error('pelanggan_id')
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
                                                            wire:click.prevent="selectBarang('{{ $barang->barang_id }}', '{{ $barang->nama_barang }}', {{ $barang->kode_barang }})">
                                                            {{ $barang->nama_barang }} | {{ $barang->kode_barang }}
                                                        </a>
                                                        @endforeach
                                                    </div>
                                                    @endif
                                                </div>

                                                @if(!empty($selectedBarang))
                                                <div class="mt-3">
                                                    <!-- Tabel Barang -->
                                                    <div class="overflow-x-auto">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>Nama Barang</th>
                                                                    <th>Stok</th>
                                                                    <th>Jumlah</th>
                                                                    <th>Harga Satuan</th>
                                                                    <th>Subtotal</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($selectedBarang as $index => $barang)
                                                                <tr>
                                                                    <td class="align-middle">{{ $barang['nama_barang'] }} | {{ $barang['kode_barang'] }}</td>
                                                                    <td class="align-middle text-center">{{ $barang['stok'] }}</td>
                                                                    <td class="text-center align-middle">
                                                                        <input type="number" class="form-control"
                                                                            wire:model.live.debounce.500ms="selectedBarang.{{ $index }}.jumlah"
                                                                            placeholder="Masukkan Jumlah Barang"
                                                                            min="1"
                                                                            max="{{ $barang['stok'] }}"
                                                                            oninput="this.value = Math.min(this.value, this.max)">
                                                                    </td>
                                                                    <td>
                                                                        <input type="number" class="form-control"
                                                                            wire:model.live.debounce.500ms="selectedBarang.{{ $index }}.harga_jual" readonly>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control bg-white"
                                                                            wire:model.live="selectedBarang.{{ $index }}.sub_total" readonly>
                                                                    </td>
                                                                    <td class="text-center align-middle">
                                                                        <button type="button" class="btn btn-sm btn-danger" wire:click="resetBarang({{ $index }})">Hapus</button>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>


                                                    <!-- Total Keseluruhan -->
                                                    <div class="mt-3 p-2">
                                                        <h5 class="text-end">Total: <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></h5>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="jumlah_bayar" class="col-sm-2 col-form-label">Jumlah Bayar</label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" wire:model.live="jumlah_bayar" placeholder="Masukkan Jumlah Bayar" min="0">
                                                @error('jumlah_bayar')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="kembalian" class="col-sm-2 col-form-label">Kembalian</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" wire:model="kembalian" placeholder="Kembalian" readonly>
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