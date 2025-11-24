<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail {{ $produk->nama_produk }} - POS System</title>
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
                    <a href="{{ route('admin.laporan.index') }}" 
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
                    <h1 class="text-2xl font-bold text-gray-900">Detail Produk</h1>
                    <p class="text-gray-600">Informasi lengkap tentang produk</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.produk.index') }}" 
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <a href="{{ route('admin.produk.edit', $produk->id) }}" 
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Product Information -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information Card -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">Informasi Produk</h2>
                        </div>
                        <div class="p-6">
                            <div class="flex items-start space-x-6">
                                <img src="{{ $produk->gambar_url }}" alt="{{ $produk->nama_produk }}" 
                                    class="w-32 h-32 rounded-lg object-cover">
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold text-gray-900">{{ $produk->nama_produk }}</h3>
                                    <p class="text-gray-600">{{ $produk->kode_produk }}</p>
                                    
                                    <div class="mt-4 grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Harga Dasar</p>
                                            <p class="text-lg font-bold text-green-600">
                                                Rp {{ number_format($produk->harga_dasar, 0, ',', '.') }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Satuan</p>
                                            <p class="text-lg font-medium text-gray-900">{{ ucfirst($produk->satuan) }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Stok Saat Ini</p>
                                            <p class="text-lg font-medium {{ $produk->stok_sekarang <= 0 ? 'text-red-600' : ($produk->stok_sekarang < 10 ? 'text-orange-600' : 'text-gray-900') }}">
                                                {{ $produk->stok_sekarang }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Status</p>
                                            <span class="inline-block px-2 py-1 text-xs font-medium rounded-full {{ $produk->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $produk->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </div>
                                    </div>

                                    @if($produk->deskripsi)
                                    <div class="mt-4">
                                        <p class="text-sm text-gray-500">Deskripsi</p>
                                        <p class="text-gray-700">{{ $produk->deskripsi }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions Card -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">Aksi Cepat</h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <a href="{{ route('admin.level-harga.show', $produk->id) }}" 
                                    class="bg-purple-100 text-purple-700 p-4 rounded-lg text-center hover:bg-purple-200 transition-colors">
                                    <i class="fas fa-tags text-xl mb-2"></i>
                                    <p class="text-sm font-medium">Level Harga</p>
                                </a>
                                <a href="{{ route('admin.stok-barang.show', $produk->id) }}" 
                                    class="bg-orange-100 text-orange-700 p-4 rounded-lg text-center hover:bg-orange-200 transition-colors">
                                    <i class="fas fa-history text-xl mb-2"></i>
                                    <p class="text-sm font-medium">Riwayat Stok</p>
                                </a>
                                <a href="{{ route('admin.produk.edit', $produk->id) }}" 
                                    class="bg-blue-100 text-blue-700 p-4 rounded-lg text-center hover:bg-blue-200 transition-colors">
                                    <i class="fas fa-edit text-xl mb-2"></i>
                                    <p class="text-sm font-medium">Edit Produk</p>
                                </a>
                                <form method="POST" action="{{ route('admin.produk.destroy', $produk->id) }}" 
                                    class="inline" onsubmit="return confirm('Hapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="w-full bg-red-100 text-red-700 p-4 rounded-lg text-center hover:bg-red-200 transition-colors">
                                        <i class="fas fa-trash text-xl mb-2"></i>
                                        <p class="text-sm font-medium">Hapus</p>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Information -->
                <div class="space-y-6">
                    <!-- Stock Information Card -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">Informasi Stok</h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Stok Awal</span>
                                    <span class="font-medium">{{ $produk->stok_awal }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Stok Saat Ini</span>
                                    <span class="font-medium {{ $produk->stok_sekarang <= 0 ? 'text-red-600' : ($produk->stok_sekarang < 10 ? 'text-orange-600' : 'text-green-600') }}">
                                        {{ $produk->stok_sekarang }}
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Terjual</span>
                                    <span class="font-medium">{{ $produk->stok_awal - $produk->stok_sekarang }}</span>
                                </div>
                            </div>

                            <!-- Stock Update Form -->
                            <form method="POST" action="{{ route('admin.produk.update-stok', $produk->id) }}" class="mt-4">
                                @csrf
                                <div class="flex space-x-2">
                                    <input type="number" name="stok_sekarang" value="{{ $produk->stok_sekarang }}" min="0"
                                        class="flex-1 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <button type="submit" 
                                        class="bg-blue-600 text-white px-3 py-2 rounded text-sm hover:bg-blue-700 transition-colors">
                                        Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Product Statistics Card -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">Statistik</h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Dibuat</span>
                                    <span class="text-gray-900">{{ $produk->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Diupdate</span>
                                    <span class="text-gray-900">{{ $produk->updated_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Level Harga Quantity</span>
                                    <span class="text-gray-900">{{ $produk->levelHargaQuantities->count() }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Level Harga Golongan</span>
                                    <span class="text-gray-900">{{ $produk->levelHargaGolongans->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Card -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">Status</h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full {{ $produk->is_active ? 'bg-green-400' : 'bg-red-400' }} mr-2"></div>
                                    <span class="text-sm">{{ $produk->is_active ? 'Produk aktif dan tersedia di POS' : 'Produk nonaktif' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full {{ $produk->stok_sekarang > 0 ? 'bg-green-400' : 'bg-red-400' }} mr-2"></div>
                                    <span class="text-sm">{{ $produk->stok_sekarang > 0 ? 'Stok tersedia' : 'Stok habis' }}</span>
                                </div>
                                @if($produk->stok_sekarang > 0 && $produk->stok_sekarang < 10)
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full bg-orange-400 mr-2"></div>
                                    <span class="text-sm">Stok menipis (kurang dari 10)</span>
                                </div>
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