<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Laporan Transaksi - POS System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <!-- Layout Navbar dan Sidebar (Sama seperti file form) -->
    <!-- ... (Anda bisa @include layout utama Anda di sini) ... -->

    <!-- Main Content -->
    <div class="flex">
        <!-- Sidebar (Sama seperti file form) -->
        <div class="w-64 bg-white shadow-lg min-h-screen">
             <!-- ... (Isi sidebar Anda di sini) ... -->
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

        <div class="flex-1 p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Hasil Laporan Transaksi</h1>
                <a href="{{ route('admin.laporan.transaksi.form') }}" class="text-blue-600 hover:text-blue-800">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Filter
                </a>
            </div>

            <!-- Ringkasan Filter -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Filter Aktif:</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">Periode:</span>
                        <span class="font-medium text-gray-900">{{ request('tanggal_mulai') }} s/d {{ request('tanggal_akhir') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Metode:</span>
                        <span class="font-medium text-gray-900">{{ request('metode_pembayaran') ?? 'Semua' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Status:</span>
                        <span class="font-medium text-gray-900">{{ request('status') ?? 'Semua' }}</span>
                    </div>
                </div>
            </div>

            <!-- Tabel Hasil -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Transaksi</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- 
                            Looping data akan ada di sini.
                            Kita cek dulu apakah $transaksis ada dan tidak kosong.
                        -->
                        @if(isset($transaksis) && $transaksis->count() > 0)
                            @foreach($transaksis as $transaksi)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $transaksi->kode_transaksi }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaksi->tanggal_transaksi->format('d M Y, H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaksi->pelanggan->nama ?? 'Umum' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 capitalize">{{ $transaksi->metode_pembayaran }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($transaksi->status == 'lunas')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Lunas</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">{{ $transaksi->status }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">Rp {{ number_format($transaksi->total_amount, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        @else
                            <!-- Jika tidak ada data -->
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500">
                                    Tidak ada data transaksi yang ditemukan untuk filter ini.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                    
                    <!-- Footer Tabel (Total Keseluruhan) -->
                    @if(isset($transaksis) && $transaksis->count() > 0)
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="5" class="px-6 py-3 text-right text-sm font-medium text-gray-700 uppercase">Total Keseluruhan:</td>
                                <td class="px-6 py-3 text-right text-sm font-bold text-gray-900">
                                    Rp {{ number_format($transaksis->sum('total_amount'), 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
</body>
</html>