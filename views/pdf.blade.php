<!DOCTYPE html>
<html>
<head>
    <title>{{ $type == 'single' ? 'Detail Transaksi' : 'Laporan Semua Transaksi' }}</title>
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
        .transaction-info {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
        }
        .info-row {
            margin-bottom: 10px;
        }
        .label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }
        .value {
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="page-header">
        <h2>{{ $type == 'single' ? 'Detail Transaksi' : 'Laporan Transaksi' }}</h2>
    </div>
    
    <div class="user-info">
        <strong>Nama User:</strong> {{ $user->name }}<br>
        <strong>Email:</strong> {{ $user->email }}<br>
        <strong>Saldo Saat Ini:</strong> Rp. {{ number_format($saldo->saldo, 0, ',', '.') }}<br>
        <strong>Tanggal Cetak:</strong> {{ date('d-m-Y H:i:s') }}
    </div>
    
    @if($type == 'single')
        {{-- Tampilan untuk satu transaksi --}}
        <div class="transaction-info">
            <div class="info-row">
                <span class="label">ID Transaksi:</span>
                <span class="value">{{ $transaksi->id }}</span>
            </div>
            <div class="info-row">
                <span class="label">Tanggal:</span>
                <span class="value">{{ $transaksi->created_at->format('d M Y H:i:s') }}</span>
            </div>
            <div class="info-row">
                <span class="label">Jenis Transaksi:</span>
                <span class="value">
                    @if ($transaksi->type == 'top_up')
                        <span class="text-green">Masukkan Dana</span>
                    @elseif ($transaksi->type == 'withdraw')
                        <span class="text-red">Dana Keluar</span>
                    @elseif ($transaksi->type == 'transfer')
                        <span class="text-blue">Transfer</span>
                    @endif
                </span>
            </div>
            <div class="info-row">
                <span class="label">Deskripsi:</span>
                <span class="value">{{ $transaksi->detail_message ?? $transaksi->deskripsi }}</span>
            </div>
            <div class="info-row">
                <span class="label">Status:</span>
                <span class="value">
                    @if ($transaksi->confirmed == 'sukses')
                        <span class="status-sukses">Sukses</span>
                    @elseif ($transaksi->confirmed == 'pending')
                        <span class="status-pending">Pending</span>
                    @elseif ($transaksi->confirmed == 'tolak')
                        <span class="status-tolak">Ditolak</span>
                    @endif
                </span>
            </div>
            <div class="info-row">
                <span class="label">Jumlah:</span>
                <span class="value {{ $transaksi->type == 'withdraw' ? 'text-red' : 'text-green' }}">
                    Rp. {{ number_format($transaksi->amount, 0, ',', '.') }}
                </span>
            </div>
        </div>
    @else
        {{-- Tampilan untuk semua transaksi --}}
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
    @endif
    
    <div class="footer">
        Dokumen ini dicetak pada {{ date('d-m-Y H:i:s') }} dan merupakan bukti transaksi yang sah.
    </div>
</body>
</html>