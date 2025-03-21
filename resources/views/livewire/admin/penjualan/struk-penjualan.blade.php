<div>
    @if ($showModal)
        <div class="modal fade show d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Struk Penjualan</h5>
                        <button type="button" class="close" wire:click="closeModal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <h4>STRUK PENJUALAN</h4>
                            <p>Toko XYZ</p>
                            <p>===========================</p>
                        </div>

                        @if ($penjualan_id)
                            <p>Pelanggan: {{ $pelanggan_id ?? 'Tidak diketahui' }}</p>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Barang</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barang ?? [] as $item)
                                        <tr>
                                            <td>{{ $item['nama_barang'] }}</td>
                                            <td>{{ $item['jumlah'] }}</td>
                                            <td>Rp {{ number_format($item['harga_jual'], 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($item['sub_total'], 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <p><strong>Total: Rp {{ number_format($total ?? 0, 0, ',', '.') }}</strong></p>
                            <p>Bayar: Rp {{ number_format($jumlah_bayar ?? 0, 0, ',', '.') }}</p>
                            <p>Kembalian: Rp {{ number_format($kembalian ?? 0, 0, ',', '.') }}</p>
                        @else
                            <p class="text-center">Struk belum tersedia</p>
                        @endif

                        <div class="text-center">
                            <p>===========================</p>
                            <p>Terima Kasih!</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" onclick="window.print()">Cetak Struk</button>
                        <button class="btn btn-secondary" wire:click="closeModal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</div>

<script>
    window.addEventListener('cetakStruk', () => {
        console.log("printStrukJS triggered!");
        document.getElementById('strukArea').classList.remove('d-none');
        setTimeout(() => {
            window.print();
        }, 500);
    });
</script>