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
                        <a href="{{ route('bank-home', ['user' => $user]) }}"
                            class="flex items-center py-2 px-4 rounded text-gray-300 hover:bg-gray-700 hover:text-white bg-gray-700 text-white">
                            <i class="fas fa-home mr-3"></i> Dasbor
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('bank-transfer', ['user' => $user]) }}"
                            class="flex items-center py-2 px-4 rounded text-gray-300 hover:bg-gray-700 hover:text-white">
                            <i class="fas fa-arrow-right-arrow-left mr-3"></i> Transfer
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('bank-kelolaakun', ['user' => $user]) }}"
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
        <main class="flex-1 overflow-y-auto bg-gray-100 p-4 md:p-6 ml-0 lg:ml-64">
            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <header class="flex items-center justify-between mb-6 mt-4 lg:mt-0">
                    <div class="text-xl font-semibold text-gray-800">Dashboard Admin Bank ( {{ $user->name }} ) </div>
                    <div class="flex items-center">
                        <div class="relative mr-4">
                            <button
                                class="bg-white text-gray-600 py-2 px-3 rounded-full hover:bg-gray-200 focus:outline-none focus:shadow-outline">
                                <i class="fas fa-bell"></i>
                                <span
                                    class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">3</span>
                            </button>
                        </div>
                        <div class="flex items-center">
                            <img src="/api/placeholder/40/40" alt="Admin Avatar"
                                class="w-8 h-8 rounded-full mr-2 object-cover">
                            <span class="text-gray-700 font-semibold hidden md:inline">Admin Bank</span>
                        </div>
                    </div>
                </header>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6">
                    <div class="bg-white shadow-md rounded-lg p-4 md:p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-gray-700 text-sm mb-1">Total Pengguna</h2>
                                <div class="text-2xl font-bold text-gray-800">{{ $TotalAkunUser }}</div>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-full">
                                <i class="fas fa-users text-blue-500"></i>
                            </div>
                        </div>
                        <div class="mt-2 text-sm text-green-500 flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i>
                        </div>
                    </div>

                    <div class="bg-white shadow-md rounded-lg p-4 md:p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-gray-700 text-sm mb-1">Total Transaksi</h2>
                                <div class="text-2xl font-bold text-gray-800">{{ $TotalTransaksi }}</div>
                            </div>
                            <div class="bg-green-100 p-3 rounded-full">
                                <i class="fas fa-exchange-alt text-green-500"></i>
                            </div>
                        </div>
                        <div class="mt-2 text-sm text-green-500 flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i>dari bulan lalu
                        </div>
                    </div>

                    <div class="bg-white shadow-md rounded-lg p-4 md:p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-gray-700 text-sm mb-1">Total Yang Berhasil</h2>
                                <div class="text-2xl font-bold text-gray-800">{{ $TransaksiSukses }}</div>
                            </div>
                            <div class="bg-yellow-100 p-3 rounded-full">
                                <i class="fas fa-money-bill-wave text-yellow-500"></i>
                            </div>
                        </div>
                        <div class="mt-2 text-sm text-green-500 flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i> dari bulan lalu
                        </div>
                    </div>

                    <div class="bg-white shadow-md rounded-lg p-4 md:p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-gray-700 text-sm mb-1">Permintaan Pending</h2>
                                <div class="text-2xl font-bold text-red-500">{{ $TransaksiPending }}</div>
                            </div>
                            <div class="bg-red-100 p-3 rounded-full">
                                <i class="fas fa-clock text-red-500"></i>
                            </div>
                        </div>
                        <div class="mt-2 text-sm text-red-500 flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i>dari kemarin
                        </div>
                    </div>
                </div>

                <!-- Pending Request Cards -->
                <div class="bg-white shadow-md rounded-lg p-4 md:p-6 mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-gray-700 font-semibold text-lg">Permintaan Dana Pending</h2>
                        <div class="flex space-x-2">
                            <a href="#" class="text-blue-500 text-sm hover:underline">Lihat semua permintaan</a>
                        </div>
                    </div>

                    <div class="responsive-table">
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID</th>
                                    <th
                                        class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Pengguna</th>
                                    <th
                                        class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tipe</th>
                                    <th
                                        class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jumlah</th>
                                    <th
                                        class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal</th>
                                    <th
                                        class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tindakan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($pendingTransaksi as $transaksi)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border border-gray-200 px-4 py-3 text-sm text-gray-600">
                                            {{ $transaksi->id }}
                                        </td>
                                        <td class="border border-gray-200 px-4 py-3">
                                            <div class="flex items-center">
                                                <img src="/api/placeholder/30/30" alt="User Avatar"
                                                    class="h-6 w-6 rounded-full mr-2 object-cover">
                                                <div>
                                                    <div class="font-semibold text-gray-800">
                                                        {{ $transaksi->user->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="border border-gray-200 px-4 py-3">
                                            @if ($transaksi->type == 'top_up')
                                                <span
                                                    class="bg-green-100 text-green-600 py-1 px-2 rounded-full text-xs">Top-Up</span>
                                            @elseif ($transaksi->type == 'withdraw')
                                                <span
                                                    class="bg-red-100 text-red-600 py-1 px-2 rounded-full text-xs">Withdraw</span>
                                             @elseif ($transaksi->type == 'transfer')
                                                    <span class="bg-blue-100 text-blue-600 py-1 px-2 rounded-full text-xs">Transfer</span>
                                            @endif

                                        </td>
                                        <td class="border border-gray-200 px-4 py-3 font-semibold">Rp
                                            {{ number_format($transaksi->amount, 0, ',', '.') }}</td>
                                        <td class="border border-yellow-200 px-4 py-3 text-sm text-yellow-600">
                                            {{ ucfirst($transaksi->confirmed) }}
                                        </td>
                                        <td class="border border-gray-200 px-4 py-3 text-sm text-gray-600">
                                            {{ $transaksi->created_at }}
                                        </td>
                                        <td class="border border-gray-200 px-4 py-3">
                                            {{-- <div class="flex space-x-2">
                                                <div>
                                                    <form action="{{ route('konfirmasi-transaksi', $transaksi->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button value="sukses"
                                                            class="bg-green-500 hover:bg-green-600 text-white font-medium py-1 px-2 rounded text-xs flex items-center">
                                                            <i class="fas fa-check mr-1"></i> Setuju
                                                        </button>
                                                    </form>
                                                </div>
                                                <div>
                                                    <form action="{{ route('konfirmasi-transaksi', $transaksi->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button value="tolak"
                                                            class="bg-red-500 hover:bg-red-600 text-white font-medium py-1 px-2 rounded text-xs flex items-center">
                                                            <i class="fas fa-times mr-1"></i> Tolak
                                                        </button>
                                                    </form>
                                                </div>
                                            </div> --}}
                                        <td class="border border-gray-200 px-4 py-2">
                                            <div class="flex space-x-2">
                                                <form action="{{ route('konfirmasi-transaksi', $transaksi->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="sukses">
                                                    <button type="submit"
                                                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">
                                                        Terima
                                                    </button>
                                                </form>

                                                <form action="{{ route('konfirmasi-transaksi', $transaksi->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="tolak">
                                                    <button type="submit"
                                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                                        Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        </td>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="border border-gray-200 px-4 py-2 text-center">Tidak
                                            ada transaksi
                                            yang menunggu konfirmasi</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- User List -->
                <div class="bg-white shadow-md rounded-lg p-4 md:p-6 mb-6">
                    <div class="flex flex-wrap justify-between items-center mb-4">
                        <h2 class="text-gray-700 font-semibold text-lg">Daftar Pengguna</h2>
                        <div class="flex mt-2 sm:mt-0">
                            <div class="relative mr-2">
                                <input type="text" placeholder="Cari pengguna..."
                                    class="w-full md:w-64 bg-gray-100 border border-gray-300 rounded-md py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <button class="absolute right-0 top-0 mt-2 mr-2 text-gray-500"><i
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
                                        ID</th>
                                    <th
                                        class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Pengguna</th>
                                    <th
                                        class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email</th>
                                    <th
                                        class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tipe</th>
                                    <th
                                        class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Saldo</th>
                                    <th
                                        class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal</th>
                                    <th
                                        class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tindakan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($recentTransaksi as $transaksi)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border border-gray-200 px-4 py-3 text-sm text-gray-600">
                                            {{ $transaksi->id }}</td>
                                        <td class="border border-gray-200 px-4 py-3">
                                            <div class="font-semibold text-gray-800">{{ $transaksi->user->name }}
                                            </div>
                                        </td>
                                        <td class="border border-gray-200 px-4 py-3 text-sm text-gray-600">
                                            {{ $transaksi->user->email }}</td>
                                        <td class="border border-gray-200 px-4 py-3">
                                            @if ($transaksi->type == 'top_up')
                                                <span
                                                    class="bg-green-100 text-green-600 py-1 px-2 rounded-full text-xs">Top-Up</span>
                                            @elseif ($transaksi->type == 'withdraw')
                                                <span
                                                    class="bg-red-100 text-red-600 py-1 px-2 rounded-full text-xs">Withdraw</span>
                                            @elseif ($transaksi->type == 'transfer')
                                                <span
                                                    class="bg-blue-100 text-blue-600 py-1 px-2 rounded-full text-xs">Transfer</span>
                                            @endif

                                        </td>
                                        <td class="border border-gray-200 px-4 py-3 font-semibold">
                                            {{ number_format($transaksi->amount, 0, ',', '.') }}</td>
                                        <td class="border border-gray-200 px-4 py-3 text-sm text-gray-600">
                                            {{ $transaksi->created_at }}</td>
                                        <td class="border border-gray-200 px-4 py-2">
                                            @if ($transaksi->confirmed == 'sukses')
                                                <span
                                                    class="bg-green-100 text-green-800 px-2 py-1 rounded">Sukses</span>
                                            @elseif ($transaksi->confirmed == 'tolak')
                                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded">Ditolak</span>
                                            @else
                                                <span
                                                    class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Pending</span>
                                            @endif
                                        </td>
                                        <td class="border border-gray-200 px-4 py-2">
                                            <a href="{{ route('transaksi.pdf.single', $transaksi->id) }}"
                                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-xs">
                                                <i class="fas fa-file-pdf"></i> PDF
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="border border-gray-200 px-4 py-2 text-center">Tidak
                                            ada
                                            transaksi terbaru</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                

                    <!-- Main modal -->
                    <div id="createuser-modal" tabindex="-1" aria-hidden="true"
                        class="hidden bg-yellow overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative p-4 w-full max-w-md max-h-full">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                                <!-- Modal header -->
                                <div
                                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                        Sign in to our platform
                                    </h3>
                                    <button type="button"
                                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                        data-modal-hide="createuser-modal">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2"
                                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="p-4 md:p-5">
                                    <form class="space-y-4" action="{{ route('admin-register') }}" method="POST">
                                        @csrf
                                        <div>
                                            <label for="name"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                name</label>
                                            <input type="name" name="name" id="name"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                                placeholder="name" required />
                                        </div>
                                        <div>
                                            <label for="email"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                email</label>
                                            <input type="email" name="email" id="email"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                                placeholder="email@company.com" required />
                                        </div>
                                        <div>
                                            <label for="usertype"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                usertype</label>
                                            <select id="subSystem-select" name="usertype"
                                                class="mr-4 mt-1 px-4 py-1 bg-gray-700 border shadow-sm border-slate-300 placeholder-slate-400 block w-full rounded-lg text-white"
                                                required>
                                                <option value="user">user</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="password"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                                password</label>
                                            <input type="password" name="password" id="password"
                                                placeholder="••••••••"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                                required />
                                        </div>
                                        <button type="submit"
                                            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Login
                                            Buat</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
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
