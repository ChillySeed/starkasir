<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Stok {{ $produk->nama_produk }} - POS System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.produk.index') }}" 
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-box mr-3"></i>
                        Manajemen Produk
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
                    <a href="{{ route('admin.stok-barang.index') }}" 
                        class="flex items-center px-4 py-3 bg-blue-100 text-blue-700 rounded-lg">
                        <i class="fas fa-warehouse mr-3"></i>
                        Riwayat Stok
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Riwayat Stok</h1>
                    <p class="text-gray-600">{{ $produk->nama_produk }} - {{ $produk->kode_produk }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.stok-barang.index') }}" 
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <a href="{{ route('admin.stok-barang.create-adjustment') }}" 
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-edit mr-2"></i>Adjustment Stok
                    </a>
                </div>
            </div>

            <!-- Product Summary -->
            <div class="bg-white rounded-lg shadow mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <img src="{{ $produk->gambar_url }}" alt="{{ $produk->nama_produk }}" 
                                class="w-16 h-16 rounded-lg object-cover">
                            <div>
                                <h2 class="text-xl font-bold text-gray-900">{{ $produk->nama_produk }}</h2>
                                <p class="text-gray-600">{{ $produk->kode_produk }} • {{ $produk->satuan }}</p>
                                <p class="text-sm text-gray-500">{{ $produk->deskripsi }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-blue-600">{{ $produk->stok_sekarang }}</p>
                            <p class="text-sm text-gray-500">Stok Saat Ini</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stock Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-green-50 rounded-lg p-6 border border-green-200">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 rounded-lg">
                            <i class="fas fa-arrow-down text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-green-600">Total Barang Masuk</p>
                            <p class="text-2xl font-bold text-green-700">{{ $totalMasuk }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-red-50 rounded-lg p-6 border border-red-200">
                    <div class="flex items-center">
                        <div class="p-3 bg-red-100 rounded-lg">
                            <i class="fas fa-arrow-up text-red-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-red-600">Total Barang Keluar</p>
                            <p class="text-2xl font-bold text-red-700">{{ $totalKeluar }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-blue-50 rounded-lg p-6 border border-blue-200">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <i class="fas fa-exchange-alt text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-blue-600">Total Transaksi</p>
                            <p class="text-2xl font-bold text-blue-700">{{ $stokBarangs->total() }}</p>
                        </div>
                    </div>
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
                        <p class="text-gray-500">Tidak ada data perubahan stok untuk produk ini</p>
                        <p class="text-sm text-gray-400 mt-1">Coba ubah periode waktu</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>