<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk - POS System</title>
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
                        class="flex items-center px-4 py-3 bg-blue-100 text-blue-700 rounded-lg">
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
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-warehouse mr-3"></i>
                        Riwayat Stok
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
                    <h1 class="text-2xl font-bold text-gray-900">Manajemen Produk</h1>
                    <p class="text-gray-600">Kelola data produk dan inventori</p>
                </div>
                <a href="{{ route('admin.produk.create') }}" 
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>Tambah Produk
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <i class="fas fa-boxes text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Total Produk</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $produks->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 rounded-lg">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Produk Aktif</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $produks->where('is_active', true)->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-orange-100 rounded-lg">
                            <i class="fas fa-exclamation-triangle text-orange-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Stok Menipis</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $produks->where('stok_sekarang', '<', 10)->where('stok_sekarang', '>', 0)->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-red-100 rounded-lg">
                            <i class="fas fa-times-circle text-red-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Stok Habis</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $produks->where('stok_sekarang', '<=', 0)->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Table -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Daftar Produk</h2>
                </div>
                <div class="p-6">
                    @if($produks->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gambar</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Harga</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Stok</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($produks as $produk)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        <img src="{{ $produk->gambar_url }}" alt="{{ $produk->nama_produk }}" 
                                            class="w-12 h-12 rounded-lg object-cover">
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $produk->nama_produk }}</div>
                                        <div class="text-sm text-gray-500">{{ $produk->satuan }}</div>
                                        @if($produk->deskripsi)
                                        <div class="text-xs text-gray-400 mt-1">{{ Str::limit($produk->deskripsi, 50) }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        {{ $produk->kode_produk }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-sm font-medium text-gray-900">
                                        Rp {{ number_format($produk->harga_dasar, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="text-sm font-medium text-gray-900">{{ $produk->stok_sekarang }}</div>
                                        <div class="text-xs text-gray-500">awal: {{ $produk->stok_awal }}</div>
                                        @if($produk->stok_sekarang <= 0)
                                        <span class="inline-block px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full mt-1">
                                            Habis
                                        </span>
                                        @elseif($produk->stok_sekarang < 10)
                                        <span class="inline-block px-2 py-1 text-xs font-medium bg-orange-100 text-orange-800 rounded-full mt-1">
                                            Menipis
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-block px-2 py-1 text-xs font-medium rounded-full {{ $produk->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $produk->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('admin.produk.show', $produk->id) }}" 
                                                class="text-blue-600 hover:text-blue-900" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.produk.edit', $produk->id) }}" 
                                                class="text-green-600 hover:text-green-900" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.level-harga.show', $produk->id) }}" 
                                                class="text-purple-600 hover:text-purple-900" title="Level Harga">
                                                <i class="fas fa-tags"></i>
                                            </a>
                                            <a href="{{ route('admin.stok-barang.show', $produk->id) }}" 
                                                class="text-orange-600 hover:text-orange-900" title="Riwayat Stok">
                                                <i class="fas fa-history"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.produk.destroy', $produk->id) }}" 
                                                class="inline" onsubmit="return confirm('Hapus produk ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-8">
                        <i class="fas fa-boxes text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-500">Belum ada produk</p>
                        <a href="{{ route('admin.produk.create') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                            Tambah produk pertama
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Low Stock Warning -->
            @php
                $lowStockProducts = $produks->where('stok_sekarang', '<', 10)->where('stok_sekarang', '>', 0);
            @endphp
            @if($lowStockProducts->count() > 0)
            <div class="mt-6 bg-orange-50 border border-orange-200 rounded-lg p-4">
                <div class="flex">
                    <div class="shrink-0">
                        <i class="fas fa-exclamation-triangle text-orange-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-orange-800">Peringatan Stok Menipis</h3>
                        <div class="mt-2 text-sm text-orange-700">
                            <p>Produk berikut memiliki stok kurang dari 10:</p>
                            <ul class="list-disc list-inside mt-1">
                                @foreach($lowStockProducts as $product)
                                <li>{{ $product->nama_produk }} (Stok: {{ $product->stok_sekarang }})</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Out of Stock Warning -->
            @php
                $outOfStockProducts = $produks->where('stok_sekarang', '<=', 0);
            @endphp
            @if($outOfStockProducts->count() > 0)
            <div class="mt-4 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex">
                    <div class="shrink-0">
                        <i class="fas fa-times-circle text-red-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Peringatan Stok Habis</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <p>Produk berikut stoknya habis:</p>
                            <ul class="list-disc list-inside mt-1">
                                @foreach($outOfStockProducts as $product)
                                <li>{{ $product->nama_produk }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</body>
</html><!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk - POS System</title>
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
                        class="flex items-center px-4 py-3 bg-blue-100 text-blue-700 rounded-lg">
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
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
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
                    <h1 class="text-2xl font-bold text-gray-900">Manajemen Produk</h1>
                    <p class="text-gray-600">Kelola data produk dan inventori</p>
                </div>
                <a href="{{ route('admin.produk.create') }}" 
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>Tambah Produk
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <i class="fas fa-boxes text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Total Produk</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $produks->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 rounded-lg">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Produk Aktif</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $produks->where('is_active', true)->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-orange-100 rounded-lg">
                            <i class="fas fa-exclamation-triangle text-orange-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Stok Menipis</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $produks->where('stok_sekarang', '<', 10)->where('stok_sekarang', '>', 0)->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-red-100 rounded-lg">
                            <i class="fas fa-times-circle text-red-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Stok Habis</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $produks->where('stok_sekarang', '<=', 0)->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Table -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Daftar Produk</h2>
                </div>
                <div class="p-6">
                    @if($produks->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gambar</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Harga</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Stok</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($produks as $produk)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        <img src="{{ $produk->gambar_url }}" alt="{{ $produk->nama_produk }}" 
                                            class="w-12 h-12 rounded-lg object-cover">
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $produk->nama_produk }}</div>
                                        <div class="text-sm text-gray-500">{{ $produk->satuan }}</div>
                                        @if($produk->deskripsi)
                                        <div class="text-xs text-gray-400 mt-1">{{ Str::limit($produk->deskripsi, 50) }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        {{ $produk->kode_produk }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-sm font-medium text-gray-900">
                                        Rp {{ number_format($produk->harga_dasar, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="text-sm font-medium text-gray-900">{{ $produk->stok_sekarang }}</div>
                                        <div class="text-xs text-gray-500">awal: {{ $produk->stok_awal }}</div>
                                        @if($produk->stok_sekarang <= 0)
                                        <span class="inline-block px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full mt-1">
                                            Habis
                                        </span>
                                        @elseif($produk->stok_sekarang < 10)
                                        <span class="inline-block px-2 py-1 text-xs font-medium bg-orange-100 text-orange-800 rounded-full mt-1">
                                            Menipis
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-block px-2 py-1 text-xs font-medium rounded-full {{ $produk->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $produk->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('admin.produk.show', $produk->id) }}" 
                                                class="text-blue-600 hover:text-blue-900" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.produk.edit', $produk->id) }}" 
                                                class="text-green-600 hover:text-green-900" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.level-harga.show', $produk->id) }}" 
                                                class="text-purple-600 hover:text-purple-900" title="Level Harga">
                                                <i class="fas fa-tags"></i>
                                            </a>
                                            <a href="{{ route('admin.stok-barang.show', $produk->id) }}" 
                                                class="text-orange-600 hover:text-orange-900" title="Riwayat Stok">
                                                <i class="fas fa-history"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.produk.destroy', $produk->id) }}" 
                                                class="inline" onsubmit="return confirm('Hapus produk ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-8">
                        <i class="fas fa-boxes text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-500">Belum ada produk</p>
                        <a href="{{ route('admin.produk.create') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                            Tambah produk pertama
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Low Stock Warning -->
            @php
                $lowStockProducts = $produks->where('stok_sekarang', '<', 10)->where('stok_sekarang', '>', 0);
            @endphp
            @if($lowStockProducts->count() > 0)
            <div class="mt-6 bg-orange-50 border border-orange-200 rounded-lg p-4">
                <div class="flex">
                    <div class="shrink-0">
                        <i class="fas fa-exclamation-triangle text-orange-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-orange-800">Peringatan Stok Menipis</h3>
                        <div class="mt-2 text-sm text-orange-700">
                            <p>Produk berikut memiliki stok kurang dari 10:</p>
                            <ul class="list-disc list-inside mt-1">
                                @foreach($lowStockProducts as $product)
                                <li>{{ $product->nama_produk }} (Stok: {{ $product->stok_sekarang }})</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Out of Stock Warning -->
            @php
                $outOfStockProducts = $produks->where('stok_sekarang', '<=', 0);
            @endphp
            @if($outOfStockProducts->count() > 0)
            <div class="mt-4 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex">
                    <div class="shrink-0">
                        <i class="fas fa-times-circle text-red-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Peringatan Stok Habis</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <p>Produk berikut stoknya habis:</p>
                            <ul class="list-disc list-inside mt-1">
                                @foreach($outOfStockProducts as $product)
                                <li>{{ $product->nama_produk }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</body>
</html>