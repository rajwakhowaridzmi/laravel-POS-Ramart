<div>
    <div>
        <div>
            <main id="main" class="main">
                <div class="pagetitle">
                    <h1>Barang</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item">Pages</li>
                            <li class="breadcrumb-item active">Blank</li>
                        </ol>
                    </nav>
                </div><!-- End Page Title -->

                <section class="section">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Tambah Barang</h5>

                                    <!-- General Form Elements -->
                                    <form wire:submit.prevent="store">
                                        <div class="row mb-3">
                                            <label for="kode_barang" class="col-sm-2 col-form-label">Kode Produk</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="kode_barang" wire:model="kode_barang">
                                                @error('kode_barang')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="nama_barang" class="col-sm-2 col-form-label">Nama Barang</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="nama_barang" wire:model="nama_barang">
                                                @error('nama_barang')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="produk_id" class="col-sm-2 col-form-label">Jenis Produk</label>
                                            <div class="col-sm-10">
                                                <select class="form-select" id="produk_id" wire:model="produk_id">
                                                    <option selected="">Pilih Jenis</option>
                                                    @foreach ($produk as $produks )
                                                    <option value="{{ $produks->produk_id}}">
                                                        {{ $produks->nama_produk }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @error('produk_id')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="harga_jual" class="col-sm-2 col-form-label">Harga Jual</label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" id="harga_jual" wire:model="harga_jual">
                                                @error('harga_jual')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="stok" class="col-sm-2 col-form-label">Stok</label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" id="stok" wire:model="stok">
                                                @error('stok')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12 text-end">
                                            <button type="submit" class="btn btn-primary">Tambah</button>
                                            <a wire:navigate href="/barang" class="btn btn-outline-primary">Batal</a>
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