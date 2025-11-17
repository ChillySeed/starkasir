<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pelanggan - POS System</title>
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
                        <h1 class="text-2xl font-bold text-gray-900">Tambah Pelanggan</h1>
                        <p class="text-gray-600">Daftarkan pelanggan baru ke sistem</p>
                    </div>
                    <a href="{{ route('admin.pelanggan.index') }}" 
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
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="CUST001">
                                        <p class="text-sm text-gray-500 mt-1">Kode unik untuk pelanggan</p>
                                    </div>

                                    <div>
                                        <label for="golongan_id" class="block text-sm font-medium text-gray-700 mb-2">
                                            Golongan Member <span class="text-red-500">*</span>
                                        </label>
                                        <select id="golongan_id" name="golongan_id" required
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
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
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
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
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="081234567890">
                                    </div>

                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                            Email
                                        </label>
                                        <input type="email" id="email" name="email"
                                            value="{{ old('email') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="email@example.com">
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                                        Alamat
                                    </label>
                                    <textarea id="alamat" name="alamat" rows="3"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Alamat lengkap pelanggan">{{ old('alamat') }}</textarea>
                                </div>
                            </div>

                            <!-- Membership Preview -->
                            <div class="bg-gray-50 rounded-lg p-4 border">
                                <h3 class="font-medium text-gray-900 mb-3">Pratinjau Membership</h3>
                                <div id="membershipPreview" class="flex items-center justify-between p-3 bg-white rounded border">
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
                        <div class="px-6 py-4 bg-gray-50 border-t rounded-b-lg flex justify-end space-x-3">
                            <a href="{{ route('admin.pelanggan.index') }}" 
                                class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition-colors">
                                Batal
                            </a>
                            <button type="submit" 
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="fas fa-save mr-2"></i>Simpan Pelanggan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Quick Tips -->
                <div class="mt-6 bg-blue-50 rounded-lg p-6">
                    <h3 class="font-medium text-blue-900 mb-3">Tips Menambahkan Pelanggan</h3>
                    <ul class="text-sm text-blue-800 space-y-2">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-blue-500 mt-0.5 mr-2"></i>
                            <span>Gunakan kode pelanggan yang mudah diingat dan konsisten</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-blue-500 mt-0.5 mr-2"></i>
                            <span>Pilih golongan yang sesuai dengan loyalitas pelanggan</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-blue-500 mt-0.5 mr-2"></i>
                            <span>Lengkapi informasi kontak untuk komunikasi yang lebih baik</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-blue-500 mt-0.5 mr-2"></i>
                            <span>Pelanggan baru akan mendapatkan diskon sesuai golongannya</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
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