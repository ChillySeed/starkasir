<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Golongan Member - POS System</title>
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
                        class="flex items-center px-4 py-3 bg-blue-100 text-blue-700 rounded-lg">
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
                    <h1 class="text-2xl font-bold text-gray-900">Golongan Member</h1>
                    <p class="text-gray-600">Kelola tier membership dan diskon untuk pelanggan</p>
                </div>
                <a href="{{ route('admin.golongan.create') }}" 
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>Tambah Golongan
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                @foreach($golongans as $golongan)
                <div class="bg-white rounded-lg shadow p-6 border-l-4 
                    {{ $golongan->nama_tier == 'General' ? 'border-gray-400' : 
                       ($golongan->nama_tier == 'Bronze' ? 'border-yellow-600' : 
                       ($golongan->nama_tier == 'Silver' ? 'border-gray-400' : 'border-yellow-400')) }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $golongan->nama_tier }}</h3>
                            <p class="text-2xl font-bold text-blue-600">{{ $golongan->diskon_persen }}%</p>
                            <p class="text-sm text-gray-500">Diskon</p>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-gray-900">{{ $golongan->pelanggans_count ?? 0 }}</p>
                            <p class="text-sm text-gray-500">Member</p>
                        </div>
                    </div>
                    @if($golongan->deskripsi)
                    <p class="text-sm text-gray-600 mt-3">{{ $golongan->deskripsi }}</p>
                    @endif
                </div>
                @endforeach
            </div>

            <!-- Golongan Table -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Daftar Golongan Member</h2>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tier</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Diskon</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah Member</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deskripsi</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($golongans as $golongan)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center 
                                                {{ $golongan->nama_tier == 'General' ? 'bg-gray-100 text-gray-600' : 
                                                   ($golongan->nama_tier == 'Bronze' ? 'bg-yellow-100 text-yellow-600' : 
                                                   ($golongan->nama_tier == 'Silver' ? 'bg-gray-100 text-gray-600' : 'bg-yellow-100 text-yellow-600')) }}">
                                                <i class="fas fa-crown text-sm"></i>
                                            </div>
                                            <span class="ml-3 font-medium text-gray-900">{{ $golongan->nama_tier }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            {{ $golongan->diskon_persen }}% Diskon
                                        </span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="text-sm text-gray-900">{{ $golongan->pelanggans_count ?? 0 }}</span>
                                        <span class="text-sm text-gray-500">member</span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <p class="text-sm text-gray-900">{{ $golongan->deskripsi ?? '-' }}</p>
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('admin.golongan.edit', $golongan->id) }}" 
                                                class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.golongan.destroy', $golongan->id) }}" 
                                                onsubmit="return confirm('Hapus golongan {{ $golongan->nama_tier }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
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

                    @if($golongans->isEmpty())
                    <div class="text-center py-8">
                        <i class="fas fa-users text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-500">Belum ada golongan member</p>
                        <a href="{{ route('admin.golongan.create') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                            Tambah golongan pertama
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Benefits Comparison -->
            <div class="mt-6 bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Perbandingan Benefit Golongan</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-{{ count($golongans) }} gap-4">
                        @foreach($golongans as $golongan)
                        <div class="text-center p-4 border rounded-lg 
                            {{ $golongan->nama_tier == 'Gold' ? 'bg-yellow-50 border-yellow-200' : 
                               ($golongan->nama_tier == 'Silver' ? 'bg-gray-50 border-gray-200' : 
                               ($golongan->nama_tier == 'Bronze' ? 'bg-orange-50 border-orange-200' : 'bg-blue-50 border-blue-200')) }}">
                            <div class="w-12 h-12 mx-auto rounded-full flex items-center justify-center 
                                {{ $golongan->nama_tier == 'Gold' ? 'bg-yellow-100 text-yellow-600' : 
                                   ($golongan->nama_tier == 'Silver' ? 'bg-gray-100 text-gray-600' : 
                                   ($golongan->nama_tier == 'Bronze' ? 'bg-orange-100 text-orange-600' : 'bg-blue-100 text-blue-600')) }}">
                                <i class="fas fa-crown"></i>
                            </div>
                            <h3 class="font-semibold text-lg mt-2">{{ $golongan->nama_tier }}</h3>
                            <p class="text-2xl font-bold text-green-600">{{ $golongan->diskon_persen }}%</p>
                            <p class="text-sm text-gray-500">Diskon Default</p>
                            <div class="mt-3 text-sm text-gray-600">
                                <p>{{ $golongan->pelanggans_count ?? 0 }} Member</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>