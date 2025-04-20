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

        <!-- Dashboard Content -->
        <div class="p-6">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                <div class="bg-white rounded-lg shadow-md p-6 flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500">Total Pengguna Admin</p>
                        <p class="text-2xl font-bold">{{ $TotalAkunAdmin }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 flex items-center">
                    <div class="p-3 rounded-full bg-orange-100 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500">Total Pengguna User</p>
                        <p class="text-2xl font-bold">{{ $TotalAkunUser }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500">Total Pengguna Bank</p>
                        <p class="text-2xl font-bold">{{ $TotalAkunBank }}</p>
                    </div>
                </div>
            </div>

            <!-- Account Management -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Kelola Akun</h2>
                    <button data-modal-target="createuser-modal" data-modal-toggle="createuser-modal"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Buat Akun Baru
                    </button>
                </div>

                <!-- Main modal -->
                <div id="createuser-modal" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
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
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
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
                                            <option value="admin">admin</option>
                                            <option value="bank">bank</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="password"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                            password</label>
                                        <input type="password" name="password" id="password" placeholder="••••••••"
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

                <!-- Search and Filter -->
                <div class="flex flex-wrap gap-4 mb-4">
                    <div class="flex-1 min-w-[300px]">
                        <div class="relative">
                            <form action="{{ route('adminSearch') }}" method="get">
                                <div class="flex p-2 relative items-center rounded bg-white border border-black">
                                    <input type="text" name="search" placeholder="Search Data"
                                        class="h-9 w-full rounded-full bg-transparent px-4 py-1 text-gray-900 outline-none focus:outline-none"
                                        value="{{ isset($search) ? $search : '' }}">
                                    <button type="submit" class="rounded-full bg-blue-600 mx-2 px-2 py-2 text-white">
                                        <svg class="w-4 text-white dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2"
                                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <select class="p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>Terbaru</option>
                            <option>Terlama</option>
                            <option>A-Z</option>
                            <option>Z-A</option>
                        </select>
                    </div>
                </div>

                <!-- Users Table -->
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-200 px-4 py-2 text-left">ID</th>
                                <th class="border border-gray-200 px-4 py-2 text-left">Nama</th>
                                <th class="border border-gray-200 px-4 py-2 text-left">Email</th>
                                <th class="border border-gray-200 px-4 py-2 text-left">role</th>
                                <th class="border border-gray-200 px-4 py-2 text-left">Saldo</th>
                                <th class="border border-gray-200 px-4 py-2 text-left">Tanggal Daftar</th>
                                <th class="border border-gray-200 px-4 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($SemuaAkun as $item)
                                <tr>
                                    <td class="border border-gray-200 px-4 py-2">{{ $item->id }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $item->name }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $item->email }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $item->usertype }}</td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $item->saldo->saldo ?? 'N/A' }}
                                    </td>
                                    <td class="border border-gray-200 px-4 py-2">{{ $item->created_at }}</td>
                                    <td class="border border-gray-200 px-4 py-2">
                                        <div class="flex justify-center space-x-2">
                                            <!-- Modal toggle -->
                                            <button data-modal-target="authentication-modal{{ $item->id }}"
                                                data-modal-toggle="authentication-modal{{ $item->id }}"
                                                class="bg-yellow-500 text-white p-1 rounded hover:bg-yellow-600"
                                                type="button">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>

                                            <!-- Main modal -->
                                            <div id="authentication-modal{{ $item->id }}" tabindex="-1"
                                                aria-hidden="true"
                                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                                <div class="relative p-4 w-full max-w-md max-h-full">
                                                    <!-- Modal content -->
                                                    <div
                                                        class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                                                        <!-- Modal header -->
                                                        <div
                                                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                                            <h3
                                                                class="text-xl font-semibold text-gray-900 dark:text-white">
                                                                Sign in to our platform
                                                            </h3>
                                                            <button type="button"
                                                                class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                                data-modal-hide="authentication-modal{{ $item->id }}">
                                                                <svg class="w-3 h-3" aria-hidden="true"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 14 14">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                                </svg>
                                                                <span class="sr-only">Close modal</span>
                                                            </button>
                                                        </div>
                                                        <!-- Modal body -->
                                                        <div class="p-4 md:p-5">
                                                            <form class="space-y-4"
                                                                action="{{ route('login-update', $item->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <div>
                                                                    <label for="name"
                                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                                        name</label>
                                                                    <input type="name" name="name"
                                                                        id="name" value="{{ $item->name }}"
                                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                                                        placeholder="name" required />
                                                                </div>
                                                                <div>
                                                                    <label for="email"
                                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                                        email</label>
                                                                    <input type="email" name="email"
                                                                        value="{{ $item->email }}" id="email"
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
                                                                        <option value="{{ $item->usertype }}">
                                                                            {{ $item->usertype }}</option>
                                                                        <option value="user">user</option>
                                                                        <option value="admin">admin</option>
                                                                        <option value="bank">bank</option>
                                                                    </select>
                                                                </div>
                                                                <div>
                                                                    <label for="password"
                                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                                                        password</label>
                                                                    <input type="password" name="password"
                                                                        id="password" placeholder="••••••••"
                                                                        value="{{ $item->password }}"
                                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                                                        required />
                                                                </div>
                                                                <button type="submit"
                                                                    class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Login
                                                                    Ganti</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <form action="{{ route('akun-delete', $item->id) }}" method="post">
                                                @csrf
                                                <button class="bg-red-500 text-white p-1 rounded hover:bg-red-600"
                                                    title="Hapus">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>




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
