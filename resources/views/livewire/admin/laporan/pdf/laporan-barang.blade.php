<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Daftar Barang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
        }

        .kop-surat h2 {
            margin: 5px 0;
        }

        .kop-surat .info {
            font-size: 10px;
            color: #666;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table,
        .table th,
        .table td {
            border: 1px solid black;
        }

        .table th {
            background: #f2f2f2;
            text-align: center;
            padding: 6px;
        }

        .table td {
            padding: 5px;
        }

        .text-center {
            text-align: center;
        }

        .total-row {
            font-weight: bold;
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <div class="kop-surat">
        <h2><i class="bi bi-building"></i> PT. Ramart</h2>
        <p class="info">Jl. Kenangan No. 123, Kota Cianjur | Telp: (022) 123456 | Email: ramart@gmail.com</p>
        <hr>
        <h3>LAPORAN DAFTAR BARANG</h3>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Kode Barang</th>
                <th>Jenis Barang</th>
                <th>Nama Barang</th>
                <th>Persentase</th>
                <th>Harga Jual</th>
                <th>Total Terjual</th>
                <th>Keuntungan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalKeuntungan = 0;
            @endphp
            @foreach ($barangs as $index => $barang)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $barang->kode_barang ?? '-' }}</td>
                <td>{{ $barang->produk->nama_produk ?? '-' }}</td>
                <td>{{ $barang->nama_barang ?? '-' }}</td>
                <td>{{ $barang->persentase ?? '-' }}</td>
                <td class="text-center">{{ number_format($barang->harga_jual, 0, ',', '.') ?? '-' }}</td>
                <td>{{ $barang->total_terjual ?? 0 }}</td>
                <td>Rp {{ number_format($barang->keuntungan, 0, ',', '.') }}</td>
                <td class="text-center">{{ $statusMapping[$barang->status_barang] ?? '-' }}</td>
            </tr>
            @php
                $totalKeuntungan += $barang->keuntungan;
            @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="7" class="text-center">Total Keuntungan</td>
                <td class="text-center">Rp {{ number_format($totalKeuntungan, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>

</body>

</html>
