<!DOCTYPE html>
<html>
<head>
    <title>Laporan Semua Transaksi</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .page-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .user-info {
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-green {
            color: green;
        }
        .text-red {
            color: red;
        }
        .text-blue {
            color: blue;
        }
        .status-sukses {
            background-color: #d4edda;
            color: #155724;
            padding: 3px 6px;
            border-radius: 3px;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
            padding: 3px 6px;
            border-radius: 3px;
        }
        .status-tolak {
            background-color: #f8d7da;
            color: #721c24;
            padding: 3px 6px;
            border-radius: 3px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="page-header">
        <h2>Laporan Transaksi</h2>
    </div>
    
    <div class="user-info">
        <strong>Nama User:</strong> {{ $user->name }}<br>
        <strong>Email:</strong> {{ $user->email }}<br>
        <strong>Saldo Saat Ini:</strong> Rp. {{ number_format($saldo->saldo, 0, ',', '.') }}<br>
        <strong>Tanggal Cetak:</strong> {{ date('d-m-Y H:i:s') }}
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($saldo_transaksi as $item)
                <tr>
                    <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                    <td>
                        @if ($item->type == 'top_up')
                            <span class="text-green">Masukkan Dana</span>
                        @elseif ($item->type == 'withdraw')
                            <span class="text-red">Dana Keluar</span>
                        @elseif ($item->type == 'transfer')
                            <span class="text-blue">Transfer</span>
                        @endif
                    </td>
                    <td>
                        {{ $item->detail_message ?? $item->deskripsi }}
                    </td>
                    <td>
                        @if ($item->confirmed == 'sukses')
                            <span class="status-sukses">Sukses</span>
                        @elseif ($item->confirmed == 'pending')
                            <span class="status-pending">Pending</span>
                        @elseif ($item->confirmed == 'tolak')
                            <span class="status-tolak">Ditolak</span>
                        @endif
                    </td>
                    <td class="{{ $item->type == 'withdraw' ? 'text-red' : 'text-green' }}">
                        Rp. {{ number_format($item->amount, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada data transaksi</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        Laporan ini dicetak pada {{ date('d-m-Y H:i:s') }}
    </div>
</body>
</html>