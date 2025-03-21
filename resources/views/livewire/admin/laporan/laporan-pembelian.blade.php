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
                        <h1>Laporan Pembelian</h1>
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

                                    <div class="row g-2 mt-2 mb-4">
                                        <div class="col-md-3">
                                            <input type="text" wire:model.debounce.500ms="searchQuery" class="form-control" placeholder="Cari Nama Barang">
                                        </div>

                                        <div class="col-md-3">
                                            <select wire:model="pemasokFilter" class="form-control">
                                                <option value="">Pilih Pemasok</option>
                                                @foreach($pemasoks as $pemasok)
                                                <option value="{{ $pemasok->pemasok_id }}">{{ $pemasok->nama_pemasok }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <input type="date" wire:model="startDate" id="startDate" class="form-control">
                                        </div>

                                        <div class="col-md-2">
                                            <input type="date" wire:model="endDate" id="endDate" class="form-control">
                                        </div>

                                        <div class="col-md-2">
                                            <button wire:click="filterData" class="btn btn-primary w-100">Filter</button>
                                        </div>
                                    </div>

                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Kode Masuk</th>
                                                <th scope="col">Tanggal</th>
                                                <th scope="col">Pemasok</th>
                                                <th scope="col">Nama Barang</th>
                                                <th scope="col">Harga Beli</th>
                                                <th scope="col">Jumlah</th>
                                                <th scope="col">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pembelian as $loopIndex => $pembelians)
                                            @foreach ($pembelians->detailPembelian as $key => $detail)
                                            <tr>
                                                @if ($key == 0)
                                                <td rowspan="{{ count($pembelians->detailPembelian) }}">{{ $pembelian->firstItem() + $loopIndex }}</td>
                                                <td rowspan="{{ count($pembelians->detailPembelian) }}">{{ $pembelians->kode_masuk ?? '-'}}</td>
                                                <td rowspan="{{ count($pembelians->detailPembelian) }}">{{ $pembelians->tanggal_masuk ?? '-'}}</td>
                                                <td rowspan="{{ count($pembelians->detailPembelian) }}">{{ $pembelians->pemasok->nama_pemasok ?? '-'}}</td>
                                                @endif

                                                <td>{{ $detail->barang->nama_barang ?? '-' }}</td>
                                                <td>Rp. {{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
                                                <td>{{ $detail->jumlah ?? '-' }}</td>
                                                <td>Rp. {{ number_format($detail->sub_total, 0, ',', '.') ?? '-' }}</td>
                                            </tr>
                                            @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $pembelian->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </div>
</div>