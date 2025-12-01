<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - POS System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F3F4F6;
        }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
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
                    <h1 class="text-xl font-bold text-gray-900">Dashboard Admin</h1>
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
                        class="flex items-center px-4 py-3 bg-yellow-50 text-gray-900 rounded-lg font-medium border border-yellow-200">
                        <i class="fas fa-tachometer-alt mr-3 w-5 text-yellow-600"></i>
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
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Transaksi Hari Ini</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_transaksi_hari_ini'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Pendapatan Hari Ini</p>
                            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($stats['total_pendapatan_hari_ini'], 0, ',', '.') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Total Produk</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_produk'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-boxes text-purple-600 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Stok Menipis</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['produk_habis'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-red-50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Additional Stats -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
                <!-- Revenue Chart -->
                <div class="lg:col-span-2 bg-white border border-gray-200 rounded-lg shadow-sm p-5">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-base font-semibold text-gray-900">Pendapatan 7 Hari Terakhir</h3>
                        <div class="flex space-x-2">
                            <button class="text-xs bg-green-400 text-gray-900 px-3 py-1.5 rounded-lg period-btn font-semibold hover:bg-green-500" data-period="week">7H</button>
                            <button class="text-xs bg-gray-100 text-gray-700 px-3 py-1.5 rounded-lg period-btn font-medium hover:bg-gray-200" data-period="month">30H</button>
                            <button class="text-xs bg-gray-100 text-gray-700 px-3 py-1.5 rounded-lg period-btn font-medium hover:bg-gray-200" data-period="year">1Th</button>
                        </div>
                    </div>
                    <div class="h-64">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <!-- Membership Distribution -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-5">
                    <h3 class="text-base font-semibold text-gray-900 mb-4">Distribusi Member</h3>
                    <div class="space-y-3">
                        @foreach($membership_distribution as $dist)
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">{{ $dist->nama_tier }}</span>
                            <div class="flex items-center">
                                <span class="text-sm font-medium mr-2 text-gray-900">{{ $dist->total }}</span>
                                <div class="w-16 bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-400 h-2 rounded-full" 
                                         style="width: {{ ($dist->total / max($membership_distribution->sum('total'), 1)) * 100 }}%">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Total Member:</span>
                            <span class="font-semibold text-gray-900">{{ $membership_distribution->sum('total') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <!-- Recent Transactions -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="px-5 py-4 border-b border-gray-200">
                        <h3 class="text-base font-semibold text-gray-900">Transaksi Terbaru</h3>
                    </div>
                    <div class="p-5">
                        <div class="space-y-3 custom-scrollbar" style="max-height: 400px; overflow-y: auto;">
                            @foreach($transaksi_terbaru as $transaksi)
                            <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                                <div>
                                    <p class="font-medium text-sm text-gray-900">{{ $transaksi->kode_transaksi }}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $transaksi->pelanggan->nama ?? 'Umum' }} • 
                                        {{ $transaksi->tanggal_transaksi->format('H:i') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-sm text-gray-900">Rp {{ number_format($transaksi->total_amount, 0, ',', '.') }}</p>
                                    <span class="inline-block px-2 py-0.5 text-xs rounded mt-1 font-medium
                                        {{ $transaksi->metode_pembayaran == 'tunai' ? 'bg-gray-100 text-gray-700' : 
                                           ($transaksi->metode_pembayaran == 'qris' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700') }}">
                                        {{ ucfirst($transaksi->metode_pembayaran) }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @if($transaksi_terbaru->isEmpty())
                        <div class="text-center py-12">
                            <i class="fas fa-receipt text-4xl text-gray-300 mb-3"></i>
                            <p class="text-sm text-gray-500">Belum ada transaksi</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Best Selling Products -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="px-5 py-4 border-b border-gray-200">
                        <h3 class="text-base font-semibold text-gray-900">Produk Terlaris Bulan Ini</h3>
                    </div>
                    <div class="p-5">
                        <div class="space-y-3 custom-scrollbar" style="max-height: 400px; overflow-y: auto;">
                            @foreach($produk_terlaris as $produk)
                            <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $produk->gambar_url }}" alt="{{ $produk->nama_produk }}" 
                                        class="w-12 h-12 rounded-lg object-cover border border-gray-200">
                                    <div>
                                        <p class="font-medium text-sm text-gray-900">{{ $produk->nama_produk }}</p>
                                        <p class="text-xs text-gray-500 mt-1">Terjual: {{ $produk->total_terjual ?? 0 }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-semibold text-gray-900">
                                        Rp {{ number_format($produk->total_pendapatan ?? 0, 0, ',', '.') }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        @ Rp {{ number_format($produk->harga_dasar, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @if($produk_terlaris->isEmpty())
                        <div class="text-center py-12">
                            <i class="fas fa-chart-line text-4xl text-gray-300 mb-3"></i>
                            <p class="text-sm text-gray-500">Belum ada data penjualan</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Low Stock Alert -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="px-5 py-4 border-b border-gray-200">
                        <h3 class="text-base font-semibold text-gray-900">Stok Menipis</h3>
                    </div>
                    <div class="p-5">
                        <div class="space-y-3 custom-scrollbar" style="max-height: 350px; overflow-y: auto;">
                            @foreach($produk_stok_rendah as $produk)
                            <div class="flex items-center justify-between p-3 bg-red-50 border border-red-100 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-exclamation text-red-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-sm text-gray-900">{{ $produk->nama_produk }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $produk->kode_produk }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-semibold text-red-600">{{ $produk->stok_sekarang }} {{ $produk->satuan }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Stok tersisa</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @if($produk_stok_rendah->isEmpty())
                        <div class="text-center py-12">
                            <i class="fas fa-check-circle text-4xl text-gray-300 mb-3"></i>
                            <p class="text-sm text-gray-500">Semua stok aman</p>
                        </div>
                        @else
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <a href="{{ route('admin.produk.index') }}" class="text-gray-700 hover:text-gray-900 text-sm font-medium flex items-center gap-1">
                                Lihat semua stok 
                                <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Stock Movements -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="px-5 py-4 border-b border-gray-200">
                        <h3 class="text-base font-semibold text-gray-900">Perubahan Stok Terbaru</h3>
                    </div>
                    <div class="p-5">
                        <div class="space-y-3 custom-scrollbar" style="max-height: 350px; overflow-y: auto;">
                            @foreach($stok_perubahan as $stok)
                            <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                                <div>
                                    <p class="font-medium text-sm text-gray-900">{{ $stok->produk->nama_produk }}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ ucfirst($stok->jenis_perubahan) }} • 
                                        {{ $stok->tanggal_perubahan->format('H:i') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-semibold 
                                        {{ $stok->qty_masuk > 0 ? 'text-gray-700' : 'text-red-600' }}">
                                        {{ $stok->qty_masuk > 0 ? '+' : '' }}{{ $stok->qty_masuk - $stok->qty_keluar }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Stok: {{ $stok->qty_akhir }}
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @if($stok_perubahan->isEmpty())
                        <div class="text-center py-12">
                            <i class="fas fa-boxes text-4xl text-gray-300 mb-3"></i>
                            <p class="text-sm text-gray-500">Belum ada perubahan stok</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                <a href="{{ route('admin.produk.create') }}" class="bg-white border border-gray-200 p-5 rounded-lg shadow-sm text-center hover:border-blue-300 hover:bg-blue-50 transition-all group">
                    <i class="fas fa-plus-circle text-gray-600 group-hover:text-blue-600 text-2xl mb-3 transition-colors"></i>
                    <p class="font-semibold text-sm text-gray-900">Tambah Produk</p>
                    <p class="text-xs text-gray-500 mt-1">Produk baru</p>
                </a>
                <a href="{{ route('admin.level-harga.index') }}" class="bg-white border border-gray-200 p-5 rounded-lg shadow-sm text-center hover:border-purple-300 hover:bg-purple-50 transition-all group">
                    <i class="fas fa-tags text-gray-600 group-hover:text-purple-600 text-2xl mb-3 transition-colors"></i>
                    <p class="font-semibold text-sm text-gray-900">Kelola Harga</p>
                    <p class="text-xs text-gray-500 mt-1">Level harga</p>
                </a>
                <a href="{{ route('admin.pelanggan.create') }}" class="bg-white border border-gray-200 p-5 rounded-lg shadow-sm text-center hover:border-green-300 hover:bg-green-50 transition-all group">
                    <i class="fas fa-user-plus text-gray-600 group-hover:text-green-600 text-2xl mb-3 transition-colors"></i>
                    <p class="font-semibold text-sm text-gray-900">Tambah Member</p>
                    <p class="text-xs text-gray-500 mt-1">Pelanggan baru</p>
                </a>
                <a href="{{ route('admin.laporan.index') }}" class="bg-white border border-gray-200 p-5 rounded-lg shadow-sm text-center hover:border-orange-300 hover:bg-orange-50 transition-all group">
                    <i class="fas fa-file-export text-gray-600 group-hover:text-orange-600 text-2xl mb-3 transition-colors"></i>
                    <p class="font-semibold text-sm text-gray-900">Generate Laporan</p>
                    <p class="text-xs text-gray-500 mt-1">PDF/Excel</p>
                </a>
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

        // Revenue Chart
        const revenueData = @json($revenueData);
        
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: revenueData.map(item => item.date),
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: revenueData.map(item => item.revenue),
                    borderColor: '#22c55e',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000000) {
                                    return 'Rp ' + (value / 1000000).toFixed(1) + 'JT';
                                }
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });

        // Period filter
        $('.period-btn').click(function() {
            const period = $(this).data('period');
            
            // Update active button
            $('.period-btn').removeClass('bg-green-400 text-gray-900 font-semibold').addClass('bg-gray-100 text-gray-700 font-medium');
            $(this).removeClass('bg-gray-100 text-gray-700 font-medium').addClass('bg-green-400 text-gray-900 font-semibold');
            
            // Fetch new data
            $.ajax({
                url: '{{ route("admin.dashboard.data") }}',
                method: 'GET',
                data: { period: period },
                success: function(data) {
                    revenueChart.data.labels = data.map(item => item.date);
                    revenueChart.data.datasets[0].data = data.map(item => item.revenue);
                    revenueChart.update();
                }
            });
        });

        // Auto refresh every 30 seconds
        setInterval(() => {
            $.ajax({
                url: '{{ route("admin.dashboard.data") }}',
                method: 'GET',
                data: { period: 'week' },
                success: function(data) {
                    revenueChart.data.labels = data.map(item => item.date);
                    revenueChart.data.datasets[0].data = data.map(item => item.revenue);
                    revenueChart.update();
                }
            });
        }, 30000);
    </script>
</body>
</html>