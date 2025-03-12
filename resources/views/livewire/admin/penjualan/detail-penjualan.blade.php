<div>
    <main id="main" class="main">
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
                    <div class="card" id="invoice">
                        <div class="card-header text-center">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <h3 class="fw-bold mb-0"><i class="bi bi-shop fs-1 me-2"></i>Ramart</h3>
                                </div>
                                <h3 class="fw-bold mt-3">No. {{ $penjualan->no_faktur ?? 'N/A' }}</h3>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row my-4">
                                <div class="col-sm-6">
                                    <h5>Informasi Penjual</h5>
                                    <p>
                                        <strong>Nama: </strong> {{ $penjualan->user->nama ?? 'Data tidak tersedia' }}<br>
                                        <strong>Alamat: </strong> Jl. Contoh No. 123, Jakarta<br>
                                        <strong>Telepon: </strong> (021) 1234567<br>
                                        <strong>Email: </strong> ramart@toko.com
                                    </p>
                                </div>
                                <div class="col-sm-6 text-end">
                                    <h5>Informasi Pembeli</h5>
                                    <p>
                                        <strong>Nama: </strong> {{ $penjualan->pelanggan->nama ?? '-' }}<br>
                                        <strong>Alamat: </strong> {{ $penjualan->pelanggan->alamat ?? '-' }}<br>
                                        <strong>No. Telepon: </strong> {{ $penjualan->pelanggan->no_telp ?? '-' }}<br>
                                    </p>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-sm-6">
                                    <h5>Tanggal Faktur</h5>
                                    <p>{{ $penjualan->tgl_faktur ?? 'Data tidak tersedia' }}</p>
                                </div>
                                <div class="col-sm-6 text-end">
                                    <h5>Total Bayar</h5>
                                    <p>Rp. {{ number_format($penjualan->total_bayar ?? 0, 0, ',', '.') }}</p>
                                </div>
                            </div>

                            <table class="table table-bordered mt-4">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Barang</th>
                                        <th>Harga Jual</th>
                                        <th>Jumlah</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($penjualan->detailPenjualan as $index => $detail)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $detail->barang->nama_barang ?? 'Data tidak tersedia' }}</td>
                                        <td>Rp. {{ number_format($detail->harga_jual, 0, ',', '.') }}</td>
                                        <td>{{ $detail->jumlah }}</td>
                                        <td>Rp. {{ number_format($detail->sub_total, 0, ',', '.') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data barang.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <a href="{{ url('/penjualan') }}" class="btn btn-primary">Kembali</a>
                        <button onclick="printInvoice()" class="btn btn-success">Print</button>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
<script>
    function printInvoice() {
        var printContent = document.getElementById("invoice").innerHTML;
        var originalContent = document.body.innerHTML;

        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
        location.reload();
    }
</script>