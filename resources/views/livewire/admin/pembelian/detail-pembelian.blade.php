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
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <h3 class="fw-bold mb-0"><i class="bi bi-shop fs-1 me-2"></i>Ramart</h3>
                            </div>
                            <h3 class="fw-bold mt-3">No. {{ $pembelian->kode_masuk ?? 'N/A' }}</h3>
                        </div>


                        <div class="card-body">
                            <div class="row my-4">
                                <div class="col-sm-6">
                                    <h5>Informasi Pemasok</h5>
                                    <p>
                                        <strong>Nama:</strong> {{ $pembelian->pemasok->nama_pemasok ?? 'Data tidak tersedia' }}<br>
                                        <strong>Alamat:</strong> {{ $pembelian->pemasok->alamat ?? 'Data tidak tersedia' }}<br>
                                        <strong>Telepon:</strong> {{ $pembelian->pemasok->no_telp ?? 'Data tidak tersedia' }}<br>
                                        <strong>Email:</strong> {{ $pembelian->pemasok->email ?? 'Data tidak tersedia' }}
                                    </p>
                                </div>
                                <div class="col-sm-6 text-end">
                                    <h5>Informasi Pembelian</h5>
                                    <p>
                                        <strong>Kode Masuk:</strong> {{ $pembelian->kode_masuk ?? 'Data tidak tersedia' }}<br>
                                        <strong>Tanggal Masuk:</strong> {{ $pembelian->tanggal_masuk ?? 'Data tidak tersedia' }}<br>
                                    </p>
                                </div>
                            </div>

                            <table class="table table-bordered mt-4">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Barang</th>
                                        <th>Harga Beli</th>
                                        <th>Jumlah</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $total = 0;
                                    @endphp
                                    @forelse ($pembelian->detailPembelian as $index => $detail)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $detail->barang->nama_barang ?? 'Data tidak tersedia' }}</td>
                                        <td>Rp. {{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
                                        <td>{{ $detail->jumlah }}</td>
                                        <td>Rp. {{ number_format($detail->sub_total, 0, ',', '.') }}</td>
                                    </tr>
                                    @php
                                    $total += $detail->sub_total;
                                    @endphp
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data barang.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <div class="text-end mt-5">
                                <h5>Total Pembelian: Rp. {{ number_format($total, 0, ',', '.') }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <a href="{{ url('/pembelian') }}" class="btn btn-primary">Kembali</a>
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
        location.reload(); // Reload halaman agar kembali ke tampilan semula
    }
</script>