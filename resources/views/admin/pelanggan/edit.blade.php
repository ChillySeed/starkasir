<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pelanggan - POS System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F3F4F6;
        }
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
                    <h1 class="text-xl font-bold text-gray-900">Edit Pelanggan</h1>
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
                        class="flex items-center px-4 py-3 bg-yellow-50 text-yellow-700 rounded-lg font-medium border border-yellow-200">
                        <i class="fas fa-user-friends mr-3 w-5 text-yellow-600"></i>
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
            <div class="max-w-4xl mx-auto">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Edit Pelanggan</h2>
                        <p class="text-gray-600 mt-1">Update informasi pelanggan</p>
                    </div>
                    <a href="{{ route('admin.pelanggan.index') }}" 
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i>Kembali
                    </a>
                </div>

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 flex items-center gap-2">
                        <i class="fas fa-exclamation-circle"></i>
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Customer Stats -->
                    <div class="lg:col-span-1">
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                            <div class="text-center">
                                <div class="w-20 h-20 bg-linear-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-2xl mx-auto mb-4">
                                    {{ substr($pelanggan->nama, 0, 1) }}
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $pelanggan->nama }}</h3>
                                <p class="text-sm text-gray-500">{{ $pelanggan->kode_pelanggan }}</p>
                                
                                <div class="mt-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <div class="flex items-center justify-center mb-2">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center 
                                            {{ $pelanggan->golongan->nama_tier == 'Gold' ? 'bg-yellow-100 text-yellow-600' : 
                                               ($pelanggan->golongan->nama_tier == 'Silver' ? 'bg-gray-100 text-gray-600' : 
                                               ($pelanggan->golongan->nama_tier == 'Bronze' ? 'bg-orange-100 text-orange-600' : 'bg-blue-100 text-blue-600')) }}">
                                            <i class="fas fa-crown text-sm"></i>
                                        </div>
                                        <span class="ml-2 font-medium">{{ $pelanggan->golongan->nama_tier }}</span>
                                    </div>
                                    <p class="text-green-600 font-bold">{{ $pelanggan->golongan->diskon_persen }}% diskon</p>
                                </div>
                            </div>

                            <div class="mt-6 space-y-4">
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500">Total Transaksi</span>
                                    <span class="font-medium">{{ $pelanggan->total_transaksi }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500">Total Belanja</span>
                                    <span class="font-medium text-green-600">Rp {{ number_format($pelanggan->total_belanja, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500">Member Since</span>
                                    <span class="font-medium">{{ $pelanggan->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>

                            @if($pelanggan->no_telp || $pelanggan->alamat)
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <h4 class="font-medium text-gray-900 mb-3">Kontak</h4>
                                @if($pelanggan->no_telp)
                                <div class="flex items-center text-sm text-gray-600 mb-2">
                                    <i class="fas fa-phone mr-2"></i>
                                    <span>{{ $pelanggan->no_telp }}</span>
                                </div>
                                @endif
                                @if($pelanggan->alamat)
                                <div class="flex items-start text-sm text-gray-600">
                                    <i class="fas fa-map-marker-alt mr-2 mt-0.5"></i>
                                    <span class="wrap-break-word">{{ $pelanggan->alamat }}</span>
                                </div>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Edit Form -->
                    <div class="lg:col-span-2">
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                            <form method="POST" action="{{ route('admin.pelanggan.update', $pelanggan->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="p-6 space-y-6">
                                    <!-- Basic Information -->
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar</h3>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="kode_pelanggan" class="block text-sm font-medium text-gray-700 mb-2">
                                                    Kode Pelanggan <span class="text-red-500">*</span>
                                                </label>
                                                <input type="text" id="kode_pelanggan" name="kode_pelanggan" required
                                                    value="{{ old('kode_pelanggan', $pelanggan->kode_pelanggan) }}"
                                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                                            </div>

                                            <div>
                                                <label for="golongan_id" class="block text-sm font-medium text-gray-700 mb-2 cursor-pointer">
                                                    Golongan Member <span class="text-red-500">*</span>
                                                </label>
                                                <select id="golongan_id" name="golongan_id" required
                                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent cursor-pointer">
                                                    <option value="">Pilih Golongan</option>
                                                    @foreach($golongans as $golongan)
                                                    <option value="{{ $golongan->id }}" {{ old('golongan_id', $pelanggan->golongan_id) == $golongan->id ? 'selected' : '' }}>
                                                        {{ $golongan->nama_tier }} ({{ $golongan->diskon_persen }}% diskon)
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                                                Nama Lengkap <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" id="nama" name="nama" required
                                                value="{{ old('nama', $pelanggan->nama) }}"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                                        </div>
                                    </div>

                                    <!-- Contact Information -->
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Kontak</h3>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="no_telp" class="block text-sm font-medium text-gray-700 mb-2">
                                                    Nomor Telepon
                                                </label>
                                                <input type="text" id="no_telp" name="no_telp"
                                                    value="{{ old('no_telp', $pelanggan->no_telp) }}"
                                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                                            </div>

                                            <div>
                                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                                    Email
                                                </label>
                                                <input type="email" id="email" name="email"
                                                    value="{{ old('email', $pelanggan->email) }}"
                                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                                                Alamat
                                            </label>
                                            <textarea id="alamat" name="alamat" rows="3"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">{{ old('alamat', $pelanggan->alamat) }}</textarea>
                                        </div>
                                    </div>

                                    <!-- Statistics (Readonly) -->
                                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                        <h3 class="font-medium text-gray-900 mb-3">Statistik Pelanggan</h3>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <p class="text-sm text-gray-600">Total Transaksi</p>
                                                <p class="text-lg font-bold text-gray-900">{{ $pelanggan->total_transaksi }}</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-600">Total Belanja</p>
                                                <p class="text-lg font-bold text-green-600">Rp {{ number_format($pelanggan->total_belanja, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-lg flex justify-between items-center">
                                    <form method="POST" action="{{ route('admin.pelanggan.destroy', $pelanggan->id) }}" 
                                        onsubmit="return confirm('Hapus pelanggan {{ $pelanggan->nama }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium flex items-center gap-2">
                                            <i class="fas fa-trash"></i>Hapus Pelanggan
                                        </button>
                                    </form>
                                    <div class="flex space-x-3">
                                        <a href="{{ route('admin.pelanggan.index') }}" 
                                            class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition-colors">
                                            Batal
                                        </a>
                                        <button type="submit" 
                                            class="bg-yellow-500 text-gray-900 px-6 py-2 rounded-lg hover:bg-yellow-600 transition-colors font-medium flex items-center gap-2">
                                            <i class="fas fa-save"></i>Update Pelanggan
                                        </button>
                                    </div>
                                </div>
                            </form>
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
    </script>
</body>
</html>