<div>
    <div>
        <div>
            <main id="main" class="main">
                <div class="pagetitle">
                    <h1>Pembelian</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item">Transaksi</li>
                            <li class="breadcrumb-item active">Pembelian</li>
                        </ol>
                    </nav>
                </div><!-- End Page Title -->

                <section class="section">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Detail Pembelian</h5>

                                    <!-- General Form Elements -->
                                    <form>
                                        <div class="row mb-3">
                                            <label for="pemasok_id" class="col-sm-2 col-form-label">Pemasok</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="pemasok_id" value="{{ $pembelian->pemasok->nama_pemasok }}" readonly>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="kode_masuk" class="col-sm-2 col-form-label">Kode Masuk</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="kode_masuk" value="{{ $pembelian->kode_masuk }}" readonly>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="tanggal_masuk" class="col-sm-2 col-form-label">Tanggal Masuk</label>
                                            <div class="col-sm-10">
                                                <input type="date" class="form-control" id="tanggal_masuk" value="{{ $pembelian->tanggal_masuk }}" readonly>
                                            </div>
                                        </div>

                                        <hr class="mt-5 mb-2">

                                        <h5 class="card-title">Detail Barang</h5>

                                        @forelse ($pembelian->detailPembelian as $index => $detail)
                                        <div class="border rounded p-3 mb-3">
                                            <h5 class="fw-bold">Barang #{{ $index + 1 }}</h5>
    
                                            <div class="row mb-3">
                                                <label for="barang_id_{{ $index }}" class="col-sm-2 col-form-label">Nama Barang</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="barang_id_{{ $index }}" value="{{ $detail->barang->nama_barang }}" readonly>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="harga_beli_{{ $index }}" class="col-sm-2 col-form-label">Harga Beli</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="harga_beli_{{ $index }}" value="{{ number_format($detail->harga_beli, 0, ',', '.') }}" readonly>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="jumlah_{{ $index }}" class="col-sm-2 col-form-label">Jumlah</label>
                                                <div class="col-sm-10">
                                                    <input type="number" class="form-control" id="jumlah_{{ $index }}" value="{{ $detail->jumlah }}" readonly>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="sub_total_{{ $index }}" class="col-sm-2 col-form-label">Subtotal</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="sub_total_{{ $index }}" value="{{ number_format($detail->sub_total, 0, ',', '.') }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                        <p class="text-muted">Tidak ada data barang.</p>
                                        @endforelse

                                        <div class="col-sm-12 text-end">
                                            <a wire:navigate href="/pembelian" class="btn btn-primary">Kembali</a>
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