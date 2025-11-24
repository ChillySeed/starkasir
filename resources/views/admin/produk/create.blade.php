<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - POS System</title>
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
                    <h1 class="text-2xl font-bold text-gray-900">Tambah Produk Baru</h1>
                    <p class="text-gray-600">Isi form berikut untuk menambahkan produk baru</p>
                </div>
                <a href="{{ route('admin.produk.index') }}" 
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>

            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Form Tambah Produk</h2>
                    </div>
                    <div class="p-6">
                        <form method="POST" action="{{ route('admin.produk.store') }}" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Left Column -->
                                <div class="space-y-4">
                                    <!-- Kode Produk -->
                                    <div>
                                        <label for="kode_produk" class="block text-sm font-medium text-gray-700 mb-1">
                                            Kode Produk *
                                        </label>
                                        <input type="text" id="kode_produk" name="kode_produk" required
                                            value="{{ old('kode_produk') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="PRD001">
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
                                            value="{{ old('nama_produk') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Nama produk">
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
                                            <option value="pcs" {{ old('satuan') == 'pcs' ? 'selected' : '' }}>Pcs</option>
                                            <option value="botol" {{ old('satuan') == 'botol' ? 'selected' : '' }}>Botol</option>
                                            <option value="kemasan" {{ old('satuan') == 'kemasan' ? 'selected' : '' }}>Kemasan</option>
                                            <option value="kg" {{ old('satuan') == 'kg' ? 'selected' : '' }}>Kg</option>
                                            <option value="gram" {{ old('satuan') == 'gram' ? 'selected' : '' }}>Gram</option>
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
                                            value="{{ old('harga_dasar') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="0">
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
                                            value="{{ old('stok_awal', 0) }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="0">
                                        @error('stok_awal')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Gambar -->
                                    <div>
                                        <label for="gambar" class="block text-sm font-medium text-gray-700 mb-1">
                                            Gambar Produk
                                        </label>
                                        <input type="file" id="gambar" name="gambar" accept="image/*"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF (Maks: 2MB)</p>
                                        @error('gambar')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Status -->
                                    <div>
                                        <label class="flex items-center">
                                            <input type="checkbox" name="is_active" value="1" 
                                                {{ old('is_active', true) ? 'checked' : '' }}
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
                                    placeholder="Deskripsi produk (opsional)">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mt-6 flex space-x-3">
                                <button type="submit" 
                                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                    <i class="fas fa-save mr-2"></i>Simpan Produk
                                </button>
                                <button type="reset" 
                                    class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition-colors font-medium">
                                    <i class="fas fa-refresh mr-2"></i>Reset Form
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Information Card -->
                <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Informasi Penting</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Kode produk harus unik dan tidak boleh sama dengan produk lain</li>
                                    <li>Harga dasar adalah harga normal sebelum diskon atau level harga</li>
                                    <li>Stok awal akan menjadi stok saat ini saat produk dibuat</li>
                                    <li>Produk nonaktif tidak akan muncul di POS kasir</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Preview image before upload
        document.getElementById('gambar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // You can add image preview functionality here if needed
                    console.log('File selected:', file.name);
                }
                reader.readAsDataURL(file);
            }
        });

        // Auto-generate product code on name input (optional)
        document.getElementById('nama_produk').addEventListener('input', function(e) {
            const kodeInput = document.getElementById('kode_produk');
            if (!kodeInput.value) {
                const name = e.target.value;
                if (name.length > 0) {
                    const initials = name.split(' ').map(word => word.charAt(0).toUpperCase()).join('');
                    kodeInput.value = 'PRD-' + initials + '-' + Math.random().toString(36).substr(2, 4).toUpperCase();
                }
            }
        });
    </script>
</body>
</html>