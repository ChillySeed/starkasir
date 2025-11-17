<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Golongan - POS System</title>
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
                        <h1 class="text-2xl font-bold text-gray-900">Edit Golongan Member</h1>
                        <p class="text-gray-600">Update informasi tier membership</p>
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
                    <form method="POST" action="{{ route('admin.golongan.update', $golongan->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="p-6 space-y-6">
                            <!-- Current Stats -->
                            <div class="bg-blue-50 rounded-lg p-4">
                                <h3 class="font-medium text-blue-900 mb-2">Statistik Saat Ini</h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-blue-700">Jumlah Member</p>
                                        <p class="text-lg font-bold text-blue-900">{{ $golongan->pelanggans_count ?? 0 }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-blue-700">Tanggal Dibuat</p>
                                        <p class="text-sm font-medium text-blue-900">{{ $golongan->created_at->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Tier Name -->
                            <div>
                                <label for="nama_tier" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Tier <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="nama_tier" name="nama_tier" required
                                    value="{{ old('nama_tier', $golongan->nama_tier) }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <!-- Discount Percentage -->
                            <div>
                                <label for="diskon_persen" class="block text-sm font-medium text-gray-700 mb-2">
                                    Diskon (%) <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" id="diskon_persen" name="diskon_persen" required
                                        value="{{ old('diskon_persen', $golongan->diskon_persen) }}" min="0" max="100" step="0.01"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500">%</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                                    Deskripsi
                                </label>
                                <textarea id="deskripsi" name="deskripsi" rows="4"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Deskripsi manfaat dan keuntungan tier ini">{{ old('deskripsi', $golongan->deskripsi) }}</textarea>
                            </div>

                            <!-- Impact Warning -->
                            @if($golongan->pelanggans_count > 0)
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <div class="flex">
                                    <div class="shrink-0">
                                        <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-yellow-800">
                                            Perhatian
                                        </h3>
                                        <div class="mt-2 text-sm text-yellow-700">
                                            <p>
                                                Perubahan diskon akan mempengaruhi {{ $golongan->pelanggans_count }} member 
                                                yang tergabung dalam golongan ini.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Form Actions -->
                        <div class="px-6 py-4 bg-gray-50 border-t rounded-b-lg flex justify-between items-center">
                            <form method="POST" action="{{ route('admin.golongan.destroy', $golongan->id) }}" 
                                onsubmit="return confirm('Hapus golongan {{ $golongan->nama_tier }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium">
                                    <i class="fas fa-trash mr-2"></i>Hapus Golongan
                                </button>
                            </form>
                            <div class="flex space-x-3">
                                <a href="{{ route('admin.golongan.index') }}" 
                                    class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition-colors">
                                    Batal
                                </a>
                                <button type="submit" 
                                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-save mr-2"></i>Update Golongan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>