<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - POS System</title>
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
                        class="flex items-center px-4 py-3 bg-blue-100 text-blue-700 rounded-lg">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.produk.index') }}" 
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-box mr-3"></i>
                        Manajemen Produk
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
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Transaksi Hari Ini</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_transaksi_hari_ini'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 rounded-lg">
                            <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Pendapatan Hari Ini</p>
                            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($stats['total_pendapatan_hari_ini'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-100 rounded-lg">
                            <i class="fas fa-boxes text-purple-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Total Produk</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_produk'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-orange-100 rounded-lg">
                            <i class="fas fa-users text-orange-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Total Pelanggan</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_pelanggan'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions and Best Selling Products -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Transactions -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Transaksi Terbaru</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($transaksi_terbaru as $transaksi)
                            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $transaksi->kode_transaksi }}</p>
                                    <p class="text-sm text-gray-500">
                                        {{ $transaksi->pelanggan->nama ?? 'Umum' }} • 
                                        Rp {{ number_format($transaksi->total_amount, 0, ',', '.') }}
                                    </p>
                                </div>
                                <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">
                                    {{ $transaksi->metode_pembayaran }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Best Selling Products -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Produk Terlaris Hari Ini</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($produk_terlaris as $produk)
                            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                <div class="flex items-center">
                                    <img src="{{ $produk->gambar_url }}" alt="{{ $produk->nama_produk }}" 
                                        class="w-10 h-10 rounded-lg object-cover">
                                    <div class="ml-4">
                                        <p class="font-medium text-gray-900">{{ $produk->nama_produk }}</p>
                                        <p class="text-sm text-gray-500">Terjual: {{ $produk->total_terjual ?? 0 }}</p>
                                    </div>
                                </div>
                                <span class="text-sm font-medium text-gray-900">
                                    Rp {{ number_format($produk->harga_dasar, 0, ',', '.') }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>