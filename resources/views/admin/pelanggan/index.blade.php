<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggan - POS System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                    <h1 class="text-xl font-bold text-gray-900">Data Pelanggan</h1>
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
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Data Pelanggan</h2>
                    <p class="text-gray-600 mt-1">Kelola data member dan pelanggan toko</p>
                </div>
                <div class="flex space-x-3">
                    <button id="filterBtn" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors flex items-center gap-2">
                        <i class="fas fa-filter"></i>Filter
                    </button>
                    <a href="{{ route('admin.pelanggan.create') }}" 
                        class="bg-yellow-500 text-gray-900 px-4 py-2 rounded-lg hover:bg-yellow-600 transition-colors flex items-center gap-2 font-medium">
                        <i class="fas fa-plus"></i>Tambah Pelanggan
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 flex items-center gap-2">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filter Section -->
            <div id="filterSection" class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6 hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="font-medium text-gray-900">Filter Pelanggan</h3>
                </div>
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.pelanggan.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2 cursor-pointer">Golongan</label>
                            <select name="golongan_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 cursor-pointer">
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
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                        </div>
                        <div class="flex items-end space-x-2">
                            <button type="submit" class="bg-yellow-500 text-gray-900 px-4 py-2 rounded-lg hover:bg-yellow-600 flex-1 font-medium">
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
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-users text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Total Pelanggan</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_pelanggan'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-yellow-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-crown text-yellow-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Member Gold</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['gold_members'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-shopping-cart text-purple-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Transaksi Bulan Ini</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['transaksi_bulan_ini'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-orange-50 rounded-lg flex items-center justify-center flex-shrink-0">
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
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                    Golongan: {{ $selectedGolongan->nama_tier }}
                    <a href="{{ request()->fullUrlWithQuery(['golongan_id' => null]) }}" class="ml-1 text-yellow-600 hover:text-yellow-800">
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
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-base font-semibold text-gray-900">Daftar Pelanggan</h3>
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
                                                class="text-yellow-600 hover:text-yellow-800" title="Edit">
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
                    <div class="text-center py-12">
                        <i class="fas fa-user-friends text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500 mb-1">Belum ada data pelanggan</p>
                        @if(request('golongan_id') || request('search'))
                        <p class="text-sm text-gray-500 mt-1">Coba ubah filter pencarian Anda</p>
                        <a href="{{ route('admin.pelanggan.index') }}" class="text-yellow-600 hover:text-yellow-800 mt-2 inline-block">
                            Tampilkan semua pelanggan
                        </a>
                        @else
                        <a href="{{ route('admin.pelanggan.create') }}" class="text-yellow-600 hover:text-yellow-800 mt-2 inline-block">
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
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-base font-semibold text-gray-900">Pelanggan Terbaik</h3>
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
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-base font-semibold text-gray-900">Distribusi Member</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            @foreach($membership_distribution as $dist)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">{{ $dist->nama_tier }}</span>
                                <div class="flex items-center">
                                    <span class="text-sm font-medium mr-2">{{ $dist->total }}</span>
                                    <div class="w-20 bg-gray-200 rounded-full h-2">
                                        <div class="bg-yellow-500 h-2 rounded-full" 
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

        // Toggle filter section
        $('#filterBtn').click(function() {
            $('#filterSection').slideToggle();
        });
    </script>
</body>
</html>