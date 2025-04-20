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
                <span>Plutus</span>
                <button id="sidebar-close" class="lg:hidden text-gray-300 hover:text-white">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="flex-grow">
                <ul>
                    <ul>
                        <li class="mb-2">
                            <a href="{{ route('admin-home') }}"
                                class="flex items-center py-2 px-4 rounded text-gray-300 hover:bg-gray-700 hover:text-white bg-gray-700 text-white">
                                <i class="fas fa-home mr-3"></i> Dasbor
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('admin-transaksi') }}"
                                class="flex items-center py-2 px-4 rounded text-gray-300 hover:bg-gray-700 hover:text-white">
                                <i class="fas fa-arrow-right-arrow-left mr-3"></i> Transfer
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('admin-kelolaakun') }}"
                                class="flex items-center py-2 px-4 rounded text-gray-300 hover:bg-gray-700 hover:text-white">
                                <i class="fas fa-cog mr-3"></i> Akun
                            </a>
                        </li>
                    </ul>
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
    <main class="flex-1 overflow-y-auto">
        <!-- Top Bar -->
        <div class="bg-white shadow-md p-4 flex justify-between items-center">
            <div class="flex items-center">
                <button id="menuToggle" class="mr-4 lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h1 class="text-xl font-bold">Admin Dashboard</h1>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <button class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span
                            class="bg-red-500 text-white rounded-full h-5 w-5 flex items-center justify-center text-xs absolute -top-1 -right-1">3</span>
                    </button>
                </div>
                <div class="flex items-center">
                    <img src="/api/placeholder/40/40" alt="Admin" class="h-8 w-8 rounded-full mr-2">
                    <span class="text-gray-700">Admin</span>
                </div>
            </div>
        </div>

        <!-- Dashboard Content -->
        <div class="p-6">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4 mb-4">
                <div class="bg-white rounded-lg shadow-md p-6 flex items-center">
                    <div class="p-3 rounded-full bg-green-100 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500">Total Transaksi</p>
                        <p class="text-2xl font-bold">{{ $TotalTransaksi }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 flex items-center">
                    <div class="p-3 rounded-full bg-red-100 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500">Transaksi di Tolak</p>
                        <p class="text-2xl font-bold">{{ $TransaksiTolak }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 flex items-center">
                    <div class="p-3 rounded-full bg-green-100 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500">Transaksi Sukses</p>
                        <p class="text-2xl font-bold">{{ $TransaksiSukses }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 flex items-center">
                    <div class="p-3 rounded-full bg-orange-100 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500">Transaksi Pending</p>
                        <p class="text-2xl font-bold">{{ $TransaksiPending }}</p>
                    </div>
                </div>
            </div>

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
                                @else
                                    <span class="text-red-500">Dana Keluar</span>
                                @endif
                            </td>
                            <td class="border border-gray-200 px-4 py-2">{{ $item->confirmed }}</td>
                            <td class="border border-gray-200 px-4 py-2 text-green-500">Rp. {{ $item->amount }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        



                        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

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


