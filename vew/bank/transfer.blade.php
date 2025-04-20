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
                        <a href="{{ route('bank-home', ['user' => $user]) }}"
                            class="flex items-center py-2 px-4 rounded text-gray-300 hover:bg-gray-700 hover:text-white">
                            <i class="fas fa-home mr-3"></i> Dasbor
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('bank-transfer', ['user' => $user]) }}"
                            class="flex items-center py-2 px-4 rounded text-gray-300 hover:bg-gray-700 hover:text-white bg-gray-700 text-white">
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

        <!-- Content Area -->
        <main class="flex-1 p-8">
            <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
                <h1 class="text-xl font-bold mb-4">Transfer Dana</h1>
                <button onclick="openModalTransfer()" class="w-full bg-blue-600 text-white p-3 rounded mb-4">Transfer
                    Dana</button>
                <button onclick="openModalWithdraw()" class="w-full bg-red-600 text-white p-3 rounded">Tarik
                    Dana</button>
            </div>
        </main>

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
                    <button data-modal-target="createuser-modal" data-modal-toggle="createuser-modal"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded flex items-center">
                        <i class="fas fa-user-plus mr-1"></i> Tambah
                    </button>
                </div>
            </div>
            <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID</th>
                        <th
                            class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pengguna</th>
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
                            Tanggal Daftar</th>
                        <th
                            class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($SemuaAkun as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-200 px-4 py-3 text-sm text-gray-600">
                                {{ $item->id }}</td>
                            <td class="border border-gray-200 px-4 py-3">
                                <div class="flex items-center">
                                    <div class="font-semibold text-gray-800">{{ $item->name }}</div>
                                </div>
                            </td>
                            <td class="border border-gray-200 px-4 py-3 text-sm text-gray-600">
                                {{ $item->email }}</td>
                            <td class="border border-gray-200 px-4 py-3">
                                <span
                                    class="bg-gray-100 text-gray-600 py-1 px-2 rounded-full text-xs">{{ $item->usertype }}</span>
                            </td>
                            <td class="border border-gray-200 px-4 py-3 font-semibold">
                                {{ $item->saldo ? $item->saldo->saldo : 0 }}
                            </td>
                            <td class="border border-gray-200 px-4 py-3 text-sm text-gray-600">
                                {{ $item->created_at }}</td>
                            <td class="border border-gray-200 px-4 py-3">
                                <div class="flex space-x-2">
                                    <button data-modal-target="userModal"
                                        class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-1 px-2 rounded text-xs flex items-center">
                                        <i class="fas fa-info-circle mr-1"></i> Detail
                                    </button>
                                    <button
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-1 px-2 rounded text-xs flex items-center">
                                        <i class="fas fa-money-bill-wave mr-1"></i> Top Up
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
    

    <!-- Modal Transfer -->
    <div id="transferModal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white w-full max-w-md p-6 rounded shadow">
            <h2 class="text-lg font-bold mb-4">Form Transfer Dana</h2>
            <form action="{{ route('transfer-dana-bank') }}" method="POST">
                @csrf
                <label class="block mb-2">Pilih Penerima</label>
                <select name="namateman" required class="w-full mb-4 p-2 border rounded">
                    <option value="">--Pilih--</option>
                    @foreach ($teman as $t)
                        <option value="{{ $t->name }}">{{ $t->name }}</option>
                    @endforeach
                </select>
                <label class="block mb-2">Jumlah</label>
                <input type="number" name="transfer" class="w-full mb-4 p-2 border rounded" required>
                <label class="block mb-2">Deskripsi</label>
                <textarea name="deskripsi" class="w-full mb-4 p-2 border rounded" required></textarea>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModalTransfer()"
                        class="bg-gray-300 px-4 py-2 rounded">Batal</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Kirim</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Withdraw -->
    <div id="withdrawModal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white w-full max-w-md p-6 rounded shadow">
            <h2 class="text-lg font-bold mb-4">Form Tarik Dana</h2>
            <form action="{{ route('keluarkan-dana-bank') }}" method="POST">
                @csrf
                <label class="block mb-2">Pilih User</label>
                <select name="nama_user" required class="w-full mb-4 p-2 border rounded">
                    <option value="">--Pilih--</option>
                    @foreach ($teman as $t)
                        <option value="{{ $t->name }}">{{ $t->name }}</option>
                    @endforeach
                </select>
                <label class="block mb-2">Jumlah</label>
                <input type="number" name="jumlah_withdraw" class="w-full mb-4 p-2 border rounded" required>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModalWithdraw()"
                        class="bg-gray-300 px-4 py-2 rounded">Batal</button>
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Tarik</button>
                </div>
            </form>
        </div>
    </div>
        
    </body>



    <script>
        function openModalTransfer() {
            document.getElementById('transferModal').classList.add('active');
        }

        function closeModalTransfer() {
            document.getElementById('transferModal').classList.remove('active');
        }

        function openModalWithdraw() {
            document.getElementById('withdrawModal').classList.add('active');
        }

        function closeModalWithdraw() {
            document.getElementById('withdrawModal').classList.remove('active');
        }

        // Close modals on outside click
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                closeModalTransfer();
                closeModalWithdraw();
            }
        };
    </script>

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
