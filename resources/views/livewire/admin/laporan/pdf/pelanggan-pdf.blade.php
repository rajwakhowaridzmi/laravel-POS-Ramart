<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pelanggan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Daftar Pelanggan</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Kode Pelanggan</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Nomor Telpon</th>
                <th>Email</th>
                <th>Status Member</th>
                <th>Total Poin</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pelanggans as $index => $pelanggan)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $pelanggan->kode_pelanggan ?? '-'}}</td>
                <td>{{ $pelanggan->nama ?? '-'}}</td>
                <td>{{ $pelanggan->alamat ?? '-'}}</td>
                <td>{{ $pelanggan->no_telp ?? '-'}}</td>
                <td>{{ $pelanggan->email ?? '-'}}</td>
                <td>{{ $pelanggan->member_status == '1' ? 'Aktif' : 'Nonaktif' }}</td>
                <td>{{ $pelanggan->total_poin ?? '-'}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
