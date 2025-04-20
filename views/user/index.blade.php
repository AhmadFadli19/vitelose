<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasbor Keuangan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <style>
        @media (max-width: 768px) {
            .responsive-table {
                overflow-x: auto;
            }

            .sidebar-toggle {
                display: block;
            }

            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                position: fixed;
                z-index: 50;
                height: 100vh;
            }

            .sidebar.open {
                transform: translateX(0);
            }
        }
    </style>
</head>

<body class="bg-gray-100 font-sans antialiased">
    <!-- Mobile Navigation Toggle -->
    <div class="lg:hidden fixed top-4 left-4 z-50">
        <button id="sidebar-toggle" class="bg-gray-800 text-white p-2 rounded-md shadow-md">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <div class="flex min-h-screen relative">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="sidebar bg-gray-800 text-white w-64 flex flex-col py-6 px-3 transition-all duration-300">
            <div class="text-xl font-semibold mb-8 px-2 flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-wallet text-blue-400 mr-2"></i>
                    <span>Plutus</span>
                </div>
                <button id="sidebar-close" class="lg:hidden text-gray-300 hover:text-white">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="flex-grow">
                <ul>
                    <li class="mb-2">
                        <a href="{{ route('user-home', ['user' => $user]) }}"
                            class="flex items-center py-2 px-4 rounded text-gray-300 hover:bg-gray-700 hover:text-white bg-gray-700 text-white">
                            <i class="fas fa-home mr-3"></i> Dasbor
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('user-transfer', ['user' => $user]) }}"
                            class="flex items-center py-2 px-4 rounded text-gray-300 hover:bg-gray-700 hover:text-white">
                            <i class="fas fa-arrow-right-arrow-left mr-3"></i> Transfer
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="mt-auto">
                <ul>
                    <li>
                        <a href="{{ route('logout') }}"
                            class="flex items-center py-2 px-4 rounded text-gray-300 hover:bg-gray-700 hover:text-white">
                            @method('post')
                            @csrf
                            <i class="fas fa-sign-out-alt mr-3"></i> Keluar
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-gray-100 p-4 md:p-6 ml-0 lg:ml-64">
            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <header class="flex items-center justify-between mb-6 mt-4 lg:mt-0">
                    <div class="text-xl font-semibold text-gray-800">Dasbor {{ $user->name }}</div>
                </header>

                <!-- Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-6">
                    <div class="bg-white shadow-md rounded-lg p-4 md:p-6">
                        <h2 class="text-gray-700 font-semibold mb-4">Saldo Total</h2>
                        <div class="text-2xl font-bold text-gray-800">Rp
                            {{ number_format($saldo_user->saldo, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="bg-white shadow-md rounded-lg p-4 md:p-6">
                        <h2 class="text-gray-700 font-semibold mb-4">Penghasilan</h2>
                        <div class="text-2xl font-bold text-gray-800">Rp {{ number_format($pemasukan, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="bg-white shadow-md rounded-lg p-4 md:p-6">
                        <h2 class="text-gray-700 font-semibold mb-4">Pengeluaran</h2>
                        <div class="text-2xl font-bold text-gray-800">Rp {{ number_format($pengeluaran, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                <!-- Transactions Table -->
                <div class="bg-white shadow-md rounded-lg p-4 md:p-6 mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-gray-700 font-semibold text-lg">Transaksi Terbaru</h2>
                        <div class="flex space-x-2">
                            <div class="relative">
                                <input type="text" placeholder="Mencari"
                                    class="w-full md:w-auto bg-gray-100 border border-gray-300 rounded-md py-2 px-3 text-sm focus:outline-none focus:shadow-outline">
                                <button class="absolute right-0 top-0 mt-1 mr-2 text-gray-500"><i
                                        class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="responsive-table">
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal</th>
                                    <th
                                        class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tipe</th>
                                    <th
                                        class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Deskripsi</th>
                                    <th
                                        class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jumlah</th>
                                    <th
                                        class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($saldo_transaksi as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border border-gray-200 px-4 py-3 text-sm text-gray-600">
                                            {{ $item->created_at->format('d M Y H:i') }}</td>
                                        <td class="border border-gray-200 px-4 py-3">

                                            @if ($item->type == 'top_up')
                                                <span
                                                    class="bg-green-100 text-green-600 py-1 px-2 rounded-full text-xs">Masukkan
                                                    Dana</span>
                                            @elseif ($item->type == 'withdraw')
                                                <span
                                                    class="bg-red-100 text-red-600 py-1 px-2 rounded-full text-xs">Dana
                                                    Keluar</span>
                                            @elseif ($item->type == 'transfer')
                                                <span
                                                    class="bg-blue-100 text-blue-600 py-1 px-2 rounded-full text-xs">Transfer</span>
                                            @endif
                                        </td>
                                        <td class="border border-gray-200 px-4 py-3">
                                            <div>
                                                @if ($item->type == 'top_up')
                                                    <div class="flex items-center">
                                                        <div class="bg-green-100 text-green-500 rounded-full p-2 mr-3">
                                                            <i class="fas fa-arrow-up"></i>
                                                        </div>
                                                        <div>
                                                            <div class="font-semibold text-gray-800">Top Up
                                                            </div>
                                                            <div class="text-xs text-gray-500">{{ $item->deskripsi }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif ($item->type == 'withdraw')
                                                    <div class="flex items-center">
                                                        <div class="bg-red-100 text-red-500 rounded-full p-2 mr-3">
                                                            <i class="fas fa-arrow-down"></i>
                                                        </div>
                                                        <div>
                                                            <div class="font-semibold text-gray-800">Tarik Dana
                                                            </div>
                                                            <div class="text-xs text-gray-500">{{ $item->deskripsi }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif ($item->type == 'transfer')
                                                    <div class="flex items-center">
                                                        <div class="bg-blue-100 text-blue-500 rounded-full p-2 mr-3">
                                                            <i class='fas fa-money-bill-alt' style='color:blue'></i>
                                                        </div>
                                                        <div>
                                                            <div class="font-semibold text-gray-800">Transfer Cepat
                                                            </div>
                                                            <div class="text-xs text-gray-500">{{ $item->deskripsi }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="border border-gray-200 px-4 py-3">
                                            @if ($item->confirmed == 'sukses')
                                                <span
                                                    class="bg-green-100 text-green-800 px-2 py-1 rounded">Sukses</span>
                                            @elseif ($item->confirmed == 'pending')
                                                <span
                                                    class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Pending</span>
                                            @elseif ($item->confirmed == 'tolak')
                                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded">Ditolak</span>
                                            @endif
                                        </td>
                                        @if ($item->type == 'top_up')
                                            <td class="border border-gray-200 px-4 py-3 text-green-500 font-semibold">
                                                +Rp {{ $item->amount }}
                                            </td>
                                        @elseif ($item->type == 'withdraw')
                                            <td class="border border-gray-200 px-4 py-3 text-red-500 font-semibold">
                                                -Rp {{ $item->amount }}
                                            @elseif ($item->type == 'transfer')
                                            <td class="border border-gray-200 px-4 py-3 text-blue-500 font-semibold">
                                                -Rp {{ $item->amount }}
                                        @endif
                                        <td class="border border-gray-200 px-4 py-3">
                                            <a href="{{ route('transaksi.pdf.single', $item->id) }}"
                                                class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-1 px-2 rounded text-xs flex items-center w-min whitespace-nowrap">
                                                <i class="fas fa-file-pdf mr-1"></i> PDF
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 flex flex-wrap justify-between items-center">
                        <div class="flex flex-wrap gap-2 mb-2 sm:mb-0">
                            <button
                                class="bg-red-200 text-gray-700 py-1 px-3 rounded-full text-sm focus:outline-none hover:bg-red-300 transition-colors">Pengeluaran</button>
                            <button
                                class="bg-blue-500 text-white py-1 px-3 rounded-full text-sm focus:outline-none hover:bg-blue-600 transition-colors">Transfer</button>
                            <button
                                class="bg-green-500 text-white py-1 px-3 rounded-full text-sm focus:outline-none hover:bg-green-600 transition-colors">Penghasilan</button>
                        </div>

                        <a href="{{ route('transaksi.pdf.all') }}"
                            class="bg-green-500 hover:bg-green-600 transition-colors text-white font-bold py-2 px-4 rounded flex items-center">
                            <i class="fas fa-file-pdf mr-2"></i> Cetak Semua Transaksi
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>




    <script>
        // Toggle sidebar for mobile
        document.getElementById('sidebar-toggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.add('open');
        });

        document.getElementById('sidebar-close').addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('open');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');

            if (window.innerWidth < 1024) {
                if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target) && sidebar.classList
                    .contains('open')) {
                    sidebar.classList.remove('open');
                }
            }
        });

        // Ensure sidebar is visible on desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                document.getElementById('sidebar').classList.remove('open');
            }
        });
    </script>
</body>

</html>
