<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Level Harga {{ $produk->nama_produk }} - POS System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                    <h1 class="text-xl font-bold text-gray-900">Level Harga</h1>
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
                        class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                        <i class="fas fa-warehouse mr-3 w-5"></i>
                        Riwayat Stok
                    </a>
                    <a href="{{ route('admin.level-harga.index') }}" 
                        class="flex items-center px-4 py-3 bg-yellow-50 text-yellow-700 rounded-lg font-medium border border-yellow-200">
                        <i class="fas fa-tags mr-3 w-5 text-yellow-600"></i>
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
                    <h2 class="text-2xl font-bold text-gray-900">Level Harga</h2>
                    <p class="text-gray-600 mt-1">{{ $produk->nama_produk }} - {{ $produk->kode_produk }}</p>
                </div>
                <a href="{{ route('admin.level-harga.index') }}" 
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i>Kembali
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 flex items-center gap-2">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 flex items-center gap-2">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Level Harga Quantity -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-base font-semibold text-gray-900">Level Harga Berdasarkan Quantity</h3>
                        <p class="text-sm text-gray-500">Harga khusus untuk pembelian dalam jumlah tertentu</p>
                    </div>
                    <div class="p-6">
                        <!-- Add Quantity Level Form -->
                        <form method="POST" action="{{ route('admin.level-harga.store-quantity') }}" class="mb-6 p-4 border border-gray-200 rounded-lg bg-gray-50">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                            <h4 class="font-medium mb-3">Tambah Level Quantity</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Qty Minimum</label>
                                    <input type="number" name="qty_min" required min="1" 
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Qty Maximum</label>
                                    <input type="number" name="qty_max" 
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400"
                                        placeholder="Kosongkan untuk unlimited">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga Khusus</label>
                                    <input type="number" name="harga_khusus" required min="0" step="0.01"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                                <input type="text" name="keterangan" 
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400"
                                    placeholder="Optional">
                            </div>
                            <button type="submit" class="mt-3 bg-gray-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-600 transition-colors">
                                Tambah Level
                            </button>
                        </form>

                        <!-- Quantity Levels List -->
                        <div class="space-y-3">
                            @forelse($produk->levelHargaQuantities as $level)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="flex-1">
                                        <h4 class="font-medium">{{ $level->range_description }}</h4>
                                        <p class="text-green-600 font-bold">Rp {{ number_format($level->harga_khusus, 0, ',', '.') }}</p>
                                        @if($level->keterangan)
                                        <p class="text-sm text-gray-500">{{ $level->keterangan }}</p>
                                        @endif
                                        <span class="inline-block mt-1 px-2 py-1 text-xs rounded {{ $level->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $level->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button type="button" 
                                            class="edit-quantity-btn text-yellow-600 hover:text-yellow-800 text-sm"
                                            data-level-id="{{ $level->id }}"
                                            data-qty-min="{{ $level->qty_min }}"
                                            data-qty-max="{{ $level->qty_max }}"
                                            data-harga-khusus="{{ $level->harga_khusus }}"
                                            data-keterangan="{{ $level->keterangan }}"
                                            data-is-active="{{ $level->is_active }}">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </button>
                                        <form method="POST" action="{{ route('admin.level-harga.destroy-quantity', $level->id) }}" class="inline" onsubmit="return confirm('Hapus level harga ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                                <i class="fas fa-trash mr-1"></i>Hapus
                                            </button>
                                        </form>
                                    </div>
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
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-base font-semibold text-gray-900">Level Harga Berdasarkan Golongan</h3>
                        <p class="text-sm text-gray-500">Harga khusus untuk member berdasarkan tier</p>
                    </div>
                    <div class="p-6">
                        <!-- Add Golongan Level Form -->
                        <form method="POST" action="{{ route('admin.level-harga.store-golongan') }}" class="mb-6 p-4 border border-gray-200 rounded-lg bg-gray-50">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                            <h4 class="font-medium mb-3">Tambah Level Golongan</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1 cursor-pointer">Golongan</label>
                                    <select name="golongan_id" required 
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 cursor-pointer">
                                        <option value="">Pilih Golongan</option>
                                        @foreach($golongans as $golongan)
                                        <option value="{{ $golongan->id }}">{{ $golongan->nama_tier }} ({{ $golongan->diskon_persen }}% diskon default)</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga Khusus</label>
                                    <input type="number" name="harga_khusus" required min="0" step="0.01"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                                <input type="text" name="keterangan" 
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400"
                                    placeholder="Optional">
                            </div>
                            <button type="submit" class="mt-3 bg-gray-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-600 transition-colors">
                                Tambah Level
                            </button>
                        </form>

                        <!-- Golongan Levels List -->
                        <div class="space-y-3">
                            @forelse($produk->levelHargaGolongans as $level)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="flex-1">
                                        <h4 class="font-medium">{{ $level->golongan->nama_tier }}</h4>
                                        <p class="text-green-600 font-bold">Rp {{ number_format($level->harga_khusus, 0, ',', '.') }}</p>
                                        @if($level->keterangan)
                                        <p class="text-sm text-gray-500">{{ $level->keterangan }}</p>
                                        @endif
                                        <span class="inline-block mt-1 px-2 py-1 text-xs rounded {{ $level->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $level->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button type="button" 
                                            class="edit-golongan-btn text-yellow-600 hover:text-yellow-800 text-sm"
                                            data-level-id="{{ $level->id }}"
                                            data-golongan-id="{{ $level->golongan_id }}"
                                            data-golongan-name="{{ $level->golongan->nama_tier }}"
                                            data-harga-khusus="{{ $level->harga_khusus }}"
                                            data-keterangan="{{ $level->keterangan }}"
                                            data-is-active="{{ $level->is_active }}">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </button>
                                        <form method="POST" action="{{ route('admin.level-harga.destroy-golongan', $level->id) }}" class="inline" onsubmit="return confirm('Hapus level harga ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                                <i class="fas fa-trash mr-1"></i>Hapus
                                            </button>
                                        </form>
                                    </div>
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
            <div class="mt-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-base font-semibold text-gray-900">Perbandingan Harga</h3>
                    <p class="text-sm text-gray-500">Ringkasan semua level harga untuk produk ini</p>
                </div>
                <div class="p-6">
                    <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <h4 class="font-medium text-yellow-900">Harga Dasar: Rp {{ number_format($produk->harga_dasar, 0, ',', '.') }}</h4>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Quantity Price Summary -->
                        <div>
                            <h4 class="font-medium mb-3">Harga Berdasarkan Quantity</h4>
                            <div class="space-y-2">
                                @foreach($produk->levelHargaQuantities->where('is_active', true)->sortBy('qty_min') as $level)
                                <div class="flex justify-between text-sm">
                                    <span>{{ $level->range_description }}</span>
                                    <span class="font-medium text-green-600">Rp {{ number_format($level->harga_khusus, 0, ',', '.') }}</span>
                                </div>
                                @endforeach
                                @if($produk->levelHargaQuantities->where('is_active', true)->isEmpty())
                                <p class="text-sm text-gray-500">Tidak ada level harga quantity aktif</p>
                                @endif
                            </div>
                        </div>

                        <!-- Golongan Price Summary -->
                        <div>
                            <h4 class="font-medium mb-3">Harga Berdasarkan Golongan</h4>
                            <div class="space-y-2">
                                @foreach($produk->levelHargaGolongans->where('is_active', true) as $level)
                                <div class="flex justify-between text-sm">
                                    <span>{{ $level->golongan->nama_tier }}</span>
                                    <span class="font-medium text-green-600">Rp {{ number_format($level->harga_khusus, 0, ',', '.') }}</span>
                                </div>
                                @endforeach
                                @if($produk->levelHargaGolongans->where('is_active', true)->isEmpty())
                                <p class="text-sm text-gray-500">Tidak ada level harga golongan aktif</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Quantity Level Modal -->
    <div id="editQuantityModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-96 max-h-90vh overflow-y-auto border border-gray-200 shadow-lg">
            <h3 class="text-lg font-bold mb-4">Edit Level Harga Quantity</h3>
            <form id="editQuantityForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Qty Minimum</label>
                        <input type="number" name="qty_min" required min="1" 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Qty Maximum</label>
                        <input type="number" name="qty_max" 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                            placeholder="Kosongkan untuk unlimited">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Khusus</label>
                        <input type="number" name="harga_khusus" required min="0" step="0.01"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                        <input type="text" name="keterangan" 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                            placeholder="Optional">
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="editQuantityActive" value="1"
                            class="h-4 w-4 text-yellow-500 focus:ring-yellow-400 border-gray-300 rounded">
                        <label for="editQuantityActive" class="ml-2 block text-sm text-gray-900">
                            Aktif
                        </label>
                    </div>
                </div>
                
                <div class="flex space-x-2 mt-6">
                    <button type="button" id="cancelEditQuantity" 
                        class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400 transition-colors">
                        Batal
                    </button>
                    <button type="submit" 
                        class="flex-1 bg-gray-500 text-white py-2 rounded-lg hover:bg-gray-600 transition-colors font-medium">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Golongan Level Modal -->
    <div id="editGolonganModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-96 max-h-90vh overflow-y-auto border border-gray-200 shadow-lg">
            <h3 class="text-lg font-bold mb-4">Edit Level Harga Golongan</h3>
            <form id="editGolonganForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 cursor-pointer">Golongan</label>
                        <select name="golongan_id" required disabled
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 bg-gray-100 cursor-pointer">
                            <option value="">Pilih Golongan</option>
                            @foreach($golongans as $golongan)
                            <option value="{{ $golongan->id }}">{{ $golongan->nama_tier }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Golongan tidak dapat diubah</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Khusus</label>
                        <input type="number" name="harga_khusus" required min="0" step="0.01"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                        <input type="text" name="keterangan" 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                            placeholder="Optional">
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="editGolonganActive" value="1"
                            class="h-4 w-4 text-yellow-500 focus:ring-yellow-400 border-gray-300 rounded">
                        <label for="editGolonganActive" class="ml-2 block text-sm text-gray-900">
                            Aktif
                        </label>
                    </div>
                </div>
                
                <div class="flex space-x-2 mt-6">
                    <button type="button" id="cancelEditGolongan" 
                        class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400 transition-colors">
                        Batal
                    </button>
                    <button type="submit" 
                        class="flex-1 bg-gray-500 text-white py-2 rounded-lg hover:bg-gray-600 transition-colors font-medium">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
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

        // Edit Quantity Level
        $('.edit-quantity-btn').click(function() {
            const levelId = $(this).data('level-id');
            const qtyMin = $(this).data('qty-min');
            const qtyMax = $(this).data('qty-max');
            const hargaKhusus = $(this).data('harga-khusus');
            const keterangan = $(this).data('keterangan');
            const isActive = $(this).data('is-active');

            $('#editQuantityForm').attr('action', `/admin/level-harga/quantity/${levelId}`);
            $('#editQuantityForm input[name="qty_min"]').val(qtyMin);
            $('#editQuantityForm input[name="qty_max"]').val(qtyMax || '');
            $('#editQuantityForm input[name="harga_khusus"]').val(hargaKhusus);
            $('#editQuantityForm input[name="keterangan"]').val(keterangan || '');
            $('#editQuantityForm input[name="is_active"]').prop('checked', isActive);

            $('#editQuantityModal').removeClass('hidden').addClass('flex');
        });

        // Edit Golongan Level
        $('.edit-golongan-btn').click(function() {
            const levelId = $(this).data('level-id');
            const golonganId = $(this).data('golongan-id');
            const hargaKhusus = $(this).data('harga-khusus');
            const keterangan = $(this).data('keterangan');
            const isActive = $(this).data('is-active');

            $('#editGolonganForm').attr('action', `/admin/level-harga/golongan/${levelId}`);
            $('#editGolonganForm select[name="golongan_id"]').val(golonganId);
            $('#editGolonganForm input[name="harga_khusus"]').val(hargaKhusus);
            $('#editGolonganForm input[name="keterangan"]').val(keterangan || '');
            $('#editGolonganForm input[name="is_active"]').prop('checked', isActive);

            $('#editGolonganModal').removeClass('hidden').addClass('flex');
        });

        // Close modals
        $('#cancelEditQuantity').click(function() {
            $('#editQuantityModal').removeClass('flex').addClass('hidden');
        });

        $('#cancelEditGolongan').click(function() {
            $('#editGolonganModal').removeClass('flex').addClass('hidden');
        });

        // Close modals when clicking outside
        $(document).click(function(event) {
            if ($(event.target).is('#editQuantityModal')) {
                $('#editQuantityModal').removeClass('flex').addClass('hidden');
            }
            if ($(event.target).is('#editGolonganModal')) {
                $('#editGolonganModal').removeClass('flex').addClass('hidden');
            }
        });
    </script>
</body>
</html>