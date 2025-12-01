<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - POS System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F3F4F6;
        }
        input[type="file"],
        input[type="file"]::file-selector-button,
        select {
            cursor: pointer;
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
                    <h1 class="text-xl font-bold text-gray-900">Tambah Produk</h1>
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
                    <h2 class="text-2xl font-bold text-gray-900">Tambah Produk Baru</h2>
                    <p class="text-gray-600 mt-1">Isi form berikut untuk menambahkan produk baru</p>
                </div>
                <a href="{{ route('admin.produk.index') }}" 
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i>Kembali
                </a>
            </div>

            <div class="max-w-4xl mx-auto">
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-base font-semibold text-gray-900">Form Tambah Produk</h3>
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
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
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
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                            placeholder="Nama produk">
                                        @error('nama_produk')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Satuan -->
                                    <div>
                                        <label for="satuan" class="block text-sm font-medium text-gray-700 mb-1 cursor-pointer">
                                            Satuan *
                                        </label>
                                        <select id="satuan" name="satuan" required
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent cursor-pointer">
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
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
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
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                            placeholder="0">
                                        @error('stok_awal')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Gambar -->
                                    <div>
                                        <label for="gambar" class="block text-sm font-medium text-gray-700 mb-1 cursor-pointer">
                                            Gambar Produk
                                        </label>
                                        <div class="cursor-pointer">
                                            <input type="file" id="gambar" name="gambar" accept="image/*"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent cursor-pointer">
                                        </div>
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
                                                class="rounded border-gray-300 text-yellow-500 focus:ring-yellow-400">
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
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                    placeholder="Deskripsi produk (opsional)">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mt-6 flex space-x-3">
                                <button type="submit" 
                                    class="bg-yellow-500 text-gray-900 px-6 py-2 rounded-lg hover:bg-yellow-600 transition-colors font-medium flex items-center gap-2">
                                    <i class="fas fa-save"></i>Simpan Produk
                                </button>
                                <button type="reset" 
                                    class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition-colors font-medium flex items-center gap-2">
                                    <i class="fas fa-refresh"></i>Reset Form
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Information Card -->
                <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="shrink-0">
                            <i class="fas fa-info-circle text-yellow-600"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Informasi Penting</h3>
                            <div class="mt-2 text-sm text-yellow-700">
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

        // Preview image before upload
        document.getElementById('gambar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
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
                if (name) {
                    const kode = name.split(' ').map(part => part.charAt(0)).join('').toUpperCase();
                    kodeInput.value = 'PRD-' + kode;
                }
            }
        });
    </script>
</body>
</html>