<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Pengajuan</title>
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
    </style>
</head>

<body>

    <div class="kop-surat">
        <h2><i class="bi bi-building"></i> PT. Ramart</h2>
        <p class="info">Jl. Kenangan No. 123, Kota Cianjur | Telp: (022) 123456 | Email: ramart@gmail.com</p>
        <hr>
        <h3>LAPORAN PENGAJUAN BARANG</h3>
    </div>

    <!-- <p><strong>Dicetak pada:</strong> {{ now() }}</p> -->

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Pengaju</th>
                <th>Nama Barang</th>
                <th>Tanggal Pengajuan</th>
                <th>Jumlah</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengajuan as $loopIndex => $pengajuans)
            <tr>
                <td class="text-center">{{ $loopIndex + 1 }}</td>
                <td>{{ $pengajuans->pelanggan->nama ?? '-' }}</td>
                <td>{{ $pengajuans->nama_barang ?? '-' }}</td>
                <td class="text-center">{{ $pengajuans->tgl_pengajuan ?? '-' }}</td>
                <td class="text-center">{{ $pengajuans->jumlah ?? '-' }}</td>
                <td class="text-center">{{ $pengajuans->status == '1' ? 'Terpenuhi' : 'Belum Terpenuhi' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>