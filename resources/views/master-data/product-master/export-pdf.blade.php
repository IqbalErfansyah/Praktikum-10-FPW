<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Rekap Stok Produk Gudang - PT. Aria Coin</title>
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            font-size: 13px;
            background: #f9fafc;
            color: #333;
            margin: 40px;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #6f42c1;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }

        .header h1 {
            font-size: 20px;
            margin: 0;
            color: #6f42c1;
            letter-spacing: 1px;
        }

        .header h2 {
            font-size: 16px;
            margin: 4px 0;
            color: #555;
        }

        .header p {
            font-size: 13px;
            color: #777;
        }

        .info {
            text-align: right;
            font-size: 12px;
            color: #666;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        thead {
            background-color: #6f42c1;
            color: white;
        }

        th,
        td {
            padding: 8px 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        tbody tr:nth-child(even) {
            background-color: #f3f0fa;
        }

        tbody tr:hover {
            background-color: #ede7f6;
        }

        .signature {
            margin-top: 60px;
            text-align: right;
        }

        .signature p {
            font-size: 13px;
            color: #333;
            margin: 4px 0;
        }

        .signature .line {
            margin-top: 50px;
            border-top: 1px solid #333;
            width: 200px;
            float: right;
        }

        .footer {
            text-align: center;
            font-size: 11px;
            color: #999;
            margin-top: 40px;
        }

        .brand {
            text-align: left;
            font-size: 13px;
            color: #6f42c1;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="brand">Iqbal Production</div>

    <div class="header">
        <h1>PT. ARIA COIN</h1>
        <h2>Laporan Rekap Stok Produk Gudang</h2>
        <p>Periode: November 2025</p>
    </div>

    <div class="info">
        Dicetak pada: {{ date('d M Y H:i') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Satuan</th>
                <th>Kategori</th>
                <th>Deskripsi</th>
                <th>Stok</th>
                <th>Supplier</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Keluar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->product_name }}</td>
                <td>{{ $p->unit }}</td>
                <td>{{ $p->type }}</td>
                <td>{{ $p->information }}</td>
                <td>{{ $p->qty }}</td>
                <td>{{ $p->producer }}</td>
                <td>{{ $p->created_at->format('d M Y') }}</td>
                <td>{{ $p->updated_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signature">
        <p>Mengetahui,</p>
        <p><strong>Kepala Logistik</strong></p>
        <div class="line"></div>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} PT. Aria Coin | Dokumen ini dibuat secara otomatis oleh sistem gudang.
    </div>

</body>

</html>