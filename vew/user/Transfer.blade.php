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

        .modal {
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .modal.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            transform: scale(0.95);
            transition: transform 0.3s ease;
        }

        .modal.active .modal-content {
            transform: scale(1);
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6B7280;
        }

        .input-with-icon {
            padding-left: 2.5rem;
        }

        /* Card hover effects */
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        /* Button effects */
        .btn-effect {
            transition: transform 0.2s ease;
        }

        .btn-effect:active {
            transform: scale(0.97);
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
                            class="flex items-center py-2 px-4 rounded text-gray-300 hover:bg-gray-700 hover:text-white">
                            <i class="fas fa-home mr-3"></i> Dasbor
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('user-transfer', ['user' => $user]) }}"
                            class="flex items-center py-2 px-4 rounded text-gray-300 hover:bg-gray-700 hover:text-white bg-gray-700 text-white">
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
                    <div class="flex items-center">
                        <div
                            class="bg-blue-500 text-white rounded-full w-10 h-10 flex items-center justify-center mr-3">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <div class="text-xl font-semibold text-gray-800">Dasbor {{ $user->name }}</div>
                            <div class="text-sm text-gray-500">Selamat datang kembali!</div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button onclick="openModalTransfer()"
                            class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg shadow flex items-center btn-effect">
                            <i class="fas fa-exchange-alt mr-2"></i> Transfer
                        </button>
                    </div>
                </header>

                <!-- Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-6">
                    <div class="bg-white shadow-md rounded-lg p-4 md:p-6 border-l-4 border-blue-500 card-hover">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-gray-700 font-semibold">Saldo Total</h2>
                            <div class="text-blue-500 bg-blue-100 p-2 rounded-full">
                                <i class="fas fa-wallet"></i>
                            </div>
                        </div>
                        <div class="text-2xl font-bold text-gray-800">Rp
                            {{ number_format($saldo_user->saldo, 0, ',', '.') }}</div>
                        <div class="text-sm text-gray-500 mt-2">Terakhir diperbarui: Hari ini</div>
                    </div>

                    <div class="bg-white shadow-md rounded-lg p-4 md:p-6 border-l-4 border-green-500 card-hover">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-gray-700 font-semibold">Penghasilan</h2>
                            <div class="text-green-500 bg-green-100 p-2 rounded-full">
                                <i class="fas fa-arrow-down"></i>
                            </div>
                        </div>
                        <div class="text-2xl font-bold text-gray-800">Rp {{ number_format($pemasukan, 0, ',', '.') }}
                        </div>
                        <div class="text-sm text-gray-500 mt-2">Bulan ini</div>
                    </div>

                    <div class="bg-white shadow-md rounded-lg p-4 md:p-6 border-l-4 border-red-500 card-hover">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-gray-700 font-semibold">Pengeluaran</h2>
                            <div class="text-red-500 bg-red-100 p-2 rounded-full">
                                <i class="fas fa-arrow-up"></i>
                            </div>
                        </div>
                        <div class="text-2xl font-bold text-gray-800">Rp {{ number_format($pengeluaran, 0, ',', '.') }}
                        </div>
                        <div class="text-sm text-gray-500 mt-2">Bulan ini</div>
                    </div>
                </div>

                <!-- Action Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-8">
                    <!-- Top Up Card -->
                    <div class="bg-white shadow-md rounded-lg overflow-hidden card-hover">
                        <div class="bg-blue-500 text-white py-3 px-4">
                            <h2 class="text-lg font-semibold flex items-center">
                                <i class="fas fa-plus-circle mr-2"></i> Top Up Dana
                            </h2>
                        </div>
                        <div class="p-4 md:p-6">
                            <form action="{{ route('masukkan-dana-user', $user->id) }}" method="POST">
                                @csrf
                                <div class="input-group mb-4">
                                    <i class="fas fa-money-bill input-icon"></i>
                                    <input type="number" id="top_up_form" name="top_up_form"
                                        class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500 input-with-icon"
                                        placeholder="Jumlah dana" required>
                                </div>

                                <button type="submit"
                                    class="w-full bg-blue-500 hover:bg-blue-600 text-white p-3 rounded-lg shadow-sm flex items-center justify-center btn-effect">
                                    <i class="fas fa-save mr-2"></i> Top Up Sekarang
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Withdraw Card -->
                    <div class="bg-white shadow-md rounded-lg overflow-hidden card-hover">
                        <div class="bg-red-500 text-white py-3 px-4">
                            <h2 class="text-lg font-semibold flex items-center">
                                <i class="fas fa-money-bill-wave mr-2"></i> Tarik Dana
                            </h2>
                        </div>
                        <div class="p-4 md:p-6">
                            <p class="text-gray-600 mb-4">Tarik dana Anda dengan aman ke rekening bank pilihan Anda</p>
                            <button onclick="openModal()"
                                class="w-full bg-red-500 hover:bg-red-600 text-white p-3 rounded-lg shadow-sm flex items-center justify-center btn-effect">
                                <i class="fas fa-cash-register mr-2"></i> Tarik Dana
                            </button>
                        </div>
                    </div>

                    <!-- Transfer Card -->
                    <div class="bg-white shadow-md rounded-lg overflow-hidden card-hover">
                        <div class="bg-indigo-500 text-white py-3 px-4">
                            <h2 class="text-lg font-semibold flex items-center">
                                <i class="fas fa-exchange-alt mr-2"></i> Transfer
                            </h2>
                        </div>
                        <div class="p-4 md:p-6">
                            <p class="text-gray-600 mb-4">Kirim uang dengan cepat dan mudah ke teman atau keluarga</p>
                            <button onclick="openModalTransfer()"
                                class="w-full bg-indigo-500 hover:bg-indigo-600 text-white p-3 rounded-lg shadow-sm flex items-center justify-center btn-effect">
                                <i class="fas fa-paper-plane mr-2"></i> Transfer Dana
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Transfer Dana Modal -->
    <div id="transferModal"
        class="modal fixed inset-0 bg-gray-900 bg-opacity-60 flex justify-center items-center z-50">
        <div class="modal-content bg-white p-6 rounded-xl w-full max-w-md mx-4 shadow-xl">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-exchange-alt text-blue-500 mr-2"></i> Transfer Dana
                </h2>
                <button type="button" onclick="closeModalTransfer()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{ route('transfer-dana-user', $user->id) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="namateman">
                            <i class="fas fa-user mr-2 text-blue-500"></i> Pilih Penerima
                        </label>
                        <select id="namateman" name="namateman"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white"
                            required>
                            <option value="">-- Pilih Teman --</option>
                            @foreach ($teman as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="transfer">
                            <i class="fas fa-money-bill-wave mr-2 text-blue-500"></i> Jumlah Transfer
                        </label>
                        <div class="input-group">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                            <input type="number" id="transfer" name="transfer"
                                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 pl-8"
                                placeholder="0" required>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Saldo Anda: Rp
                            {{ number_format($total_saldo, 0, ',', '.') }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="deskripsi">
                            <i class="fas fa-align-left mr-2 text-blue-500"></i> Deskripsi
                        </label>
                        <input type="text" id="deskripsi" name="deskripsi"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Contoh: Bayar makan siang" required>
                    </div>

                    <div class="pt-4">
                        <div class="flex space-x-3">
                            <button type="button" onclick="closeModalTransfer()"
                                class="flex-1 bg-gray-200 text-gray-800 py-3 px-4 rounded-lg hover:bg-gray-300 transition-all btn-effect">
                                Batal
                            </button>
                            <button type="submit"
                                class="flex-1 bg-blue-500 text-white py-3 px-4 rounded-lg hover:bg-blue-600 transition-all flex items-center justify-center btn-effect">
                                <i class="fas fa-paper-plane mr-2"></i> Kirim
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Ambil Uang Modal -->
    <div id="ambilModal" class="modal fixed inset-0 bg-gray-900 bg-opacity-60 flex justify-center items-center z-50">
        <div class="modal-content bg-white p-6 rounded-xl w-full max-w-md mx-4 shadow-xl">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-money-bill-wave text-red-500 mr-2"></i> Tarik Dana
                </h2>
                <button type="button" onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{ route('ambiluang-dana-user', $user->id) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="withdraw">
                            <i class="fas fa-money-bill mr-2 text-red-500"></i> Jumlah Penarikan
                        </label>
                        <div class="input-group">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                            <input type="number" id="withdraw" name="withdraw"
                                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 pl-8"
                                placeholder="0" required>
                        </div>
                        <p class="text-gray-600">Saldo Anda: Rp {{ number_format($saldo_user->saldo, 0, ',', '.') }}</p>
                    </div>

                    <div class="pt-4">
                        <div class="flex space-x-3">
                            <button type="button" onclick="closeModal()"
                                class="flex-1 bg-gray-200 text-gray-800 py-3 px-4 rounded-lg hover:bg-gray-300 transition-all btn-effect">
                                Batal
                            </button>
                            <button type="submit"
                                class="flex-1 bg-red-500 text-white py-3 px-4 rounded-lg hover:bg-red-600 transition-all flex items-center justify-center btn-effect">
                                <i class="fas fa-check-circle mr-2"></i> Tarik Dana
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
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

        // Modal functions
        function openModal() {
            document.getElementById('ambilModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('ambilModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        function openModalTransfer() {
            document.getElementById('transferModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModalTransfer() {
            document.getElementById('transferModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Format currency input
        const currencyInputs = document.querySelectorAll('#transfer, #withdraw, #top_up_form');
        currencyInputs.forEach(input => {
            input.addEventListener('blur', function(e) {
                if (this.value) {
                    // Your formatting logic here if needed
                }
            });
        });

        // Close modals when clicking outside
        window.addEventListener('click', function(event) {
            const transferModal = document.getElementById('transferModal');
            const ambilModal = document.getElementById('ambilModal');

            if (event.target === transferModal) {
                closeModalTransfer();
            }

            if (event.target === ambilModal) {
                closeModal();
            }
        });
    </script>
</body>

</html>
