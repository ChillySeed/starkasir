<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Golongan - POS System</title>
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
                        class="flex items-center px-4 py-3 bg-blue-100 text-blue-700 rounded-lg">
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
                    <a href="#" 
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-chart-bar mr-3"></i>
                        Laporan
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <div class="max-w-2xl mx-auto">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Tambah Golongan Member</h1>
                        <p class="text-gray-600">Buat tier membership baru untuk pelanggan</p>
                    </div>
                    <a href="{{ route('admin.golongan.index') }}" 
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-white rounded-lg shadow">
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
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
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
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
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
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Deskripsi manfaat dan keuntungan tier ini">{{ old('deskripsi') }}</textarea>
                                <p class="text-sm text-gray-500 mt-1">Penjelasan tentang benefit tier membership</p>
                            </div>

                            <!-- Preview Card -->
                            <div class="bg-gray-50 rounded-lg p-4 border">
                                <h3 class="font-medium text-gray-900 mb-3">Pratinjau Golongan</h3>
                                <div class="flex items-center justify-between p-3 bg-white rounded border">
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
                        <div class="px-6 py-4 bg-gray-50 border-t rounded-b-lg flex justify-end space-x-3">
                            <a href="{{ route('admin.golongan.index') }}" 
                                class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition-colors">
                                Batal
                            </a>
                            <button type="submit" 
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="fas fa-save mr-2"></i>Simpan Golongan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Common Tiers Reference -->
                <div class="mt-6 bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Referensi Tier Umum</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="text-center p-4 border rounded-lg bg-blue-50">
                                <div class="w-12 h-12 mx-auto bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                                <h4 class="font-medium mt-2">General</h4>
                                <p class="text-sm text-gray-600">0-5% diskon</p>
                                <p class="text-xs text-gray-500">Member biasa</p>
                            </div>
                            <div class="text-center p-4 border rounded-lg bg-orange-50">
                                <div class="w-12 h-12 mx-auto bg-orange-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-star text-orange-600"></i>
                                </div>
                                <h4 class="font-medium mt-2">Bronze</h4>
                                <p class="text-sm text-gray-600">5-10% diskon</p>
                                <p class="text-xs text-gray-500">Member aktif</p>
                            </div>
                            <div class="text-center p-4 border rounded-lg bg-gray-50">
                                <div class="w-12 h-12 mx-auto bg-gray-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-gem text-gray-600"></i>
                                </div>
                                <h4 class="font-medium mt-2">Silver</h4>
                                <p class="text-sm text-gray-600">10-15% diskon</p>
                                <p class="text-xs text-gray-500">Member premium</p>
                            </div>
                            <div class="text-center p-4 border rounded-lg bg-yellow-50">
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
        // Live preview update
        const namaTierInput = document.getElementById('nama_tier');
        const diskonPersenInput = document.getElementById('diskon_persen');
        const previewNama = document.getElementById('previewNama');
        const previewDiskon = document.getElementById('previewDiskon');
        const previewIcon = document.getElementById('previewIcon');

        function updatePreview() {
            // Update name
            previewNama.textContent = namaTierInput.value || 'Nama Tier';
            
            // Update discount
            previewDiskon.textContent = (diskonPersenInput.value || 0) + '% Diskon';
            
            // Update icon color based on tier name
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

        // Add event listeners
        namaTierInput.addEventListener('input', updatePreview);
        diskonPersenInput.addEventListener('input', updatePreview);

        // Initialize preview
        updatePreview();
    </script>
</body>
</html>