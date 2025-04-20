<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Dashboard Keuangan</title>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col items-center">
    <!-- Dashboard Header -->
    <div class="bg-blue-600 text-white w-full py-4 shadow-md">
        <h1 class="text-center text-xl font-bold">Dashboard Keuangan</h1>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto p-6">
        <!-- Forms Section -->
        {{-- <div class="grid md:grid-cols-2 gap-6 mb-8">
            <!-- Masukkan Dana Form -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold mb-4">Masukkan Dana</h2>
                <form action="{{ route('masukkan-dana-bank', $user->id) }}" method="POST">
                    @csrf
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="top_up_form">Jumlah Dana</label>
                    <input type="number" id="top_up_form" name="top_up_form"
                        class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Masukkan jumlah dana" required>
                    <button type="submit"
                        class="mt-4 w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Simpan</button>
                </form>
            </div> --}}

        <div class="p-4 border-t border-blue-700">
            <a href="{{ route('logout') }}" class="flex items-center">
                @method('post')
                @csrf
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Logout</span>
            </a>
        </div>

        <div>
            <h1>{{ $user->name }}</h1>
        </div>





        <!-- Actions Modal Triggers -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold mb-4">Aksi</h2>
            <!-- Button untuk transfer dana -->
            <button onclick="openTransferModal()"
                class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600 mb-4">Transfer Dana</button>

            <!-- Button untuk penarikan dana -->
            <button onclick="openWithdrawModal()"
                class="w-full bg-red-500 text-white p-2 rounded hover:bg-red-600">Tarik Dana Pengguna</button>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('transaksi.pdf.all') }}"
            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-file-pdf"></i> Cetak Semua Transaksi
        </a>
    </div>

    <!-- History Section -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-lg font-semibold mb-4">Riwayat Transaksi</h2>
        <table class="w-full border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-200 px-4 py-2">Tanggal</th>
                    <th class="border border-gray-200 px-4 py-2">Deskripsi</th>
                    <th class="border border-gray-200 px-4 py-2">Status</th>
                    <th class="border border-gray-200 px-4 py-2">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($saldo_transaksi as $item)
                    <tr>
                        <td class="border border-gray-200 px-4 py-2">{{ $item->created_at }}</td>
                        <td class="border border-gray-200 px-4 py-2">
                            @if ($item->type == 'top_up')
                                <span class="text-green-500">Masukkan Dana</span>
                            @elseif ($item->type == 'withdraw')
                                <span class="text-red-500">Dana Keluar</span>
                            @elseif ($item->type == 'transfer')
                                <span class="text-blue-500">Transfer Dana</span>
                            @endif
                            @if ($item->deskripsi)
                                <br><small class="text-gray-500">{{ $item->deskripsi }}</small>
                            @endif
                        </td>
                        <td class="border border-gray-200 px-4 py-2">{{ $item->confirmed }}</td>
                        <td class="border border-gray-200 px-4 py-2 text-green-500">Rp. {{ $item->amount }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pending Transactions Section -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-lg font-semibold mb-4">Transaksi Menunggu Konfirmasi</h2>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if (session('info'))
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
                {{ session('info') }}
            </div>
        @endif

        <table class="w-full border-collapse border border-gray-200 mb-4">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-200 px-4 py-2">ID</th>
                    <th class="border border-gray-200 px-4 py-2">Tanggal</th>
                    <th class="border border-gray-200 px-4 py-2">Role</th>
                    <th class="border border-gray-200 px-4 py-2">Pengguna</th>
                    <th class="border border-gray-200 px-4 py-2">Tipe</th>
                    <th class="border border-gray-200 px-4 py-2">Jumlah</th>
                    <th class="border border-gray-200 px-4 py-2">Deskripsi</th>
                    <th class="border border-gray-200 px-4 py-2">Status</th>
                    <th class="border border-gray-200 px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pendingTransaksi as $transaksi)
                    <tr>
                        <td class="border border-gray-200 px-4 py-2">{{ $transaksi->id }}</td>
                        <td class="border border-gray-200 px-4 py-2">{{ $transaksi->created_at }}</td>
                        <td class="border border-gray-200 px-4 py-2">{{ $transaksi->user->usertype }}</td>
                        <td class="border border-gray-200 px-4 py-2">{{ $transaksi->user->name }}</td>
                        <td class="border border-gray-200 px-4 py-2">
                            @if ($transaksi->type == 'top_up')
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded">Top Up</span>
                            @elseif ($transaksi->type == 'withdraw')
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded">Withdraw</span>
                            @elseif ($transaksi->type == 'transfer')
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">Transfer</span>
                            @endif
                        </td>
                        <td class="border border-gray-200 px-4 py-2">Rp
                            {{ number_format($transaksi->amount, 0, ',', '.') }}</td>
                        <td class="border border-gray-200 px-4 py-2">{{ $transaksi->deskripsi }}</td>
                        <td class="border border-gray-200 px-4 py-2">
                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded">
                                {{ ucfirst($transaksi->confirmed) }}
                            </span>
                        </td>
                        <td class="border border-gray-200 px-4 py-2">
                            <div class="flex space-x-2">
                                <form action="{{ route('konfirmasi-transaksi', $transaksi->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="sukses">
                                    <button type="submit"
                                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">
                                        Terima
                                    </button>
                                </form>

                                <form action="{{ route('konfirmasi-transaksi', $transaksi->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="tolak">
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="border border-gray-200 px-4 py-2 text-center">Tidak ada transaksi
                            yang menunggu konfirmasi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Recent Confirmed Transactions -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold mb-4">Transaksi Terbaru</h2>
        <!-- Search and Filter -->
        <div class="flex flex-wrap gap-4 mb-4">
            <div class="flex-1 min-w-[300px]">
                <div class="relative">
                    <form action="{{ route('banksearch') }}" method="get">
                        <div class="flex p-2 relative items-center rounded bg-white border border-black">
                            <input type="text" name="banksearch" placeholder="Search Data"
                                class="h-9 w-full rounded-full bg-transparent px-4 py-1 text-gray-900 outline-none focus:outline-none"
                                value="{{ isset($banksearch) ? $banksearch : '' }}">
                            <button type="submit" class="rounded-full bg-blue-600 mx-2 px-2 py-2 text-white">
                                <svg class="w-4 text-white dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <table class="w-full border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-200 px-4 py-2">ID</th>
                    <th class="border border-gray-200 px-4 py-2">Tanggal</th>
                    <th class="border border-gray-200 px-4 py-2">Role</th>
                    <th class="border border-gray-200 px-4 py-2">Pengguna</th>
                    <th class="border border-gray-200 px-4 py-2">Tipe</th>
                    <th class="border border-gray-200 px-4 py-2">Jumlah</th>
                    <th class="border border-gray-200 px-4 py-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentTransaksi as $transaksi)
                    <tr>
                        <td class="border border-gray-200 px-4 py-2">{{ $transaksi->id }}</td>
                        <td class="border border-gray-200 px-4 py-2">{{ $transaksi->created_at }}</td>
                        <td class="border border-gray-200 px-4 py-2">{{ $transaksi->user->usertype }}</td>
                        <td class="border border-gray-200 px-4 py-2">{{ $transaksi->user->name }}</td>
                        <td class="border border-gray-200 px-4 py-2">
                            @if ($transaksi->type == 'top_up')
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded">Top Up</span>
                            @elseif ($transaksi->type == 'withdraw')
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded">Withdraw</span>
                            @elseif ($transaksi->type == 'transfer')
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">Transfer</span>
                            @endif
                        </td>
                        <td class="border border-gray-200 px-4 py-2">Rp
                            {{ number_format($transaksi->amount, 0, ',', '.') }}</td>
                        <td class="border border-gray-200 px-4 py-2">
                            @if ($transaksi->confirmed == 'sukses')
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded">Sukses</span>
                            @elseif ($transaksi->confirmed == 'tolak')
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded">Ditolak</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Pending</span>
                            @endif
                        </td>
                        <td class="border border-gray-200 px-4 py-2">
                            <a href="{{ route('transaksi.pdf.single', $item->id) }}"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-xs">
                                <i class="fas fa-file-pdf"></i> PDF
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="border border-gray-200 px-4 py-2 text-center">Tidak ada
                            transaksi terbaru</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    </div>

    <!-- Withdraw User Funds Modal -->
    <div id="withdrawModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-lg w-96">
            <h2 class="text-lg font-semibold mb-4">Tarik Dana Pengguna</h2>
            <form action="{{ route('keluarkan-dana-bank') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="nama_user">Pilih User</label>
                    <select id="nama_user" name="nama_user"
                        class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-red-500" required>
                        <option value="">Pilih User</option>
                        @foreach ($teman as $t)
                            <option value="{{ $t->name }}">{{ $t->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="jumlah_withdraw">Jumlah
                        Dana</label>
                    <input type="number" id="jumlah_withdraw" name="jumlah_withdraw"
                        class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-red-500"
                        placeholder="Masukkan jumlah dana" required>
                </div>
                <div class="mt-4 flex justify-between">
                    <button type="button" onclick="closeWithdrawModal()"
                        class="bg-gray-300 text-gray-700 p-2 rounded hover:bg-gray-400">Batal</button>
                    <button type="submit" class="bg-red-500 text-white p-2 rounded hover:bg-red-600">Tarik
                        Dana</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Transfer Modal -->
    <div id="transferModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-lg w-96">
            <h2 class="text-lg font-semibold mb-4">Transfer Dana</h2>
            <form action="{{ route('transfer-dana-bank') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="namateman">Penerima</label>
                    <select id="namateman" name="namateman"
                        class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Pilih Penerima</option>
                        @foreach ($teman as $t)
                            <option value="{{ $t->name }}">{{ $t->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="transfer">Jumlah
                        Transfer</label>
                    <input type="number" id="transfer" name="transfer"
                        class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Masukkan jumlah transfer" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi"
                        class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Deskripsi transfer" required></textarea>
                </div>
                <div class="mt-4 flex justify-between">
                    <button type="button" onclick="closeTransferModal()"
                        class="bg-gray-300 text-gray-700 p-2 rounded hover:bg-gray-400">Batal</button>
                    <button type="submit"
                        class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Transfer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Detail Transaction Modal -->
    <div id="detailModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-lg w-full max-w-xl">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Detail Transaksi</h2>
                <button onclick="closeDetailModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div id="transactionDetails" class="space-y-3">
                <!-- Transaction details will be populated here -->
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <button onclick="closeDetailModal()"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        function openWithdrawModal() {
            document.getElementById('withdrawModal').classList.remove('hidden');
        }

        function closeWithdrawModal() {
            document.getElementById('withdrawModal').classList.add('hidden');
        }

        function openTransferModal() {
            document.getElementById('transferModal').classList.remove('hidden');
        }

        function closeTransferModal() {
            document.getElementById('transferModal').classList.add('hidden');
        }

        function openDetailModal(transactionId) {
            // Fetch transaction details via AJAX
            fetch(`{{ url('/bank/detail-transaksi') }}/${transactionId}`)
                .then(response => response.json())
                .then(data => {
                    // Format the date
                    const date = new Date(data.tanggal);
                    const formattedDate = date.toLocaleString('id-ID', {
                        year: 'numeric',
                        month: '2-digit',
                        day: '2-digit',
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit'
                    });

                    // Format transaction type
                    let typeDisplay = '';
                    if (data.tipe === 'top_up') {
                        typeDisplay = '<span class="bg-green-100 text-green-800 px-2 py-1 rounded">Top Up</span>';
                    } else if (data.tipe === 'withdraw') {
                        typeDisplay = '<span class="bg-red-100 text-red-800 px-2 py-1 rounded">Withdraw</span>';
                    } else if (data.tipe === 'transfer') {
                        typeDisplay = '<span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">Transfer</span>';
                    }

                    // Format status
                    let statusDisplay = '';
                    if (data.status === 'sukses') {
                        statusDisplay = '<span class="bg-green-100 text-green-800 px-2 py-1 rounded">Sukses</span>';
                    } else if (data.status === 'tolak') {
                        statusDisplay = '<span class="bg-red-100 text-red-800 px-2 py-1 rounded">Ditolak</span>';
                    } else {
                        statusDisplay = '<span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Pending</span>';
                    }

                    // Format amount
                    const formattedAmount = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(data.jumlah);

                    // If there's a target user ID (for transfers), show that information
                    let targetUserInfo = '';
                    if (data.tujuan_user_id) {
                        targetUserInfo = `
                            <div class="font-medium">Penerima:</div>
                            <div class="col-span-2">${data.tujuan_user_name || 'Penerima tidak ditemukan'}</div>
                        `;
                    }

                    // Populate modal with data
                    document.getElementById('transactionDetails').innerHTML = `
                        <div class="grid grid-cols-3 gap-2">
                            <div class="font-medium">ID Transaksi:</div>
                            <div class="col-span-2">${data.id}</div>
                            
                            <div class="font-medium">Tanggal:</div>
                            <div class="col-span-2">${formattedDate}</div>
                            
                            <div class="font-medium">Nama:</div>
                            <div class="col-span-2">${data.nama_user}</div>
                            
                            ${targetUserInfo}
                            
                            <div class="font-medium">Tipe Transaksi:</div>
                            <div class="col-span-2">${typeDisplay}</div>
                            
                            <div class="font-medium">Jumlah:</div>
                            <div class="col-span-2">${formattedAmount}</div>
                            
                            <div class="font-medium">Deskripsi:</div>
                            <div class="col-span-2">${data.deskripsi || '-'}</div>
                            
                            <div class="font-medium">Status:</div>
                            <div class="col-span-2">${statusDisplay}</div>
                        </div>
                    `;

                    document.getElementById('detailModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error fetching transaction details:', error);
                    alert('Gagal mengambil detail transaksi');
                });
        }

        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }
    </script>
</body>

</html>
