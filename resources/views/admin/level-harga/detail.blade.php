<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Level Harga {{ $produk->nama_produk }} - POS System</title>
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
                        class="flex items-center px-4 py-3 bg-blue-100 text-blue-700 rounded-lg">
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
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Level Harga</h1>
                    <p class="text-gray-600">{{ $produk->nama_produk }} - {{ $produk->kode_produk }}</p>
                </div>
                <a href="{{ route('admin.level-harga.index') }}" 
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
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

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Level Harga Quantity -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Level Harga Berdasarkan Quantity</h2>
                        <p class="text-sm text-gray-500">Harga khusus untuk pembelian dalam jumlah tertentu</p>
                    </div>
                    <div class="p-6">
                        <!-- Add Quantity Level Form -->
                        <form method="POST" action="{{ route('admin.level-harga.store-quantity') }}" class="mb-6 p-4 border rounded-lg bg-gray-50">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                            <h3 class="font-medium mb-3">Tambah Level Quantity</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Qty Minimum</label>
                                    <input type="number" name="qty_min" required min="1" 
                                        class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Qty Maximum</label>
                                    <input type="number" name="qty_max" 
                                        class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="Kosongkan untuk unlimited">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga Khusus</label>
                                    <input type="number" name="harga_khusus" required min="0" step="0.01"
                                        class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                                <input type="text" name="keterangan" 
                                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Optional">
                            </div>
                            <button type="submit" class="mt-3 bg-blue-600 text-white px-4 py-2 rounded text-sm font-medium hover:bg-blue-700 transition-colors">
                                Tambah Level
                            </button>
                        </form>

                        <!-- Quantity Levels List -->
                        <div class="space-y-3">
                            @forelse($produk->levelHargaQuantities as $level)
                            <div class="border rounded-lg p-4 flex justify-between items-center">
                                <div>
                                    <h4 class="font-medium">{{ $level->range_description }}</h4>
                                    <p class="text-green-600 font-bold">Rp {{ number_format($level->harga_khusus, 0, ',', '.') }}</p>
                                    @if($level->keterangan)
                                    <p class="text-sm text-gray-500">{{ $level->keterangan }}</p>
                                    @endif
                                </div>
                                <div class="flex space-x-2">
                                    <form method="POST" action="{{ route('admin.level-harga.destroy-quantity', $level->id) }}" class="inline" onsubmit="return confirm('Hapus level harga ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4 text-gray-500">
                                <i class="fas fa-list-ol text-2xl mb-2"></i>
                                <p>Belum ada level harga quantity</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Level Harga Golongan -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Level Harga Berdasarkan Golongan</h2>
                        <p class="text-sm text-gray-500">Harga khusus untuk member berdasarkan tier</p>
                    </div>
                    <div class="p-6">
                        <!-- Add Golongan Level Form -->
                        <form method="POST" action="{{ route('admin.level-harga.store-golongan') }}" class="mb-6 p-4 border rounded-lg bg-gray-50">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                            <h3 class="font-medium mb-3">Tambah Level Golongan</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Golongan</label>
                                    <select name="golongan_id" required 
                                        class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Pilih Golongan</option>
                                        @foreach($golongans as $golongan)
                                        <option value="{{ $golongan->id }}">{{ $golongan->nama_tier }} ({{ $golongan->diskon_persen }}% diskon default)</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga Khusus</label>
                                    <input type="number" name="harga_khusus" required min="0" step="0.01"
                                        class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                                <input type="text" name="keterangan" 
                                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Optional">
                            </div>
                            <button type="submit" class="mt-3 bg-purple-600 text-white px-4 py-2 rounded text-sm font-medium hover:bg-purple-700 transition-colors">
                                Tambah Level
                            </button>
                        </form>

                        <!-- Golongan Levels List -->
                        <div class="space-y-3">
                            @forelse($produk->levelHargaGolongans as $level)
                            <div class="border rounded-lg p-4 flex justify-between items-center">
                                <div>
                                    <h4 class="font-medium">{{ $level->golongan->nama_tier }}</h4>
                                    <p class="text-green-600 font-bold">Rp {{ number_format($level->harga_khusus, 0, ',', '.') }}</p>
                                    @if($level->keterangan)
                                    <p class="text-sm text-gray-500">{{ $level->keterangan }}</p>
                                    @endif
                                </div>
                                <div class="flex space-x-2">
                                    <form method="POST" action="{{ route('admin.level-harga.destroy-golongan', $level->id) }}" class="inline" onsubmit="return confirm('Hapus level harga ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4 text-gray-500">
                                <i class="fas fa-users text-2xl mb-2"></i>
                                <p>Belum ada level harga golongan</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Price Comparison -->
            <div class="mt-6 bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Perbandingan Harga</h2>
                    <p class="text-sm text-gray-500">Ringkasan semua level harga untuk produk ini</p>
                </div>
                <div class="p-6">
                    <div class="mb-4 p-4 bg-blue-50 rounded-lg">
                        <h3 class="font-medium text-blue-900">Harga Dasar: Rp {{ number_format($produk->harga_dasar, 0, ',', '.') }}</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Quantity Price Summary -->
                        <div>
                            <h4 class="font-medium mb-3">Harga Berdasarkan Quantity</h4>
                            <div class="space-y-2">
                                @foreach($produk->levelHargaQuantities->sortBy('qty_min') as $level)
                                <div class="flex justify-between text-sm">
                                    <span>{{ $level->range_description }}</span>
                                    <span class="font-medium text-green-600">Rp {{ number_format($level->harga_khusus, 0, ',', '.') }}</span>
                                </div>
                                @endforeach
                                @if($produk->levelHargaQuantities->isEmpty())
                                <p class="text-sm text-gray-500">Tidak ada level harga quantity</p>
                                @endif
                            </div>
                        </div>

                        <!-- Golongan Price Summary -->
                        <div>
                            <h4 class="font-medium mb-3">Harga Berdasarkan Golongan</h4>
                            <div class="space-y-2">
                                @foreach($produk->levelHargaGolongans as $level)
                                <div class="flex justify-between text-sm">
                                    <span>{{ $level->golongan->nama_tier }}</span>
                                    <span class="font-medium text-green-600">Rp {{ number_format($level->harga_khusus, 0, ',', '.') }}</span>
                                </div>
                                @endforeach
                                @if($produk->levelHargaGolongans->isEmpty())
                                <p class="text-sm text-gray-500">Tidak ada level harga golongan</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>