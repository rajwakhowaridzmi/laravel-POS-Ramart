<div>
    <div>
        <div>
            <main id="main" class="main">
                <div class="pagetitle">
                    <h1>Tambah Produk</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item">Pages</li>
                            <li class="breadcrumb-item active">Blank</li>
                        </ol>
                    </nav>
                </div><!-- End Page Title -->

                <x-alert type="success" :message="session('success')" />
                <x-alert type="error" :message="session('error')" />
                
                <section class="section">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Tambah Produk</h5>

                                    <!-- General Form Elements -->
                                    <form wire:submit.prevent="store">
                                        <div class="row mb-3">
                                            <label for="nama_produk" class="col-sm-2 col-form-label">Nama Produk</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="nama_produk" wire:model="nama_produk">
                                                @error('nama_produk')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-12 text-end">
                                            <button type="submit" class="btn btn-primary">Tambah</button>
                                            <a wire:navigate href="/pemasok" class="btn btn-outline-primary">Batal</a>
                                        </div>

                                    </form><!-- End General Form Elements -->
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </div>
</div>