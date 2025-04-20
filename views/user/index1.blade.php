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

    <!-- Saldo Section -->
    <div class="bg-white shadow-md w-full p-4 mb-6">
        <div class="container mx-auto">
            <h2 class="text-lg font-semibold text-gray-700">Saldo Tersisa:</h2>
            @foreach ($saldo as $item)
                <p class="text-2xl font-bold text-green-500">Rp.{{ $item->saldo }}</p>
                <p class="text-2xl font-bold text-red-500">name {{ $item->user->name }}</p>
                <p class="text-2xl font-bold text-red-500">name {{ $item->user->usertype }}</p>
            @endforeach
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto p-6">
        <!-- Forms Section -->
        <div class="grid md:grid-cols-2 gap-6 mb-8">
            <!-- Masukkan Dana Form -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold mb-4">Masukkan Dana</h2>
                <form action="{{ route('masukkan-dana-user', $user->id) }}" method="POST">
                    @csrf
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="top_up_form">Jumlah Dana</label>
                    <input type="number" id="top_up_form" name="top_up_form"
                        class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Masukkan jumlah dana" required>

                    <button type="submit"
                        class="mt-4 w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Simpan</button>
                </form>
            </div>

            <!-- Ambil Uang Modal Trigger -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold mb-4">Ambil Uang</h2>
                <button onclick="openModal()" class="w-full bg-red-500 text-white p-2 rounded hover:bg-red-600">Buka
                    Form Ambil Uang</button>
            </div>
        </div>

        <!-- Transfer Dana Button -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <h2 class="text-lg font-semibold mb-4">Transfer Dana</h2>
            <button onclick="openModalTransfer()"
                class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Transfer Dana</button>
        </div>

        <!-- History Section -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold mb-4">Riwayat Transaksi</h2>
            <table class="w-full border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-200 px-4 py-2">Tanggal</th>
                        <th class="border border-gray-200 px-4 py-2">Tipe</th>
                        <th class="border border-gray-200 px-4 py-2">Deskripsi</th>
                        <th class="border border-gray-200 px-4 py-2">Status</th>
                        <th class="border border-gray-200 px-4 py-2">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($saldo_transaksi as $item)
                        <tr>
                            <td class="border border-gray-200 px-4 py-2">{{ $item->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="border border-gray-200 px-4 py-2">
                                @if ($item->type == 'top_up')
                                    <span class="text-green-500">Masukkan Dana</span>
                                @elseif ($item->type == 'withdraw')
                                    <span class="text-red-500">Dana Keluar</span>
                                @elseif ($item->type == 'transfer')
                                    <span class="text-blue-500">Transfer</span>
                                @endif
                            </td>
                            <td class="border border-gray-200 px-4 py-2">
                                @if (isset($item->detail_message))
                                    <span>{{ $item->detail_message }}</span>
                                @else
                                    <span>{{ $item->deskripsi }}</span>
                                @endif
                            </td>
                            <td class="border border-gray-200 px-4 py-2">
                                @if ($item->confirmed == 'sukses')
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded">Sukses</span>
                                @elseif ($item->confirmed == 'pending')
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Pending</span>
                                @elseif ($item->confirmed == 'tolak')
                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded">Ditolak</span>
                                @endif
                            </td>
                            <td
                                class="border border-gray-200 px-4 py-2 
            @if ($item->type == 'withdraw') text-red-500
            @else
                text-green-500 @endif">
                                Rp. {{ number_format($item->amount, 0, ',', '.') }}
                            </td>
                            <td class="border border-gray-200 px-4 py-2">
                                <a href="{{ route('transaksi.pdf.single', $item->id) }}"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-xs">
                                    <i class="fas fa-file-pdf"></i> PDF
                                </a>
                            </td>
                        </tr>
                    @endforeach

                    <!-- Tombol untuk mencetak semua transaksi -->
                    <div class="mt-4">
                        <a href="{{ route('transaksi.pdf.all') }}"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-file-pdf"></i> Cetak Semua Transaksi
                        </a>
                    </div>
                </tbody>
            </table>
        </div>
    </div>


    <!-- Ambil Uang Modal -->
    <div id="ambilModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-lg w-96">
            <h2 class="text-lg font-semibold mb-4">Ambil Uang</h2>
            <form action="{{ route('ambiluang-dana-user', $user->id) }}" method="POST">
                @csrf
                <label class="block text-sm font-medium text-gray-700 mb-2" for="withdraw">Jumlah Uang</label>
                <input type="number" id="withdraw" name="withdraw"
                    class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-red-500"
                    placeholder="Masukkan jumlah uang" required>
                <div class="mt-4 flex justify-between">
                    <button type="button" onclick="closeModal()"
                        class="bg-gray-300 text-gray-700 p-2 rounded hover:bg-gray-400">Batal</button>
                    <button type="submit" class="bg-red-500 text-white p-2 rounded hover:bg-red-600">Ambil</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Transfer Dana Modal -->
    <div id="transferModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-lg w-96">
            <h2 class="text-lg font-semibold mb-4">Transfer Dana</h2>
            <form action="{{ route('transfer-dana-user', $user->id) }}" method="POST">
                @csrf
                <label class="block text-sm font-medium text-gray-700 mb-2" for="namateman">Pilih Teman</label>
                <select id="namateman" name="namateman"
                    class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">-- Pilih Teman --</option>
                    @foreach ($teman as $item)
                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                    @endforeach
                </select>

                <label class="block text-sm font-medium text-gray-700 mt-4 mb-2" for="transfer">Jumlah Dana</label>
                <input type="number" id="transfer" name="transfer"
                    class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Masukkan jumlah dana" required>

                <label class="block text-sm font-medium text-gray-700 mt-4 mb-2" for="deskripsi">Deskripsi</label>
                <input type="text" id="deskripsi" name="deskripsi"
                    class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Masukkan deskripsi" required>

                <div class="mt-4 flex justify-between">
                    <button type="button" onclick="closeModalTransfer()"
                        class="bg-gray-300 text-gray-700 p-2 rounded hover:bg-gray-400">Batal</button>
                    <button type="submit"
                        class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Transfer</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('ambilModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('ambilModal').classList.add('hidden');
        }

        function openModalTransfer() {
            document.getElementById('transferModal').classList.remove('hidden');
        }

        function closeModalTransfer() {
            document.getElementById('transferModal').classList.add('hidden');
        }
    </script>
</body>

</html>
