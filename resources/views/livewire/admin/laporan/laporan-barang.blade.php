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
                        <h1>Barang</h1>
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
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title">Laporan Barang</h5>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <!-- Filter Produk -->
                                            <select wire:model="filterProduk" class="form-select">
                                                <option value="">Semua Jenis Produk</option>
                                                @foreach ($produks as $produk)
                                                <option value="{{ $produk->produk_id }}">{{ $produk->nama_produk }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <!-- Filter Status -->
                                            <select wire:model="filterStatus" class="form-select">
                                                <option value="">Semua Status</option>
                                                <option value="1">Dijual</option>
                                                <option value="0">Ditarik</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <!-- Tombol Filter -->
                                            <button wire:click="filterData" class="btn btn-primary w-100">Filter</button>
                                        </div>
                                    </div>



                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Kode Barang</th>
                                                <th scope="col">Nama Barang</th>
                                                <th scope="col">Jenis Produk</th>
                                                <th scope="col">Keuntungan</th>
                                                <th scope="col">Harga Jual</th>
                                                <th scope="col">Stok</th>
                                                <th scope="col">Status Barang</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($barangs as $barang)
                                            <tr>
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{ $barang->kode_barang ?? '-'}}</td>
                                                <td>{{ $barang->nama_barang ?? '-'}}</td>
                                                <td>{{ $barang->produk->nama_produk ?? '-'}}</td>
                                                <td>{{ $barang->persentase ?? '-'}}%</td>
                                                <td>{{ $barang->harga_jual ?? '-'}}</td>
                                                <td>{{ $barang->stok ?? '-'}}</td>
                                                <td>{{ $barang->status_barang == 1 ? 'Dijual' : 'Ditarik' }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </div>
</div>