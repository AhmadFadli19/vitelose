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
                    <li class="mb-2">
                        <a href="#"
                            class="flex items-center py-2 px-4 rounded text-gray-300 hover:bg-gray-700 hover:text-white bg-gray-700 text-white">
                            <i class="fas fa-home mr-3"></i> Dasbor
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#"
                            class="flex items-center py-2 px-4 rounded text-gray-300 hover:bg-gray-700 hover:text-white">
                            <i class="fas fa-arrow-right-arrow-left mr-3"></i> Transfer
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#"
                            class="flex items-center py-2 px-4 rounded text-gray-300 hover:bg-gray-700 hover:text-white">
                            <i class="fas fa-list-ul mr-3"></i> Transaksi
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#"
                            class="flex items-center py-2 px-4 rounded text-gray-300 hover:bg-gray-700 hover:text-white">
                            <i class="fas fa-credit-card mr-3"></i> Akun & Kartu
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#"
                            class="flex items-center py-2 px-4 rounded text-gray-300 hover:bg-gray-700 hover:text-white">
                            <i class="fas fa-chart-line mr-3"></i> Investasi
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="mt-auto">
                <ul>
                    <li class="mb-2">
                        <a href="#"
                            class="flex items-center py-2 px-4 rounded text-gray-300 hover:bg-gray-700 hover:text-white">
                            <i class="fas fa-cog mr-3"></i> Pengaturan
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center py-2 px-4 rounded text-gray-300 hover:bg-gray-700 hover:text-white">
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
                    <div class="text-xl font-semibold text-gray-800">Dasbor</div>
                    <div class="flex items-center">
                        <div class="relative mr-4">
                            <button
                                class="bg-white text-gray-600 py-2 px-3 rounded-full hover:bg-gray-200 focus:outline-none focus:shadow-outline">
                                <i class="fas fa-bell"></i>
                            </button>
                        </div>
                        <div class="flex items-center">
                            <img src="/api/placeholder/40/40" alt="Avatar"
                                class="w-8 h-8 rounded-full mr-2 object-cover">
                            <span class="text-gray-700 font-semibold hidden md:inline">Nicola</span>
                        </div>
                    </div>
                </header>

                <!-- Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-6">
                    <div class="bg-white shadow-md rounded-lg p-4 md:p-6">
                        <h2 class="text-gray-700 font-semibold mb-4">Saldo Total</h2>
                        <div class="text-2xl font-bold text-gray-800">{{ number_format($total_saldo, 0, ',', '.') }}</div>
                    </div>

                    <div class="bg-white shadow-md rounded-lg p-4 md:p-6">
                        <h2 class="text-gray-700 font-semibold mb-4">Penghasilan</h2>
                        <div class="text-2xl font-bold text-gray-800">Rp {{ number_format($pemasukan, 0, ',', '.') }}</div>
                    </div>

                    <div class="bg-white shadow-md rounded-lg p-4 md:p-6">
                        <h2 class="text-gray-700 font-semibold mb-4">Pengeluaran</h2>
                        <div class="text-2xl font-bold text-gray-800">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</div>
                    </div>
                </div>

                <!-- Transactions Table -->
                <div class="bg-white shadow-md rounded-lg p-4 md:p-6 mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-gray-700 font-semibold text-lg">Transaksi Terbaru</h2>
                        <div class="flex space-x-2">
                            <a href="#" class="text-blue-500 text-sm hover:underline mr-2">Lihat semua</a>
                            <a href="{{ route('transaksi.pdf.all') }}"
                                class="bg-green-500 hover:bg-green-600 transition-colors text-white text-sm font-medium py-2 px-3 rounded flex items-center">
                                <i class="fas fa-file-pdf mr-1"></i> Cetak Semua
                            </a>
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
                                <tr class="hover:bg-gray-50">
                                    <td class="border border-gray-200 px-4 py-3 text-sm text-gray-600">18 Apr 2025</td>
                                    <td class="border border-gray-200 px-4 py-3">
                                        <span
                                            class="bg-red-100 text-red-600 py-1 px-2 rounded-full text-xs">Pengeluaran</span>
                                    </td>
                                    <td class="border border-gray-200 px-4 py-3">
                                        <div class="flex items-center">
                                            <div class="bg-teal-100 text-teal-500 rounded-full p-2 mr-3">
                                                <i class="fas fa-store"></i>
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-800">Burger Tengah</div>
                                                <div class="text-xs text-gray-500">Kafe dan Restoran</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="border border-gray-200 px-4 py-3">
                                        <span
                                            class="bg-green-100 text-green-600 py-1 px-2 rounded-full text-xs">Selesai</span>
                                    </td>
                                    <td class="border border-gray-200 px-4 py-3 text-red-500 font-semibold">-Rp 125.000
                                    </td>
                                    <td class="border border-gray-200 px-4 py-3">
                                        <a href="{{ route('transaksi.pdf.single', 1) }}"
                                            class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-1 px-2 rounded text-xs flex items-center w-min whitespace-nowrap">
                                            <i class="fas fa-file-pdf mr-1"></i> PDF
                                        </a>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="border border-gray-200 px-4 py-3 text-sm text-gray-600">17 Apr 2025</td>
                                    <td class="border border-gray-200 px-4 py-3">
                                        <span
                                            class="bg-red-100 text-red-600 py-1 px-2 rounded-full text-xs">Pengeluaran</span>
                                    </td>
                                    <td class="border border-gray-200 px-4 py-3">
                                        <div class="flex items-center">
                                            <div class="bg-pink-100 text-pink-500 rounded-full p-2 mr-3">
                                                <i class="fas fa-shopping-cart"></i>
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-800">Pasar</div>
                                                <div class="text-xs text-gray-500">Bahan makanan</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="border border-gray-200 px-4 py-3">
                                        <span
                                            class="bg-green-100 text-green-600 py-1 px-2 rounded-full text-xs">Selesai</span>
                                    </td>
                                    <td class="border border-gray-200 px-4 py-3 text-red-500 font-semibold">-Rp 92.500
                                    </td>
                                    <td class="border border-gray-200 px-4 py-3">
                                        <a href="{{ route('transaksi.pdf.single', 2) }}"
                                            class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-1 px-2 rounded text-xs flex items-center w-min whitespace-nowrap">
                                            <i class="fas fa-file-pdf mr-1"></i> PDF
                                        </a>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="border border-gray-200 px-4 py-3 text-sm text-gray-600">16 Apr 2025</td>
                                    <td class="border border-gray-200 px-4 py-3">
                                        <span
                                            class="bg-green-100 text-green-600 py-1 px-2 rounded-full text-xs">Penghasilan</span>
                                    </td>
                                    <td class="border border-gray-200 px-4 py-3">
                                        <div class="flex items-center">
                                            <div class="bg-green-100 text-green-500 rounded-full p-2 mr-3">
                                                <i class="fas fa-arrow-up"></i>
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-800">Transfer Cepat</div>
                                                <div class="text-xs text-gray-500">Maria Ungu</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="border border-gray-200 px-4 py-3">
                                        <span
                                            class="bg-green-100 text-green-600 py-1 px-2 rounded-full text-xs">Selesai</span>
                                    </td>
                                    <td class="border border-gray-200 px-4 py-3 text-green-500 font-semibold">+Rp
                                        750.000</td>
                                    <td class="border border-gray-200 px-4 py-3">
                                        <a href="{{ route('transaksi.pdf.single', 3) }}"
                                            class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-1 px-2 rounded text-xs flex items-center w-min whitespace-nowrap">
                                            <i class="fas fa-file-pdf mr-1"></i> PDF
                                        </a>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="border border-gray-200 px-4 py-3 text-sm text-gray-600">15 Apr 2025</td>
                                    <td class="border border-gray-200 px-4 py-3">
                                        <span
                                            class="bg-red-100 text-red-600 py-1 px-2 rounded-full text-xs">Pengeluaran</span>
                                    </td>
                                    <td class="border border-gray-200 px-4 py-3">
                                        <div class="flex items-center">
                                            <div class="bg-pink-100 text-pink-500 rounded-full p-2 mr-3">
                                                <i class="fas fa-shopping-cart"></i>
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-800">Pasar</div>
                                                <div class="text-xs text-gray-500">Bahan makanan</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="border border-gray-200 px-4 py-3">
                                        <span
                                            class="bg-green-100 text-green-600 py-1 px-2 rounded-full text-xs">Selesai</span>
                                    </td>
                                    <td class="border border-gray-200 px-4 py-3 text-red-500 font-semibold">-Rp 36.200
                                    </td>
                                    <td class="border border-gray-200 px-4 py-3">
                                        <a href="{{ route('transaksi.pdf.single', 4) }}"
                                            class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-1 px-2 rounded text-xs flex items-center w-min whitespace-nowrap">
                                            <i class="fas fa-file-pdf mr-1"></i> PDF
                                        </a>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="border border-gray-200 px-4 py-3 text-sm text-gray-600">14 Apr 2025</td>
                                    <td class="border border-gray-200 px-4 py-3">
                                        <span
                                            class="bg-red-100 text-red-600 py-1 px-2 rounded-full text-xs">Pengeluaran</span>
                                    </td>
                                    <td class="border border-gray-200 px-4 py-3">
                                        <div class="flex items-center">
                                            <div class="bg-teal-100 text-teal-500 rounded-full p-2 mr-3">
                                                <i class="fas fa-store"></i>
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-800">Burger Tengah</div>
                                                <div class="text-xs text-gray-500">Kafe dan Restoran</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="border border-gray-200 px-4 py-3">
                                        <span
                                            class="bg-yellow-100 text-yellow-600 py-1 px-2 rounded-full text-xs">Diproses</span>
                                    </td>
                                    <td class="border border-gray-200 px-4 py-3 text-red-500 font-semibold">-Rp 85.000
                                    </td>
                                    <td class="border border-gray-200 px-4 py-3">
                                        <a href="{{ route('transaksi.pdf.single', 5) }}"
                                            class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-1 px-2 rounded text-xs flex items-center w-min whitespace-nowrap">
                                            <i class="fas fa-file-pdf mr-1"></i> PDF
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 flex flex-wrap justify-between items-center">
                        <div class="flex flex-wrap gap-2 mb-2 sm:mb-0">
                            <button
                                class="bg-gray-200 text-gray-700 py-1 px-3 rounded-full text-sm focus:outline-none hover:bg-gray-300 transition-colors">Semua</button>
                            <button
                                class="bg-blue-500 text-white py-1 px-3 rounded-full text-sm focus:outline-none hover:bg-blue-600 transition-colors">Pengeluaran</button>
                            <button
                                class="bg-green-500 text-white py-1 px-3 rounded-full text-sm focus:outline-none hover:bg-green-600 transition-colors">Penghasilan</button>
                        </div>

                        <a href="{{ route('transaksi.pdf.all') }}"
                            class="bg-green-500 hover:bg-green-600 transition-colors text-white font-bold py-2 px-4 rounded flex items-center">
                            <i class="fas fa-file-pdf mr-2"></i> Cetak Semua Transaksi
                        </a>
                    </div>
                </div>

                <!-- Analytics Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
                    <div class="bg-white shadow-md rounded-lg p-4 md:p-6">
                        <h2 class="text-gray-700 font-semibold mb-4">Statistik Pengeluaran</h2>
                        <div class="h-64 flex items-center justify-center bg-gray-50 rounded-lg">
                            <div class="text-center text-gray-500">
                                <i class="fas fa-chart-pie text-4xl mb-2"></i>
                                <p>Grafik pengeluaran akan ditampilkan disini</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow-md rounded-lg p-4 md:p-6">
                        <h2 class="text-gray-700 font-semibold mb-4">Kategori Pengeluaran</h2>
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Makanan & Minuman</span>
                                    <span class="text-sm font-medium text-gray-700">45%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: 45%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Transportasi</span>
                                    <span class="text-sm font-medium text-gray-700">25%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-green-500 h-2.5 rounded-full" style="width: 25%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Belanja</span>
                                    <span class="text-sm font-medium text-gray-700">20%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-yellow-500 h-2.5 rounded-full" style="width: 20%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Hiburan</span>
                                    <span class="text-sm font-medium text-gray-700">10%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-pink-500 h-2.5 rounded-full" style="width: 10%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <main class="bg-gray-100 p-6 sm:p-8 md:p-10 lg:p-12">
                    <header class="mb-6 md:mb-8 lg:mb-10 flex items-center justify-between">
                        <h1 class="text-xl font-semibold text-gray-800">Ikhtisar transaksi</h1>
                        <div class="hidden md:flex items-center space-x-4">
                            <div class="relative">
                                <select
                                    class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:shadow-outline">
                                    <option>Rekening giro</option>
                                    <option>Tabungan</option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="text-sm text-green-500 flex items-center">
                                <i class="fas fa-arrow-up mr-1"></i> 2,36%
                            </div>
                        </div>
                    </header>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="bg-white shadow-md rounded-lg p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h2 class="text-gray-700 font-semibold text-sm">Keseimbangan</h2>
                                    <div class="text-2xl font-bold text-gray-800">Rp 10.000,00</div>
                                    <div class="text-sm text-gray-600">Tersedia Rp 8.000,00</div>
                                </div>
                                <div class="text-sm text-green-500 flex items-center md:hidden">
                                    <i class="fas fa-arrow-up mr-1"></i> 2,36%
                                </div>
                            </div>
                            <div class="flex space-x-4 text-sm">
                                <button
                                    class="bg-green-500 text-white py-2 px-4 rounded-md focus:outline-none focus:shadow-outline">
                                    <i class="fas fa-plus mr-2"></i> Penghasilan
                                    <span class="ml-1">Rp 30.000,00</span>
                                </button>
                                <button
                                    class="bg-red-500 text-white py-2 px-4 rounded-md focus:outline-none focus:shadow-outline">
                                    <i class="fas fa-minus mr-2"></i> Pengeluaran
                                    <span class="ml-1">Rp 20.000,00</span>
                                </button>
                            </div>
                        </div>

                        <div class="bg-white shadow-md rounded-lg p-6">
                            <h2 class="text-gray-700 font-semibold text-sm mb-4">Saldo Tersedia</h2>
                            <div class="bg-orange-100 rounded-lg p-4">
                                <div class="text-xl font-bold text-orange-700">Rp 10.000,00</div>
                                <div class="text-sm text-gray-600 mt-1">**** **** **** 0000</div>
                                <div class="text-xs text-gray-500 mt-2">Nicola Kaya</div>
                                <div class="text-xs text-gray-500">tanggal</div>
                            </div>
                        </div>

                        <div class="bg-white shadow-md rounded-lg p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-gray-700 font-semibold text-sm">Transaksi</h2>
                                <div class="relative">
                                    <input type="text" placeholder="Mencari"
                                        class="w-full md:w-auto bg-gray-100 border border-gray-300 rounded-md py-2 px-3 text-sm focus:outline-none focus:shadow-outline">
                                    <button class="absolute right-0 top-0 mt-1 mr-2 text-gray-500"><i
                                            class="fas fa-search"></i></button>
                                </div>
                            </div>
                            <div class="flex space-x-2 mb-4">
                                <button
                                    class="bg-gray-200 text-gray-700 py-1 px-3 rounded-full text-xs focus:outline-none">Semua</button>
                                <button
                                    class="bg-blue-500 text-white py-1 px-3 rounded-full text-xs focus:outline-none">Pengeluaran</button>
                                <button
                                    class="bg-green-500 text-white py-1 px-3 rounded-full text-xs focus:outline-none">Penghasilan</button>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="bg-teal-100 text-teal-500 rounded-full p-2 mr-3 text-xs">
                                            <i class="fas fa-store"></i>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-800 text-sm">Burger Tengah</div>
                                            <div class="text-xs text-gray-600">Kafe dan Restoran</div>
                                        </div>
                                    </div>
                                    <div class="text-red-500 font-semibold text-sm">-Rp 10.000,00</div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="bg-pink-100 text-pink-500 rounded-full p-2 mr-3 text-xs">
                                            <i class="fas fa-shopping-cart"></i>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-800 text-sm">Pasar</div>
                                            <div class="text-xs text-gray-600">Bahan makanan</div>
                                        </div>
                                    </div>
                                    <div class="text-red-500 font-semibold text-sm">-Rp 10.000,00</div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="bg-green-100 text-green-500 rounded-full p-2 mr-3 text-xs">
                                            <i class="fas fa-arrow-up"></i>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-800 text-sm">Transfer Cepat</div>
                                            <div class="text-xs text-gray-600">Maria Ungu</div>
                                        </div>
                                    </div>
                                    <div class="text-green-500 font-semibold text-sm">+Rp 10.000,00</div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="bg-pink-100 text-pink-500 rounded-full p-2 mr-3 text-xs">
                                            <i class="fas fa-shopping-cart"></i>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-800 text-sm">Pasar</div>
                                            <div class="text-xs text-gray-600">Bahan makanan</div>
                                        </div>
                                    </div>
                                    <div class="text-red-500 font-semibold text-sm">-Rp 10.000,00</div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white shadow-md rounded-lg p-6 col-span-1 md:col-span-2 lg:col-span-2">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-gray-700 font-semibold text-sm">Ikhtisar pengeluaran</h2>
                                <div class="flex items-center space-x-2">
                                    <button class="text-gray-500 hover:text-gray-700 focus:outline-none">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <span class="text-sm text-gray-600">Mingguan</span>
                                    <button class="text-gray-500 hover:text-gray-700 focus:outline-none">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="bg-gray-100 rounded h-48">
                            </div>
                        </div>
                    </div>
                </main>

                <!-- Footer -->
                <footer class="mt-8 text-center text-gray-500 text-sm py-4">
                    <p>© 2025 Plutus - Aplikasi Manajemen Keuangan</p>
                </footer>
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
