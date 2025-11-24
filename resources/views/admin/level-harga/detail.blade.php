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
                    <a href="{{ route('admin.stok-barang.index') }}" 
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-warehouse mr-3"></i>
                        Riwayat Stok
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
                            <div class="border rounded-lg p-4">
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
                                            class="edit-quantity-btn text-blue-600 hover:text-blue-800 text-sm"
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
                            <div class="border rounded-lg p-4">
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
                                            class="edit-golongan-btn text-blue-600 hover:text-blue-800 text-sm"
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
        <div class="bg-white rounded-lg p-6 w-96 max-h-90vh overflow-y-auto">
            <h3 class="text-lg font-bold mb-4">Edit Level Harga Quantity</h3>
            <form id="editQuantityForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Qty Minimum</label>
                        <input type="number" name="qty_min" required min="1" 
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Qty Maximum</label>
                        <input type="number" name="qty_max" 
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Kosongkan untuk unlimited">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Khusus</label>
                        <input type="number" name="harga_khusus" required min="0" step="0.01"
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                        <input type="text" name="keterangan" 
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Optional">
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="editQuantityActive" value="1"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
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
                        class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- Edit Golongan Level Modal -->
    <div id="editGolonganModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-96 max-h-90vh overflow-y-auto">
            <h3 class="text-lg font-bold mb-4">Edit Level Harga Golongan</h3>
            <form id="editGolonganForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Golongan</label>
                        <select name="golongan_id" required disabled
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-100">
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
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                        <input type="text" name="keterangan" 
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Optional">
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="editGolonganActive" value="1"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
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
                        class="flex-1 bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700 transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
        
    <script>
        // Edit Quantity Level
        $('.edit-quantity-btn').click(function() {
            const levelId = $(this).data('level-id');
            const qtyMin = $(this).data('qty-min');
            const qtyMax = $(this).data('qty-max');
            const hargaKhusus = $(this).data('harga-khusus');
            const keterangan = $(this).data('keterangan');
            const isActive = $(this).data('is-active');

            // Set form action
            $('#editQuantityForm').attr('action', `/admin/level-harga/quantity/${levelId}`);
            
            // Fill form data
            $('#editQuantityForm input[name="qty_min"]').val(qtyMin);
            $('#editQuantityForm input[name="qty_max"]').val(qtyMax || '');
            $('#editQuantityForm input[name="harga_khusus"]').val(hargaKhusus);
            $('#editQuantityForm input[name="keterangan"]').val(keterangan || '');
            $('#editQuantityForm input[name="is_active"]').prop('checked', isActive);

            // Show modal
            $('#editQuantityModal').removeClass('hidden').addClass('flex');
        });

        // Edit Golongan Level
        $('.edit-golongan-btn').click(function() {
            const levelId = $(this).data('level-id');
            const golonganId = $(this).data('golongan-id');
            const hargaKhusus = $(this).data('harga-khusus');
            const keterangan = $(this).data('keterangan');
            const isActive = $(this).data('is-active');

            // Set form action
            $('#editGolonganForm').attr('action', `/admin/level-harga/golongan/${levelId}`);
            
            // Fill form data
            $('#editGolonganForm select[name="golongan_id"]').val(golonganId);
            $('#editGolonganForm input[name="harga_khusus"]').val(hargaKhusus);
            $('#editGolonganForm input[name="keterangan"]').val(keterangan || '');
            $('#editGolonganForm input[name="is_active"]').prop('checked', isActive);

            // Show modal
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

        // Handle form submissions (they will submit normally and refresh the page)
        // The backend will handle the updates and redirect back with success/error messages
    </script>
</body>
</html>