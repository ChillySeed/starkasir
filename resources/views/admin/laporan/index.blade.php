<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Admin - POS System</title>
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

    <!-- Sidebar and Main Content -->
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg min-h-screen">
            <nav class="mt-6">
                <div class="px-4 space-y-2">
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
            
            <h1 class="text-3xl font-bold text-gray-800 mb-8">Menu Laporan</h1>

            <!-- Grid 3 Kolom untuk 3 Laporan Utama -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <!-- 1. Laporan Penjualan (Menggunakan Route Transaksi yang sudah kita buat) -->
                <a href="{{ route('admin.laporan.transaksi.form') }}" class="group block bg-white hover:bg-blue-50 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-blue-200">
                    <div class="p-6 flex flex-col items-center text-center h-full">
                        <div class="w-20 h-20 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <!-- Icon Penjualan/Transaksi -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800 group-hover:text-blue-700 mb-2">Laporan Penjualan</h2>
                        <p class="text-sm text-gray-500">
                            Rekap data transaksi penjualan harian, mingguan, atau bulanan. Termasuk detail metode pembayaran dan status.
                        </p>
                    </div>
                </a>

                <!-- 2. Laporan Pembelian (Belum ada route khusus, placeholder link) -->
                <!-- Nanti Anda bisa buat route('admin.laporan.pembelian.form') -->
                <a href="{{ route('admin.laporan.pembelian.form') }}" class="group block bg-white hover:bg-green-50 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-green-200">
                    <div class="p-6 flex flex-col items-center text-center h-full">
                        <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <!-- Icon Pembelian/Stok Masuk -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800 group-hover:text-green-700 mb-2">Laporan Pembelian</h2>
                        <p class="text-sm text-gray-500">
                            Rekap data pembelian stok barang (kulakan). Lihat pengeluaran untuk restock barang.
                        </p>
                    </div>
                </a>

                <!-- 3. Laporan Laba Rugi (Gabungan Keuangan & Laba Rugi) -->
                <!-- Nanti Anda bisa buat route('admin.laporan.labarugi.form') -->
                <a href="{{ route('admin.laporan.labarugi.form') }}" class="group block bg-white hover:bg-purple-50 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-purple-200">
                    <div class="p-6 flex flex-col items-center text-center h-full">
                        <div class="w-20 h-20 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <!-- Icon Laba Rugi/Grafik -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800 group-hover:text-purple-700 mb-2">Laporan Laba Rugi</h2>
                        <p class="text-sm text-gray-500">
                            Analisis keuntungan bersih dari selisih penjualan dan pembelian (HPP). Ringkasan kesehatan keuangan.
                        </p>
                    </div>
                </a>

            </div> 

        </div>
    </div>
</body>
</html>