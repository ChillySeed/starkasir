<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Stok - POS System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-cash-register text-2xl"></i>
                    <span class="text-xl font-bold">POS System - Admin</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span>Halo, {{ auth()->user()->nama }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-blue-700 hover:bg-blue-800 px-4 py-2 rounded-lg">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar and Main Content -->
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg min-h-screen">
            <nav class="mt-6">
                <div class="px-4 space-y-2">
                    <a href="{{ route('admin.dashboard') }}" 
                        class="flex items-center px-4 py-3 bg-blue-100 text-blue-700 rounded-lg">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.produk.index') }}" 
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-box mr-3"></i>
                        Manajemen Produk
                    </a>
                    <a href="{{ route('admin.stok-barang.index') }}" 
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-warehouse mr-3"></i>
                        Riwayat Stok
                    </a>
                    <a href="{{ route('admin.level-harga.index') }}" 
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-tags mr-3"></i>
                        Level Harga
                    </a>
                    <a href="{{ route('admin.golongan.index') }}" 
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-users mr-3"></i>
                        Golongan Member
                    </a>
                    <a href="{{ route('admin.pelanggan.index') }}" 
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-user-friends mr-3"></i>
                        Data Pelanggan
                    </a>
                    <a href="#" 
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-chart-bar mr-3"></i>
                        Laporan
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Riwayat Perubahan Stok</h1>
                    <p class="text-gray-600">Monitor semua perubahan stok barang</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.stok-barang.export', request()->query()) }}" 
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-file-export mr-2"></i>Export
                    </a>
                    <a href="{{ route('admin.stok-barang.create-adjustment') }}" 
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-edit mr-2"></i>Adjustment Stok
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Filter Section -->
            <div class="bg-white rounded-lg shadow mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Filter Data</h2>
                </div>
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.stok-barang.index') }}">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" 
                                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                                <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" 
                                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Produk</label>
                                <select name="produk_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Semua Produk</option>
                                    @foreach($produks as $produk)
                                    <option value="{{ $produk->id }}" {{ request('produk_id') == $produk->id ? 'selected' : '' }}>
                                        {{ $produk->nama_produk }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Perubahan</label>
                                <select name="jenis_perubahan" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Semua Jenis</option>
                                    @foreach($jenisPerubahan as $jenis)
                                    <option value="{{ $jenis }}" {{ request('jenis_perubahan') == $jenis ? 'selected' : '' }}>
                                        {{ ucfirst($jenis) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mt-4 flex space-x-3">
                            <button type="submit" 
                                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
                                <i class="fas fa-filter mr-2"></i>Terapkan Filter
                            </button>
                            <a href="{{ route('admin.stok-barang.index') }}" 
                                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-colors">
                                <i class="fas fa-refresh mr-2"></i>Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Stock Movements Table -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Riwayat Perubahan Stok</h2>
                </div>
                <div class="p-6">
                    @if($stokBarangs->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
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
                                        <div class="text-sm font-medium text-gray-900">{{ $stok->produk->nama_produk }}</div>
                                        <div class="text-sm text-gray-500">{{ $stok->produk->kode_produk }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
                                            $badgeColors = [
                                                'penjualan' => 'bg-red-100 text-red-800',
                                                'pembelian' => 'bg-green-100 text-green-800',
                                                'adjustment' => 'bg-blue-100 text-blue-800',
                                                'retur' => 'bg-yellow-100 text-yellow-800',
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
                    <div class="text-center py-8">
                        <i class="fas fa-warehouse text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-500">Tidak ada data perubahan stok</p>
                        <p class="text-sm text-gray-400 mt-1">Coba ubah filter atau periode waktu</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Summary Cards -->
            @if($stokBarangs->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 rounded-lg">
                            <i class="fas fa-arrow-down text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Total Barang Masuk</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ $stokBarangs->sum('qty_masuk') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-red-100 rounded-lg">
                            <i class="fas fa-arrow-up text-red-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Total Barang Keluar</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ $stokBarangs->sum('qty_keluar') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <i class="fas fa-exchange-alt text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Total Transaksi Stok</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ $stokBarangs->count() }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</body>
</html>