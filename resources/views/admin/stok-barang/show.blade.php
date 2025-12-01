<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Stok {{ $produk->nama_produk }} - POS System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F3F4F6;
        }
    </style>
</head>
<body class="text-gray-800">
    <!-- Navigation -->
    <nav class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-center py-3">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/starlogo.png') }}" alt="Logo" class="h-10 w-auto">
                    <div class="w-px h-8 bg-gray-300"></div>
                    <h1 class="text-xl font-bold text-gray-900">Riwayat Stok</h1>
                </div>
                <div class="flex items-center gap-4">
                    <div class="relative" id="userDropdown">
                        <button class="flex items-center gap-0 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
                            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->nama }}&background=FCD34D&color=1F2937" class="w-9 h-9 rounded-l-lg">
                            <div class="px-3 py-1.5 flex items-center gap-2">
                                <span class="text-sm font-medium text-gray-700">{{ auth()->user()->nama }}</span>
                                <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                            </div>
                        </button>
                        
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 hidden z-50" id="dropdownMenu">
                            <div class="py-1">
                                <div class="px-4 py-2 border-b border-gray-100">
                                    <p class="text-xs text-gray-500">Signed in as</p>
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ auth()->user()->nama }}</p>
                                </div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2">
                                        <i class="fas fa-sign-out-alt"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar and Main Content -->
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-sm min-h-screen border-r border-gray-200">
            <nav class="mt-6">
                <div class="px-4 space-y-2">
                    <a href="{{ route('admin.dashboard') }}" 
                        class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                        <i class="fas fa-tachometer-alt mr-3 w-5"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.produk.index') }}" 
                        class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                        <i class="fas fa-box mr-3 w-5"></i>
                        Manajemen Produk
                    </a>
                    <a href="{{ route('admin.stok-barang.index') }}" 
                        class="flex items-center px-4 py-3 bg-yellow-50 text-yellow-700 rounded-lg font-medium border border-yellow-200">
                        <i class="fas fa-warehouse mr-3 w-5 text-yellow-600"></i>
                        Riwayat Stok
                    </a>
                    <a href="{{ route('admin.level-harga.index') }}" 
                        class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                        <i class="fas fa-tags mr-3 w-5"></i>
                        Level Harga
                    </a>
                    <a href="{{ route('admin.golongan.index') }}" 
                        class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                        <i class="fas fa-users mr-3 w-5"></i>
                        Golongan Member
                    </a>
                    <a href="{{ route('admin.pelanggan.index') }}" 
                        class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                        <i class="fas fa-user-friends mr-3 w-5"></i>
                        Data Pelanggan
                    </a>
                    <a href="{{ route('admin.laporan.index') }}" 
                        class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                        <i class="fas fa-chart-bar mr-3 w-5"></i>
                        Laporan
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Riwayat Stok</h2>
                    <p class="text-gray-600 mt-1">{{ $produk->nama_produk }} - {{ $produk->kode_produk }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.stok-barang.index') }}" 
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i>Kembali
                    </a>
                    <a href="{{ route('admin.stok-barang.create-adjustment') }}" 
                        class="bg-yellow-500 text-gray-900 px-4 py-2 rounded-lg hover:bg-yellow-600 transition-colors flex items-center gap-2 font-medium">
                        <i class="fas fa-edit"></i>Adjustment Stok
                    </a>
                </div>
            </div>

            <!-- Product Summary -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <img src="{{ $produk->gambar_url }}" alt="{{ $produk->nama_produk }}" 
                                class="w-16 h-16 rounded-lg object-cover border border-gray-200">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">{{ $produk->nama_produk }}</h3>
                                <p class="text-gray-600">{{ $produk->kode_produk }} • {{ $produk->satuan }}</p>
                                <p class="text-sm text-gray-500">{{ $produk->deskripsi }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-yellow-600">{{ $produk->stok_sekarang }}</p>
                            <p class="text-sm text-gray-500">Stok Saat Ini</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stock Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-arrow-down text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Total Barang Masuk</p>
                            <p class="text-2xl font-bold text-green-700">{{ $totalMasuk }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-red-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-arrow-up text-red-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Total Barang Keluar</p>
                            <p class="text-2xl font-bold text-red-700">{{ $totalKeluar }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-yellow-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-exchange-alt text-yellow-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Total Transaksi</p>
                            <p class="text-2xl font-bold text-yellow-700">{{ $stokBarangs->total() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stock Movements Table -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-base font-semibold text-gray-900">Riwayat Perubahan Stok</h3>
                </div>
                <div class="p-6">
                    @if($stokBarangs->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Stok Awal</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Masuk</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Keluar</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Stok Akhir</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($stokBarangs as $stok)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        {{ $stok->tanggal_perubahan->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
                                            $badgeColors = [
                                                'penjualan' => 'bg-red-100 text-red-800',
                                                'pembelian' => 'bg-green-100 text-green-800',
                                                'adjustment' => 'bg-yellow-100 text-yellow-800',
                                                'retur' => 'bg-orange-100 text-orange-800',
                                            ];
                                        @endphp
                                        <span class="inline-block px-2 py-1 text-xs font-medium rounded-full {{ $badgeColors[$stok->jenis_perubahan] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($stok->jenis_perubahan) }}
                                        </span>
                                        @if($stok->transaksi)
                                        <div class="text-xs text-gray-500 mt-1">
                                            {{ $stok->transaksi->kode_transaksi }}
                                        </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-right text-sm font-medium text-gray-900">
                                        {{ $stok->qty_awal }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-sm font-medium text-green-600">
                                        @if($stok->qty_masuk > 0)
                                        +{{ $stok->qty_masuk }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-right text-sm font-medium text-red-600">
                                        @if($stok->qty_keluar > 0)
                                        -{{ $stok->qty_keluar }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-right text-sm font-medium text-gray-900">
                                        {{ $stok->qty_akhir }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-500 max-w-xs">
                                        {{ $stok->keterangan }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $stokBarangs->links() }}
                    </div>
                    @else
                    <div class="text-center py-12">
                        <i class="fas fa-warehouse text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500 mb-1">Tidak ada data perubahan stok untuk produk ini</p>
                        <p class="text-sm text-gray-400">Coba ubah periode waktu</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // User Dropdown Toggle
        const userDropdownBtn = document.querySelector('#userDropdown button');
        const dropdownMenu = document.getElementById('dropdownMenu');
        
        userDropdownBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdownMenu.classList.toggle('hidden');
        });
        
        document.addEventListener('click', function(e) {
            if (!document.getElementById('userDropdown').contains(e.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>