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
                        <h1>Laporan Penjualan</h1>
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
                                            <input type="text" wire:model.debounce.500ms="searchQuery" class="form-control" placeholder="Cari No Faktur / Nama Pelanggan">
                                        </div>

                                        <div class="col-md-3">
                                            <!-- <label for="startDate">Tanggal Awal</label> -->
                                            <input type="date" wire:model="startDate" id="startDate" class="form-control">
                                        </div>

                                        <div class="col-md-3">
                                            <!-- <label for="endDate">Tanggal Akhir</label> -->
                                            <input type="date" wire:model="endDate" id="endDate" class="form-control">
                                        </div>


                                        <div class="col-md-3">
                                            <button wire:click="filterData" class="btn btn-primary w-100">Filter</button>
                                        </div>
                                    </div>

                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Nomor Faktur</th>
                                                <th scope="col">Tanggal</th>
                                                <th scope="col">Pelanggan</th>
                                                <th scope="col">Total Bayar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($penjualan as $loopIndex => $penjualans)
                                            <tr>
                                                <th>{{ $penjualan ->firstItem() + $loopIndex }}</th>
                                                <td>{{ $penjualans->no_faktur ?? '-'}}</td>
                                                <td>{{ $penjualans->tgl_faktur ?? '-'}}</td>
                                                <td>{{ $penjualans->pelanggan->nama ?? '-'}}</td>
                                                <td>Rp. {{ number_format($penjualans->total_bayar, 0, ',', '.') ?? '-' }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $penjualan->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </div>
</div>