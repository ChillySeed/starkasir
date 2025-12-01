<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Golongan - POS System</title>
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
                    <h1 class="text-xl font-bold text-gray-900">Tambah Golongan</h1>
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
                        class="flex items-center px-4 py-3 bg-yellow-50 text-yellow-700 rounded-lg font-medium border border-yellow-200">
                        <i class="fas fa-users mr-3 w-5 text-yellow-600"></i>
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
            <div class="max-w-2xl mx-auto">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Tambah Golongan Member</h2>
                        <p class="text-gray-600 mt-1">Buat tier membership baru untuk pelanggan</p>
                    </div>
                    <a href="{{ route('admin.golongan.index') }}" 
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
                    <form method="POST" action="{{ route('admin.golongan.store') }}">
                        @csrf
                        <div class="p-6 space-y-6">
                            <!-- Tier Name -->
                            <div>
                                <label for="nama_tier" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Tier <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="nama_tier" name="nama_tier" required
                                    value="{{ old('nama_tier') }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                    placeholder="Contoh: Gold, Silver, Bronze">
                                <p class="text-sm text-gray-500 mt-1">Nama unik untuk tier membership</p>
                            </div>

                            <!-- Discount Percentage -->
                            <div>
                                <label for="diskon_persen" class="block text-sm font-medium text-gray-700 mb-2">
                                    Diskon (%) <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" id="diskon_persen" name="diskon_persen" required
                                        value="{{ old('diskon_persen') }}" min="0" max="100" step="0.01"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                        placeholder="0.00">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500">%</span>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">Persentase diskon default untuk tier ini</p>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                                    Deskripsi
                                </label>
                                <textarea id="deskripsi" name="deskripsi" rows="4"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                    placeholder="Deskripsi manfaat dan keuntungan tier ini">{{ old('deskripsi') }}</textarea>
                                <p class="text-sm text-gray-500 mt-1">Penjelasan tentang benefit tier membership</p>
                            </div>

                            <!-- Preview Card -->
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <h3 class="font-medium text-gray-900 mb-3">Pratinjau Golongan</h3>
                                <div class="flex items-center justify-between p-3 bg-white rounded border border-gray-200">
                                    <div class="flex items-center">
                                        <div id="previewIcon" class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-crown text-blue-600"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p id="previewNama" class="font-semibold text-gray-900">
                                                {{ old('nama_tier', 'Nama Tier') }}
                                            </p>
                                            <p id="previewDiskon" class="text-sm text-green-600">
                                                {{ old('diskon_persen', 0) }}% Diskon
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500">Member</p>
                                        <p class="font-medium text-gray-900">0</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-lg flex justify-end space-x-3">
                            <a href="{{ route('admin.golongan.index') }}" 
                                class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition-colors">
                                Batal
                            </a>
                            <button type="submit" 
                                class="bg-yellow-500 text-gray-900 px-6 py-2 rounded-lg hover:bg-yellow-600 transition-colors font-medium flex items-center gap-2">
                                <i class="fas fa-save"></i>Simpan Golongan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Common Tiers Reference -->
                <div class="mt-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-base font-semibold text-gray-900">Referensi Tier Umum</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="text-center p-4 border border-gray-200 rounded-lg bg-blue-50">
                                <div class="w-12 h-12 mx-auto bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                                <h4 class="font-medium mt-2">General</h4>
                                <p class="text-sm text-gray-600">0-5% diskon</p>
                                <p class="text-xs text-gray-500">Member biasa</p>
                            </div>
                            <div class="text-center p-4 border border-gray-200 rounded-lg bg-orange-50">
                                <div class="w-12 h-12 mx-auto bg-orange-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-star text-orange-600"></i>
                                </div>
                                <h4 class="font-medium mt-2">Bronze</h4>
                                <p class="text-sm text-gray-600">5-10% diskon</p>
                                <p class="text-xs text-gray-500">Member aktif</p>
                            </div>
                            <div class="text-center p-4 border border-gray-200 rounded-lg bg-gray-50">
                                <div class="w-12 h-12 mx-auto bg-gray-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-gem text-gray-600"></i>
                                </div>
                                <h4 class="font-medium mt-2">Silver</h4>
                                <p class="text-sm text-gray-600">10-15% diskon</p>
                                <p class="text-xs text-gray-500">Member premium</p>
                            </div>
                            <div class="text-center p-4 border border-gray-200 rounded-lg bg-yellow-50">
                                <div class="w-12 h-12 mx-auto bg-yellow-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-crown text-yellow-600"></i>
                                </div>
                                <h4 class="font-medium mt-2">Gold</h4>
                                <p class="text-sm text-gray-600">15-20% diskon</p>
                                <p class="text-xs text-gray-500">Member VIP</p>
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

        // Live preview update
        const namaTierInput = document.getElementById('nama_tier');
        const diskonPersenInput = document.getElementById('diskon_persen');
        const previewNama = document.getElementById('previewNama');
        const previewDiskon = document.getElementById('previewDiskon');
        const previewIcon = document.getElementById('previewIcon');

        function updatePreview() {
            previewNama.textContent = namaTierInput.value || 'Nama Tier';
            previewDiskon.textContent = (diskonPersenInput.value || 0) + '% Diskon';
            
            const tierName = namaTierInput.value.toLowerCase();
            let colorClass = 'bg-blue-100 text-blue-600';
            let iconClass = 'fas fa-crown';

            if (tierName.includes('gold')) {
                colorClass = 'bg-yellow-100 text-yellow-600';
                iconClass = 'fas fa-crown';
            } else if (tierName.includes('silver')) {
                colorClass = 'bg-gray-100 text-gray-600';
                iconClass = 'fas fa-gem';
            } else if (tierName.includes('bronze')) {
                colorClass = 'bg-orange-100 text-orange-600';
                iconClass = 'fas fa-star';
            } else if (tierName.includes('general') || tierName.includes('standard')) {
                colorClass = 'bg-blue-100 text-blue-600';
                iconClass = 'fas fa-user';
            }

            previewIcon.className = `w-10 h-10 rounded-lg flex items-center justify-center ${colorClass}`;
            previewIcon.innerHTML = `<i class="${iconClass}"></i>`;
        }

        namaTierInput.addEventListener('input', updatePreview);
        diskonPersenInput.addEventListener('input', updatePreview);
        updatePreview();
    </script>
</body>
</html>