<div>
    @php
    $statusMapping = [
    '0' => 'Ditarik',
    '1' => 'Dijual'
    ];
    @endphp
    <div>
        <div>
            <main id="main" class="main">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="pagetitle">
                        <h1>Laporan Barang</h1>
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item">Pages</li>
                                <li class="breadcrumb-item active">Blank</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- Alert Success -->
                    @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show ms-3" role="alert" style="min-width: 300px;">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                </div>

                <section class="section">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mt-3 mb-2">
                                        <div class="col-md-12 d-flex gap-2">
                                            <button class="btn btn-primary w-50" wire:click="exportPdf">
                                                <i class="bi bi-file-earmark-pdf-fill"></i> Export PDF
                                            </button>
                                            <button class="btn btn-success w-50" wire:click="exportExcel">
                                                <i class="bi bi-file-excel-fill me-1"></i> Export Excel
                                            </button>
                                        </div>
                                    </div>

                                    <div class="row g-2 my-2 mb-4">
                                        <div class="col-md-3">
                                            <input type="text" id="searchBarang" wire:model.debounce.500ms="searchBarang" class="form-control" placeholder="Nama/Kode Barang">
                                        </div>

                                        <div class="col-md-3">
                                            <select id="filterProduk" wire:model="filterProduk" class="form-select">
                                                <option value="">Semua Jenis Produk</option>
                                                @foreach ($produks as $produk)
                                                <option value="{{ $produk->produk_id }}">{{ $produk->nama_produk }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <select id="filterStatus" wire:model="filterStatus" class="form-select">
                                                <option value="">Semua Status</option>
                                                <option value="1">Dijual</option>
                                                <option value="0">Ditarik</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <button wire:click="filterData" class="btn btn-primary w-100">Filter</button>
                                        </div>
                                    </div>

                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Kode Barang</th>
                                                <th scope="col">Nama Barang</th>
                                                <th scope="col">Jenis Produk</th>
                                                <th scope="col">Keuntungan</th>
                                                <th scope="col">Harga Jual</th>
                                                <th scope="col">Stok</th>
                                                <th scope="col">Total Terjual</th>
                                                <th scope="col">Keuntungan</th>
                                                <th scope="col">Status Barang</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($barangs as $loopIndex => $barang)
                                            <tr>
                                                <th>{{ $barangs ->firstItem() + $loopIndex }}</th>
                                                <td>{{ $barang->kode_barang ?? '-'}}</td>
                                                <td>{{ $barang->nama_barang ?? '-'}}</td>
                                                <td>{{ $barang->produk->nama_produk ?? '-'}}</td>
                                                <td>{{ $barang->persentase ?? '-'}}%</td>
                                                <td>{{ $barang->harga_jual ?? '-'}}</td>
                                                <td>{{ $barang->stok ?? '-'}}</td>
                                                <td>{{ $barang->total_terjual ?? 0 }}</td>
                                                <td>Rp {{ number_format($barang->keuntungan, 0, ',', '.') }}</td>
                                                <td>{{ $statusMapping[$barang->status_barang] ?? '-' }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $barangs->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </div>
</div>