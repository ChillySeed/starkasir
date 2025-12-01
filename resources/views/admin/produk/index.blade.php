<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk - POS System</title>
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
                    <h1 class="text-xl font-bold text-gray-900">Manajemen Produk</h1>
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
                        class="flex items-center px-4 py-3 bg-yellow-50 text-yellow-700 rounded-lg font-medium border border-yellow-200">
                        <i class="fas fa-box mr-3 w-5 text-yellow-600"></i>
                        Manajemen Produk
                    </a>
                    <a href="{{ route('admin.stok-barang.index') }}" 
                        class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                        <i class="fas fa-warehouse mr-3 w-5"></i>
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
                    <h2 class="text-2xl font-bold text-gray-900">Kelola Produk</h2>
                    <p class="text-gray-600 mt-1">Kelola data produk dan inventori Anda</p>
                </div>
                <a href="{{ route('admin.produk.create') }}" 
                    class="bg-yellow-500 text-gray-900 px-4 py-2 rounded-lg hover:bg-yellow-600 transition-colors flex items-center gap-2 font-medium">
                    <i class="fas fa-plus"></i>Tambah Produk
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 flex items-center gap-2">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Alerts Section - Moved to Top -->
            <div class="space-y-4 mb-6">
                @if($lowStockProducts->count() > 0)
                <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="shrink-0">
                            <i class="fas fa-exclamation-triangle text-orange-600 text-lg"></i>
                        </div>
                        <div class="ml-3 flex-1">
                            <h3 class="text-sm font-medium text-orange-800">
                                ⚠️ Peringatan Stok Menipis ({{ $lowStockProducts->count() }} produk)
                            </h3>
                            <div class="mt-2 text-sm text-orange-700">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($lowStockProducts as $product)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                        {{ $product->nama_produk }} ({{ $product->stok_sekarang }})
                                    </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if($outOfStockProducts->count() > 0)
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="shrink-0">
                            <i class="fas fa-times-circle text-red-600 text-lg"></i>
                        </div>
                        <div class="ml-3 flex-1">
                            <h3 class="text-sm font-medium text-red-800">
                                🚫 Peringatan Stok Habis ({{ $outOfStockProducts->count() }} produk)
                            </h3>
                            <div class="mt-2 text-sm text-red-700">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($outOfStockProducts as $product)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        {{ $product->nama_produk }}
                                    </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if($inactiveProducts->count() > 0)
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="shrink-0">
                            <i class="fas fa-pause-circle text-gray-600 text-lg"></i>
                        </div>
                        <div class="ml-3 flex-1">
                            <h3 class="text-sm font-medium text-gray-800">
                                ⏸️ Produk Nonaktif ({{ $inactiveProducts->count() }} produk)
                            </h3>
                            <div class="mt-2 text-sm text-gray-700">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($inactiveProducts as $product)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $product->nama_produk }}
                                    </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Total Produk</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $produks->total() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-boxes text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Produk Aktif</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $produks->where('is_active', true)->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Stok Menipis</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $lowStockProducts->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-orange-600 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Stok Habis</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $outOfStockProducts->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-red-50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-times-circle text-red-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filter Section -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-base font-semibold text-gray-900">Pencarian & Filter</h3>
                </div>
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.produk.index') }}">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                    placeholder="Cari produk, kode..."
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                                    <option value="">Semua Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status Stok</label>
                                <select name="stock_status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                                    <option value="">Semua Stok</option>
                                    <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>Stok Menipis</option>
                                    <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Stok Habis</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Satuan</label>
                                <select name="satuan" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                                    <option value="">Semua Satuan</option>
                                    @foreach($availableUnits as $unit)
                                    <option value="{{ $unit }}" {{ request('satuan') == $unit ? 'selected' : '' }}>
                                        {{ ucfirst($unit) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                                <select name="sort" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                                    <option value="nama_asc" {{ request('sort', 'nama_asc') == 'nama_asc' ? 'selected' : '' }}>Nama A-Z</option>
                                    <option value="nama_desc" {{ request('sort') == 'nama_desc' ? 'selected' : '' }}>Nama Z-A</option>
                                    <option value="harga_asc" {{ request('sort') == 'harga_asc' ? 'selected' : '' }}>Harga Terendah</option>
                                    <option value="harga_desc" {{ request('sort') == 'harga_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                                    <option value="stok_asc" {{ request('sort') == 'stok_asc' ? 'selected' : '' }}>Stok Terendah</option>
                                    <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                </select>
                            </div>

                            <div class="flex space-x-3">
                                <button type="submit" 
                                    class="bg-yellow-500 text-gray-900 px-4 py-2 rounded-lg hover:bg-yellow-600 transition-colors flex items-center gap-2 font-medium">
                                    <i class="fas fa-filter"></i>Terapkan
                                </button>
                                <a href="{{ route('admin.produk.index') }}" 
                                    class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors flex items-center gap-2">
                                    <i class="fas fa-refresh"></i>Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Products Table -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-base font-semibold text-gray-900">Daftar Produk</h3>
                    <div class="text-sm text-gray-500">
                        {{ $produks->firstItem() ?? 0 }}-{{ $produks->lastItem() ?? 0 }} dari {{ $produks->total() }}
                    </div>
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
                                            class="w-12 h-12 rounded-lg object-cover border border-gray-200">
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center space-x-2">
                                            @if($produk->stok_sekarang <= 0)
                                                <span class="text-red-500" title="Stok Habis">🚫</span>
                                            @elseif($produk->stok_sekarang < 10)
                                                <span class="text-orange-500" title="Stok Menipis">⚠️</span>
                                            @else
                                                <span class="text-green-500" title="Stok Tersedia">✅</span>
                                            @endif

                                            @if(!$produk->is_active)
                                                <span class="text-gray-500" title="Nonaktif">⏸️</span>
                                            @endif

                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $produk->nama_produk }}</div>
                                                <div class="text-sm text-gray-500">{{ $produk->satuan }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        {{ $produk->kode_produk }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-sm font-medium text-gray-900">
                                        Rp {{ number_format($produk->harga_dasar, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="text-sm font-medium 
                                            @if($produk->stok_sekarang <= 0) text-red-600
                                            @elseif($produk->stok_sekarang < 10) text-orange-600
                                            @else text-green-600 @endif">
                                            {{ $produk->stok_sekarang }}
                                        </div>
                                        <div class="text-xs text-gray-500">awal: {{ $produk->stok_awal }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full 
                                            {{ $produk->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $produk->is_active ? '✓ Aktif' : '✕ Nonaktif' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('admin.produk.show', $produk->id) }}" 
                                                class="text-yellow-600 hover:text-yellow-800 p-1 rounded hover:bg-yellow-50" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.produk.edit', $produk->id) }}" 
                                                class="text-green-600 hover:text-green-900 p-1 rounded hover:bg-green-50" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.level-harga.show', $produk->id) }}" 
                                                class="text-yellow-600 hover:text-yellow-800 p-1 rounded hover:bg-yellow-50" title="Harga">
                                                <i class="fas fa-tags"></i>
                                            </a>
                                            <a href="{{ route('admin.stok-barang.show', $produk->id) }}" 
                                                class="text-orange-600 hover:text-orange-900 p-1 rounded hover:bg-orange-50" title="Riwayat">
                                                <i class="fas fa-history"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.produk.destroy', $produk->id) }}" 
                                                class="inline" onsubmit="return confirm('Hapus produk ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-50" title="Hapus">
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

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $produks->links() }}
                    </div>
                    @else
                    <div class="text-center py-12">
                        <i class="fas fa-boxes text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500 mb-3">Tidak ada produk yang sesuai</p>
                        <a href="{{ route('admin.produk.index') }}" class="text-blue-600 hover:text-blue-800 inline-block">
                            Reset filter
                        </a>
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

        // Auto-submit form when sort changes
        document.querySelector('select[name="sort"]').addEventListener('change', function() {
            this.form.submit();
        });

        // Search focus
        document.querySelector('input[name="search"]')?.focus();
    </script>
</body>
</html>