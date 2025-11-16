<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggan - POS System</title>
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
                        class="flex items-center px-4 py-3 bg-blue-100 text-blue-700 rounded-lg">
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
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Data Pelanggan</h1>
                    <p class="text-gray-600">Kelola data member dan pelanggan toko</p>
                </div>
                <div class="flex space-x-3">
                    <button id="filterBtn" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-filter mr-2"></i>Filter
                    </button>
                    <a href="{{ route('admin.pelanggan.create') }}" 
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>Tambah Pelanggan
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filter Section -->
            <div id="filterSection" class="bg-white rounded-lg shadow mb-6 hidden">
                <div class="p-6 border-b">
                    <h3 class="font-medium text-gray-900">Filter Pelanggan</h3>
                </div>
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.pelanggan.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Golongan</label>
                            <select name="golongan_id" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                <option value="">Semua Golongan</option>
                                @foreach($golongans as $golongan)
                                <option value="{{ $golongan->id }}" {{ request('golongan_id') == $golongan->id ? 'selected' : '' }}>
                                    {{ $golongan->nama_tier }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cari</label>
                            <input type="text" name="search" placeholder="Nama atau kode..." 
                                value="{{ request('search') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        </div>
                        <div class="flex items-end space-x-2">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex-1">
                                Terapkan Filter
                            </button>
                            <a href="{{ route('admin.pelanggan.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 text-center">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <i class="fas fa-users text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Total Pelanggan</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_pelanggan'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 rounded-lg">
                            <i class="fas fa-crown text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Member Gold</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['gold_members'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-100 rounded-lg">
                            <i class="fas fa-shopping-cart text-purple-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Transaksi Bulan Ini</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['transaksi_bulan_ini'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-orange-100 rounded-lg">
                            <i class="fas fa-money-bill-wave text-orange-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Total Belanja</p>
                            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($stats['total_belanja'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Filters -->
            @if(request('golongan_id') || request('search'))
            <div class="mb-4 flex items-center space-x-2">
                <span class="text-sm text-gray-600">Filter aktif:</span>
                @if(request('golongan_id'))
                @php
                    $selectedGolongan = $golongans->firstWhere('id', request('golongan_id'));
                @endphp
                @if($selectedGolongan)
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    Golongan: {{ $selectedGolongan->nama_tier }}
                    <a href="{{ request()->fullUrlWithQuery(['golongan_id' => null]) }}" class="ml-1 text-blue-600 hover:text-blue-800">
                        <i class="fas fa-times"></i>
                    </a>
                </span>
                @endif
                @endif
                @if(request('search'))
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    Pencarian: "{{ request('search') }}"
                    <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="ml-1 text-green-600 hover:text-green-800">
                        <i class="fas fa-times"></i>
                    </a>
                </span>
                @endif
                <a href="{{ route('admin.pelanggan.index') }}" class="text-sm text-red-600 hover:text-red-800">
                    Hapus semua filter
                </a>
            </div>
            @endif

            <!-- Pelanggan Table -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-900">Daftar Pelanggan</h2>
                    <div class="text-sm text-gray-500">
                        Menampilkan {{ $pelanggans->count() }} dari {{ $stats['total_pelanggan'] }} pelanggan
                    </div>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelanggan</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Golongan</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kontak</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statistik</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($pelanggans as $pelanggan)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-linear-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold">
                                                {{ substr($pelanggan->nama, 0, 1) }}
                                            </div>
                                            <div class="ml-4">
                                                <p class="font-medium text-gray-900">{{ $pelanggan->nama }}</p>
                                                <p class="text-sm text-gray-500">{{ $pelanggan->kode_pelanggan }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center 
                                                {{ $pelanggan->golongan->nama_tier == 'Gold' ? 'bg-yellow-100 text-yellow-600' : 
                                                   ($pelanggan->golongan->nama_tier == 'Silver' ? 'bg-gray-100 text-gray-600' : 
                                                   ($pelanggan->golongan->nama_tier == 'Bronze' ? 'bg-orange-100 text-orange-600' : 'bg-blue-100 text-blue-600')) }}">
                                                <i class="fas fa-crown text-sm"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">{{ $pelanggan->golongan->nama_tier }}</p>
                                                <p class="text-xs text-green-600">{{ $pelanggan->golongan->diskon_persen }}% diskon</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <p class="text-sm text-gray-900">{{ $pelanggan->no_telp ?? '-' }}</p>
                                        <p class="text-xs text-gray-500 truncate max-w-xs">{{ $pelanggan->alamat ?? '-' }}</p>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="space-y-1">
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-500">Transaksi:</span>
                                                <span class="font-medium">{{ $pelanggan->total_transaksi }}</span>
                                            </div>
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-500">Total Belanja:</span>
                                                <span class="font-medium text-green-600">Rp {{ number_format($pelanggan->total_belanja, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('admin.pelanggan.edit', $pelanggan->id) }}" 
                                                class="text-blue-600 hover:text-blue-900" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.pelanggan.destroy', $pelanggan->id) }}" 
                                                onsubmit="return confirm('Hapus pelanggan {{ $pelanggan->nama }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($pelanggans->isEmpty())
                    <div class="text-center py-8">
                        <i class="fas fa-user-friends text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-500">Belum ada data pelanggan</p>
                        @if(request('golongan_id') || request('search'))
                        <p class="text-sm text-gray-500 mt-1">Coba ubah filter pencarian Anda</p>
                        <a href="{{ route('admin.pelanggan.index') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                            Tampilkan semua pelanggan
                        </a>
                        @else
                        <a href="{{ route('admin.pelanggan.create') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                            Tambah pelanggan pertama
                        </a>
                        @endif
                    </div>
                    @endif

                    <!-- Pagination -->
                    @if($pelanggans->hasPages())
                    <div class="mt-6">
                        {{ $pelanggans->withQueryString()->links() }}
                    </div>
                    @endif
                </div>
            </div>

            <!-- Top Customers -->
            <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Top Spenders -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Pelanggan Terbaik</h3>
                        <p class="text-sm text-gray-500">Berdasarkan total belanja</p>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($top_pelanggan as $pelanggan)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-linear-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold">
                                        {{ substr($pelanggan->nama, 0, 1) }}
                                    </div>
                                    <div class="ml-3">
                                        <p class="font-medium text-gray-900">{{ $pelanggan->nama }}</p>
                                        <p class="text-sm text-gray-500">{{ $pelanggan->golongan->nama_tier }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium text-green-600">Rp {{ number_format($pelanggan->total_belanja, 0, ',', '.') }}</p>
                                    <p class="text-xs text-gray-500">{{ $pelanggan->total_transaksi }} transaksi</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @if($top_pelanggan->isEmpty())
                        <div class="text-center py-4 text-gray-500">
                            <p>Belum ada data pelanggan</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Membership Distribution -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Distribusi Member</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            @foreach($membership_distribution as $dist)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">{{ $dist->nama_tier }}</span>
                                <div class="flex items-center">
                                    <span class="text-sm font-medium mr-2">{{ $dist->total }}</span>
                                    <div class="w-20 bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" 
                                             style="width: {{ ($dist->total / max($membership_distribution->sum('total'), 1)) * 100 }}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Total Pelanggan:</span>
                                <span class="font-medium">{{ $membership_distribution->sum('total') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle filter section
        $('#filterBtn').click(function() {
            $('#filterSection').slideToggle();
        });

        // Remove all auto-submit functionality
        // Filters will only apply when "Terapkan Filter" button is clicked
    </script>
</body>
</html>