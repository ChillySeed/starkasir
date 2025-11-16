<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - POS System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                        <i class="fas fa-user-friends mr-3"></i>
                        Stok Barang
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
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Transaksi Hari Ini</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_transaksi_hari_ini'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 rounded-lg">
                            <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Pendapatan Hari Ini</p>
                            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($stats['total_pendapatan_hari_ini'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-100 rounded-lg">
                            <i class="fas fa-boxes text-purple-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Total Produk</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_produk'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-orange-100 rounded-lg">
                            <i class="fas fa-exclamation-triangle text-orange-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Stok Menipis</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['produk_habis'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Additional Stats -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Revenue Chart -->
                <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Pendapatan 7 Hari Terakhir</h3>
                        <div class="flex space-x-2">
                            <button class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded period-btn" data-period="week">7H</button>
                            <button class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded period-btn" data-period="month">30H</button>
                            <button class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded period-btn" data-period="year">1Th</button>
                        </div>
                    </div>
                    <div class="h-64">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <!-- Membership Distribution -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Distribusi Member</h3>
                    <div class="space-y-3">
                        @foreach($membership_distribution as $dist)
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">{{ $dist->nama_tier }}</span>
                            <div class="flex items-center">
                                <span class="text-sm font-medium mr-2">{{ $dist->total }}</span>
                                <div class="w-16 bg-gray-200 rounded-full h-2">
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
                            <span class="text-gray-600">Total Member:</span>
                            <span class="font-medium">{{ $membership_distribution->sum('total') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Transactions -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Transaksi Terbaru</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($transaksi_terbaru as $transaksi)
                            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $transaksi->kode_transaksi }}</p>
                                    <p class="text-sm text-gray-500">
                                        {{ $transaksi->pelanggan->nama ?? 'Umum' }} • 
                                        {{ $transaksi->tanggal_transaksi->format('H:i') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium text-gray-900">Rp {{ number_format($transaksi->total_amount, 0, ',', '.') }}</p>
                                    <span class="inline-block px-2 py-1 text-xs rounded 
                                        {{ $transaksi->metode_pembayaran == 'tunai' ? 'bg-green-100 text-green-800' : 
                                           ($transaksi->metode_pembayaran == 'qris' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800') }}">
                                        {{ $transaksi->metode_pembayaran }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @if($transaksi_terbaru->isEmpty())
                        <div class="text-center py-8">
                            <i class="fas fa-receipt text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-500">Belum ada transaksi</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Best Selling Products -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Produk Terlaris Bulan Ini</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($produk_terlaris as $produk)
                            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                <div class="flex items-center">
                                    <img src="{{ $produk->gambar_url }}" alt="{{ $produk->nama_produk }}" 
                                        class="w-10 h-10 rounded-lg object-cover">
                                    <div class="ml-4">
                                        <p class="font-medium text-gray-900">{{ $produk->nama_produk }}</p>
                                        <p class="text-sm text-gray-500">Terjual: {{ $produk->total_terjual ?? 0 }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900">
                                        Rp {{ number_format($produk->total_pendapatan ?? 0, 0, ',', '.') }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        Rp {{ number_format($produk->harga_dasar, 0, ',', '.') }}/pcs
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @if($produk_terlaris->isEmpty())
                        <div class="text-center py-8">
                            <i class="fas fa-chart-line text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-500">Belum ada data penjualan</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Low Stock Alert -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Stok Menipis</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            @foreach($produk_stok_rendah as $produk)
                            <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-exclamation text-red-600 text-sm"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="font-medium text-gray-900">{{ $produk->nama_produk }}</p>
                                        <p class="text-sm text-gray-500">{{ $produk->kode_produk }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-red-600">{{ $produk->stok_sekarang }} {{ $produk->satuan }}</p>
                                    <p class="text-xs text-gray-500">Stok tersisa</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @if($produk_stok_rendah->isEmpty())
                        <div class="text-center py-8">
                            <i class="fas fa-check-circle text-4xl text-green-400 mb-4"></i>
                            <p class="text-gray-500">Semua stok aman</p>
                        </div>
                        @else
                        <div class="mt-4">
                            <a href="{{ route('admin.produk.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Lihat semua stok →
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Stock Movements -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Perubahan Stok Terbaru</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            @foreach($stok_perubahan as $stok)
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $stok->produk->nama_produk }}</p>
                                    <p class="text-sm text-gray-500">
                                        {{ $stok->jenis_perubahan }} • 
                                        {{ $stok->tanggal_perubahan->format('H:i') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium 
                                        {{ $stok->qty_masuk > 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $stok->qty_masuk > 0 ? '+' : '' }}{{ $stok->qty_masuk - $stok->qty_keluar }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        Stok: {{ $stok->qty_akhir }}
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @if($stok_perubahan->isEmpty())
                        <div class="text-center py-8">
                            <i class="fas fa-boxes text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-500">Belum ada perubahan stok</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-4">
                <a href="{{ route('admin.produk.create') }}" class="bg-white p-4 rounded-lg shadow text-center hover:shadow-md transition-shadow">
                    <i class="fas fa-plus-circle text-blue-600 text-2xl mb-2"></i>
                    <p class="font-medium text-gray-900">Tambah Produk</p>
                    <p class="text-sm text-gray-500">Produk baru</p>
                </a>
                <a href="{{ route('admin.level-harga.index') }}" class="bg-white p-4 rounded-lg shadow text-center hover:shadow-md transition-shadow">
                    <i class="fas fa-tags text-green-600 text-2xl mb-2"></i>
                    <p class="font-medium text-gray-900">Kelola Harga</p>
                    <p class="text-sm text-gray-500">Level harga</p>
                </a>
                <a href="{{ route('admin.pelanggan.create') }}" class="bg-white p-4 rounded-lg shadow text-center hover:shadow-md transition-shadow">
                    <i class="fas fa-user-plus text-purple-600 text-2xl mb-2"></i>
                    <p class="font-medium text-gray-900">Tambah Member</p>
                    <p class="text-sm text-gray-500">Pelanggan baru</p>
                </a>
                <a href="#" class="bg-white p-4 rounded-lg shadow text-center hover:shadow-md transition-shadow">
                    <i class="fas fa-file-export text-orange-600 text-2xl mb-2"></i>
                    <p class="font-medium text-gray-900">Generate Laporan</p>
                    <p class="text-sm text-gray-500">PDF/Excel</p>
                </a>
            </div>
        </div>
    </div>

    <script>
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
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
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
            $('.period-btn').removeClass('bg-blue-100 text-blue-800').addClass('bg-gray-100 text-gray-800');
            $(this).removeClass('bg-gray-100 text-gray-800').addClass('bg-blue-100 text-blue-800');
            
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