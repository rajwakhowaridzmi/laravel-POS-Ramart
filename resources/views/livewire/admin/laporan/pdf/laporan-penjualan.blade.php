<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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

        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border: 1px solid black;
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
        <h3>LAPORAN PENJUALAN</h3>
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>No Faktur</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($query as $penjualan)
            <tr>
                <th>{{ $loop->iteration }}</th>
                <td>{{ $penjualan->no_faktur ?? '-' }}</td>
                <td>{{ $penjualan->tgl_faktur ?? '-' }}</td>
                <td>{{ $penjualan->pelanggan->nama ?? '-' }}</td>
                <td>{{ number_format($penjualan->total_bayar, 0, ',', '.') ?? '-' }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="4" style="text-align: center;"><strong>Total Keseluruhan:</strong></td>
                <td><strong>Rp {{ number_format(collect($query)->sum('total_bayar'), 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>
</body>

</html>
