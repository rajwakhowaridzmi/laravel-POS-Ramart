<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pembelian</title>
    <style>
        .kop-surat {
            text-align: center;
            margin-bottom: 10px;
            page-break-before: avoid;
            page-break-after: avoid;
        }

        .container {
            width: 100%;
            padding: 0;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: auto;
        }

        thead {
            display: table-header-group;
        }

        tbody tr {
            page-break-inside: avoid;
        }

        th, td {
            padding: 8px;
            border: 1px solid black;
            text-align: left;
        }

        .total-row {
            font-weight: bold;
            text-align: right;
            /* background-color: #f2f2f2; */
        }
    </style>

</head>

<body>
    <div class="kop-surat">
        <h2>PT. Ramart</h2>
        <p class="info">Jl. Kenangan No. 123, Kota Cianjur | Telp: (022) 123456 | Email: ramart@gmail.com</p>
        <hr>
        <h3>LAPORAN PEMBELIAN</h3>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Kode Masuk</th>
                <th>Tanggal</th>
                <th>Pemasok</th>
                <th>Nama Barang</th>
                <th>Harga Beli</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $totalPembelian = 0; @endphp
            @foreach ($pembelian as $loopIndex => $pembelians)
            @php 
                $rowspan = count($pembelians->detailPembelian); 
            @endphp
            @foreach ($pembelians->detailPembelian as $key => $detail)
            @php 
                $totalPembelian += $detail->sub_total; 
            @endphp
            <tr>
                @if ($key == 0)
                <td rowspan="{{ $rowspan }}" class="rowspan-cell">{{ $loopIndex + 1 }}</td>
                <td rowspan="{{ $rowspan }}" class="rowspan-cell">{{ $pembelians->kode_masuk }}</td>
                <td rowspan="{{ $rowspan }}" class="rowspan-cell">{{ $pembelians->tanggal_masuk }}</td>
                <td rowspan="{{ $rowspan }}" class="rowspan-cell">{{ $pembelians->pemasok->nama_pemasok }}</td>
                @endif
                <td>{{ $detail->barang->nama_barang }}</td>
                <td>Rp. {{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
                <td>{{ $detail->jumlah }}</td>
                <td>Rp. {{ number_format($detail->sub_total, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            @endforeach

            <tr class="total-row">
                <td colspan="7">Total Pembelian</td>
                <td>Rp. {{ number_format($totalPembelian, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

</body>

</html>
