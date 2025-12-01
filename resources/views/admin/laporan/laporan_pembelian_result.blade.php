<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Laporan Pembelian - POS System</title>
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
                    <span>Halo, {{ auth()->user()->nama ?? 'Admin' }}</span>
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

    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg min-h-screen">
            <nav class="mt-6">
                <div class="px-4 space-y-2">
                    <a href="{{ route('admin.laporan.index') }}" class="flex items-center px-4 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                        <i class="fas fa-arrow-left mr-3"></i> Kembali ke Menu
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.produk.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-box mr-3"></i> Manajemen Produk
                    </a>
                    <a href="{{ route('admin.stok-barang.index') }}" 
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-warehouse mr-3"></i>
                        Riwayat Stok
                    </a>
                    <a href="{{ route('admin.level-harga.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-tags mr-3"></i> Level Harga
                    </a>
                    <a href="{{ route('admin.golongan.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-users mr-3"></i> Golongan Member
                    </a>
                    <a href="{{ route('admin.pelanggan.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-user-friends mr-3"></i> Data Pelanggan
                    </a>
                    <a href="{{ route('admin.laporan.index') }}" class="flex items-center px-4 py-3 bg-blue-100 text-blue-700 rounded-lg">
                        <i class="fas fa-chart-bar mr-3"></i> Laporan
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Hasil Laporan Pembelian (Stok Masuk)</h1>
                <a href="{{ route('admin.laporan.pembelian.form') }}" class="text-blue-600 hover:text-blue-800">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Filter
                </a>
            </div>

            <!-- Ringkasan Filter -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Filter Aktif:</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">Periode:</span>
                        <span class="font-medium text-gray-900">{{ request('tanggal_mulai') }} s/d {{ request('tanggal_akhir') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Jenis:</span>
                        <span class="font-medium text-gray-900">{{ request('jenis_perubahan') ?? 'Semua' }}</span>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            @php
                $totalQty = $stokMasuk->sum('qty_masuk');
                $totalNilai = $stokMasuk->sum(function($item) {
                    return $item->qty_masuk * $item->produk->harga_dasar;
                });
                $jenisCount = $stokMasuk->groupBy('jenis_perubahan')->map->count();
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-green-50 rounded-lg p-6 border border-green-200">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 rounded-lg">
                            <i class="fas fa-boxes text-green-600"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-green-600">Total Barang Masuk</p>
                            <p class="text-2xl font-bold text-green-700">{{ number_format($totalQty, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-blue-50 rounded-lg p-6 border border-blue-200">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <i class="fas fa-money-bill-wave text-blue-600"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-blue-600">Total Nilai Pembelian</p>
                            <p class="text-2xl font-bold text-blue-700">Rp {{ number_format($totalNilai, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-purple-50 rounded-lg p-6 border border-purple-200">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-100 rounded-lg">
                            <i class="fas fa-clipboard-list text-purple-600"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-purple-600">Jumlah Transaksi</p>
                            <p class="text-2xl font-bold text-purple-700">{{ $stokMasuk->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Hasil -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Qty Masuk</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Satuan</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if($stokMasuk->count() > 0)
                            @foreach($stokMasuk as $item)
                                @php
                                    $subtotal = $item->qty_masuk * $item->produk->harga_dasar;
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item->tanggal_perubahan->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $badgeClass = '';
                                            switch($item->jenis_perubahan) {
                                                case 'pembelian':
                                                    $badgeClass = 'bg-green-100 text-green-800';
                                                    $jenisLabel = 'Pembelian';
                                                    break;
                                                case 'adjustment_masuk':
                                                case 'adjustment':
                                                    $badgeClass = 'bg-blue-100 text-blue-800';
                                                    $jenisLabel = 'Adjustment';
                                                    break;
                                                case 'retur':
                                                    $badgeClass = 'bg-purple-100 text-purple-800';
                                                    $jenisLabel = 'Retur';
                                                    break;
                                                default:
                                                    $badgeClass = 'bg-gray-100 text-gray-800';
                                                    $jenisLabel = $item->jenis_perubahan;
                                            }
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">
                                            {{ $jenisLabel }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->produk->nama_produk }}</div>
                                        <div class="text-sm text-gray-500">{{ $item->produk->kode_produk }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                        {{ number_format($item->qty_masuk, 0, ',', '.') }} {{ $item->produk->satuan }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                        Rp {{ number_format($item->produk->harga_dasar, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $item->keterangan ?? '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-sm text-gray-500">
                                    Tidak ada data pembelian yang ditemukan untuk filter ini.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                    
                    @if($stokMasuk->count() > 0)
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="5" class="px-6 py-3 text-right text-sm font-medium text-gray-700 uppercase">Total Nilai Pembelian:</td>
                                <td class="px-6 py-3 text-right text-sm font-bold text-gray-900">
                                    Rp {{ number_format($totalNilai, 0, ',', '.') }}
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
</body>
</html>