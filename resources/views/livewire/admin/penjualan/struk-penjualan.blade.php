<div>
    @if (!empty($selectedBarang))
    <div class="d-flex justify-content-center">
        <div style="width: 100%; font-family: monospace; font-size: 12px; border: 1px dotted #000;">
            <div style="text-align: center; line-height: 1.2;">
                <strong>Ramart</strong><br>
                Jl. Jalan No. 123<br>
                Cianjur<br>
                ------------------------------
            </div>

            <div style="margin-top: 5px; line-height: 1.4;">
                Invoice : {{ $no_faktur }}<br>
                Tanggal : {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}<br>
                Kasir   : {{ $kasir->name ?? 'Admin' }}<br>
                Pelanggan : {{ $pelanggan->nama ?? '-' }}
            </div>

            <div style="border-top: 1px dashed #000; margin: 5px 0;"></div>

            @foreach ($selectedBarang as $barang)
                <div style="margin-bottom: 4px;">
                    <div>{{ $barang['nama_barang'] }}</div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>{{ $barang['jumlah'] }} x Rp{{ number_format($barang['harga_jual'], 0, ',', '.') }}</span>
                        <span>Rp{{ number_format($barang['sub_total'], 0, ',', '.') }}</span>
                    </div>
                </div>
            @endforeach

            <div style="border-top: 1px dashed #000; margin: 5px 0;"></div>

            <div style="display: flex; justify-content: space-between;">
                <strong>Total</strong> <strong>Rp{{ number_format($total, 0, ',', '.') }}</strong>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span>Bayar</span> <span>Rp{{ number_format($jumlah_bayar, 0, ',', '.') }}</span>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span>Kembalian</span> <span>Rp{{ number_format($kembalian, 0, ',', '.') }}</span>
            </div>

            <div style="border-top: 1px dashed #000; margin: 5px 0;"></div>

            <div style="text-align: center; line-height: 1.3;">
                *** Terima Kasih ***<br>
                Barang yang sudah dibeli<br>
                tidak dapat dikembalikan
            </div>
        </div>
    </div>
    @endif
</div>
