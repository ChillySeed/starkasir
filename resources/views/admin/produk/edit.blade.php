<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit {{ $produk->nama_produk }} - POS System</title>
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
                    <h1 class="text-2xl font-bold text-gray-900">Edit Produk</h1>
                    <p class="text-gray-600">Perbarui informasi produk</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.produk.show', $produk->id) }}" 
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                        <i class="fas fa-eye mr-2"></i>Lihat Detail
                    </a>
                    <a href="{{ route('admin.produk.index') }}" 
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </div>

            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Form Edit Produk</h2>
                    </div>
                    <div class="p-6">
                        <form method="POST" action="{{ route('admin.produk.update', $produk->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Left Column -->
                                <div class="space-y-4">
                                    <!-- Kode Produk -->
                                    <div>
                                        <label for="kode_produk" class="block text-sm font-medium text-gray-700 mb-1">
                                            Kode Produk *
                                        </label>
                                        <input type="text" id="kode_produk" name="kode_produk" required
                                            value="{{ old('kode_produk', $produk->kode_produk) }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        @error('kode_produk')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Nama Produk -->
                                    <div>
                                        <label for="nama_produk" class="block text-sm font-medium text-gray-700 mb-1">
                                            Nama Produk *
                                        </label>
                                        <input type="text" id="nama_produk" name="nama_produk" required
                                            value="{{ old('nama_produk', $produk->nama_produk) }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        @error('nama_produk')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Satuan -->
                                    <div>
                                        <label for="satuan" class="block text-sm font-medium text-gray-700 mb-1">
                                            Satuan *
                                        </label>
                                        <select id="satuan" name="satuan" required
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <option value="">Pilih Satuan</option>
                                            <option value="pcs" {{ old('satuan', $produk->satuan) == 'pcs' ? 'selected' : '' }}>Pcs</option>
                                            <option value="botol" {{ old('satuan', $produk->satuan) == 'botol' ? 'selected' : '' }}>Botol</option>
                                            <option value="kemasan" {{ old('satuan', $produk->satuan) == 'kemasan' ? 'selected' : '' }}>Kemasan</option>
                                            <option value="kg" {{ old('satuan', $produk->satuan) == 'kg' ? 'selected' : '' }}>Kg</option>
                                            <option value="gram" {{ old('satuan', $produk->satuan) == 'gram' ? 'selected' : '' }}>Gram</option>
                                        </select>
                                        @error('satuan')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Harga Dasar -->
                                    <div>
                                        <label for="harga_dasar" class="block text-sm font-medium text-gray-700 mb-1">
                                            Harga Dasar *
                                        </label>
                                        <input type="number" id="harga_dasar" name="harga_dasar" required min="0" step="0.01"
                                            value="{{ old('harga_dasar', $produk->harga_dasar) }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        @error('harga_dasar')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="space-y-4">
                                    <!-- Stok Awal -->
                                    <div>
                                        <label for="stok_awal" class="block text-sm font-medium text-gray-700 mb-1">
                                            Stok Awal *
                                        </label>
                                        <input type="number" id="stok_awal" name="stok_awal" required min="0"
                                            value="{{ old('stok_awal', $produk->stok_awal) }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        @error('stok_awal')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Current Image -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Gambar Saat Ini
                                        </label>
                                        <div class="flex items-center space-x-4">
                                            <img src="{{ $produk->gambar_url }}" alt="{{ $produk->nama_produk }}" 
                                                class="w-16 h-16 rounded-lg object-cover">
                                            <div>
                                                <p class="text-sm text-gray-600">Gambar saat ini</p>
                                                @if($produk->gambar)
                                                <a href="{{ $produk->gambar_url }}" target="_blank" 
                                                    class="text-blue-600 hover:text-blue-800 text-sm">
                                                    Lihat gambar
                                                </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- New Image -->
                                    <div>
                                        <label for="gambar" class="block text-sm font-medium text-gray-700 mb-1">
                                            Ganti Gambar
                                        </label>
                                        <input type="file" id="gambar" name="gambar" accept="image/*"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah gambar</p>
                                        @error('gambar')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Status -->
                                    <div>
                                        <label class="flex items-center">
                                            <input type="checkbox" name="is_active" value="1" 
                                                {{ old('is_active', $produk->is_active) ? 'checked' : '' }}
                                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                            <span class="ml-2 text-sm text-gray-700">Produk Aktif</span>
                                        </label>
                                        <p class="text-xs text-gray-500 mt-1">Nonaktifkan jika produk tidak tersedia</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Deskripsi -->
                            <div class="mt-4">
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">
                                    Deskripsi Produk
                                </label>
                                <textarea id="deskripsi" name="deskripsi" rows="3"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Deskripsi produk (opsional)">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mt-6 flex space-x-3">
                                <button type="submit" 
                                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                    <i class="fas fa-save mr-2"></i>Update Produk
                                </button>
                                <a href="{{ route('admin.produk.show', $produk->id) }}" 
                                    class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition-colors font-medium">
                                    <i class="fas fa-times mr-2"></i>Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="mt-6 bg-red-50 border border-red-200 rounded-lg">
                    <div class="px-6 py-4 border-b border-red-200">
                        <h2 class="text-lg font-semibold text-red-800">Zona Berbahaya</h2>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-red-700 mb-4">
                            Tindakan ini tidak dapat dibatalkan. Produk akan dihapus secara permanen dari sistem.
                        </p>
                        <form method="POST" action="{{ route('admin.produk.destroy', $produk->id) }}" 
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors font-medium">
                                <i class="fas fa-trash mr-2"></i>Hapus Produk
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Image preview for new image
        document.getElementById('gambar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // You can show preview of new image here if needed
                    console.log('New image selected:', file.name);
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>