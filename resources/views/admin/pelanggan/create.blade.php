<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pelanggan - POS System</title>
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
                    <h1 class="text-xl font-bold text-gray-900">Tambah Pelanggan</h1>
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
            <div class="max-w-2xl mx-auto">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Tambah Pelanggan</h2>
                        <p class="text-gray-600 mt-1">Daftarkan pelanggan baru ke sistem</p>
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

                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <form method="POST" action="{{ route('admin.pelanggan.store') }}">
                        @csrf
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
                                            value="{{ old('kode_pelanggan') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                            placeholder="CUST001">
                                        <p class="text-sm text-gray-500 mt-1">Kode unik untuk pelanggan</p>
                                    </div>

                                    <div>
                                        <label for="golongan_id" class="block text-sm font-medium text-gray-700 mb-2 cursor-pointer">
                                            Golongan Member <span class="text-red-500">*</span>
                                        </label>
                                        <select id="golongan_id" name="golongan_id" required
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent cursor-pointer">
                                            <option value="">Pilih Golongan</option>
                                            @foreach($golongans as $golongan)
                                            <option value="{{ $golongan->id }}" {{ old('golongan_id') == $golongan->id ? 'selected' : '' }}>
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
                                        value="{{ old('nama') }}"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                        placeholder="Nama lengkap pelanggan">
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
                                            value="{{ old('no_telp') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                            placeholder="081234567890">
                                    </div>

                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                            Email
                                        </label>
                                        <input type="email" id="email" name="email"
                                            value="{{ old('email') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                            placeholder="email@example.com">
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                                        Alamat
                                    </label>
                                    <textarea id="alamat" name="alamat" rows="3"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                        placeholder="Alamat lengkap pelanggan">{{ old('alamat') }}</textarea>
                                </div>
                            </div>

                            <!-- Membership Preview -->
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <h3 class="font-medium text-gray-900 mb-3">Pratinjau Membership</h3>
                                <div id="membershipPreview" class="flex items-center justify-between p-3 bg-white rounded border border-gray-200">
                                    <div class="flex items-center">
                                        <div id="previewIcon" class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-user text-blue-600 text-xl"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p id="previewName" class="font-semibold text-gray-900">Nama Pelanggan</p>
                                            <p id="previewTier" class="text-sm text-gray-500">Pilih golongan</p>
                                            <p id="previewDiscount" class="text-xs text-green-600"></p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500">Kode</p>
                                        <p id="previewCode" class="font-medium text-gray-900">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-lg flex justify-end space-x-3">
                            <a href="{{ route('admin.pelanggan.index') }}" 
                                class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition-colors">
                                Batal
                            </a>
                            <button type="submit" 
                                class="bg-yellow-500 text-gray-900 px-6 py-2 rounded-lg hover:bg-yellow-600 transition-colors font-medium flex items-center gap-2">
                                <i class="fas fa-save"></i>Simpan Pelanggan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Quick Tips -->
                <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                    <h3 class="font-medium text-yellow-900 mb-3">Tips Menambahkan Pelanggan</h3>
                    <ul class="text-sm text-yellow-800 space-y-2">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-yellow-600 mt-0.5 mr-2"></i>
                            <span>Gunakan kode pelanggan yang mudah diingat dan konsisten</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-yellow-600 mt-0.5 mr-2"></i>
                            <span>Pilih golongan yang sesuai dengan loyalitas pelanggan</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-yellow-600 mt-0.5 mr-2"></i>
                            <span>Lengkapi informasi kontak untuk komunikasi yang lebih baik</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-yellow-600 mt-0.5 mr-2"></i>
                            <span>Pelanggan baru akan mendapatkan diskon sesuai golongannya</span>
                        </li>
                    </ul>
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

        // Golongan data for preview
        const golonganData = {
            @foreach($golongans as $golongan)
            {{ $golongan->id }}: {
                name: "{{ $golongan->nama_tier }}",
                discount: "{{ $golongan->diskon_persen }}",
                color: "{{ $golongan->nama_tier == 'Gold' ? 'yellow' : ($golongan->nama_tier == 'Silver' ? 'gray' : ($golongan->nama_tier == 'Bronze' ? 'orange' : 'blue')) }}"
            },
            @endforeach
        };

        // Update preview based on form inputs
        function updatePreview() {
            const nama = document.getElementById('nama').value || 'Nama Pelanggan';
            const kode = document.getElementById('kode_pelanggan').value || '-';
            const golonganId = document.getElementById('golongan_id').value;

            document.getElementById('previewName').textContent = nama;
            document.getElementById('previewCode').textContent = kode;

            if (golonganId && golonganData[golonganId]) {
                const golongan = golonganData[golonganId];
                document.getElementById('previewTier').textContent = golongan.name;
                document.getElementById('previewDiscount').textContent = golongan.discount + '% diskon';

                // Update icon color
                const icon = document.getElementById('previewIcon');
                icon.className = `w-12 h-12 rounded-lg flex items-center justify-center 
                    ${golongan.color === 'yellow' ? 'bg-yellow-100 text-yellow-600' : 
                      golongan.color === 'gray' ? 'bg-gray-100 text-gray-600' : 
                      golongan.color === 'orange' ? 'bg-orange-100 text-orange-600' : 'bg-blue-100 text-blue-600'}`;
                
                // Update membership card border
                const previewCard = document.getElementById('membershipPreview');
                previewCard.className = `flex items-center justify-between p-3 bg-white rounded border 
                    ${golongan.color === 'yellow' ? 'border-yellow-200' : 
                      golongan.color === 'gray' ? 'border-gray-200' : 
                      golongan.color === 'orange' ? 'border-orange-200' : 'border-blue-200'}`;
            } else {
                document.getElementById('previewTier').textContent = 'Pilih golongan';
                document.getElementById('previewDiscount').textContent = '';
            }
        }

        // Add event listeners
        document.getElementById('nama').addEventListener('input', updatePreview);
        document.getElementById('kode_pelanggan').addEventListener('input', updatePreview);
        document.getElementById('golongan_id').addEventListener('change', updatePreview);

        // Initialize preview
        updatePreview();
    </script>
</body>
</html>