<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Admin - POS System</title> <!-- Judul diubah -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Script chart & jQuery tetap dimuat, mungkin diperlukan untuk halaman lain -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Anda dapat menambahkan font kustom di sini jika diperlukan */
        /* body { font-family: 'Inter', sans-serif; } */
    </style>
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
                    <!-- Pastikan variabel auth() tersedia di view ini -->
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
                    <a href="{{ route('admin.dashboard') }}" 
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg"> <!-- Kelas aktif dihapus -->
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
                    <!-- 
                      PERUBAHAN: Link href di bawah ini sudah diperbarui 
                      sesuai saran di chat sebelumnya (menggunakan nama route).
                    -->
                    <a href="{{ route('admin.laporan.index') }}" 
                       class="flex items-center px-4 py-3 bg-blue-100 text-blue-700 rounded-lg"> <!-- Kelas aktif ditambahkan -->
                        <i class="fas fa-chart-bar mr-3"></i>
                        Laporan
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <!-- Konten dashboard diganti dengan konten laporan -->
        <div class="flex-1 p-8">
            
            <!-- Judul Halaman -->
            <h1 class="text-3xl font-bold text-gray-800 mb-8">Laporan</h1>

            <!-- Wrapper untuk semua grup laporan -->
            <div class="space-y-10">

                <!-- Bagian: Penjualan -->
                <section>
                    <h2 class="text-xl font-semibold text-gray-700 mb-4">Penjualan</h2>
                    <div class="flex flex-wrap gap-5">
                        <!-- Kartu Laporan -->
                        <a href="#" class="w-36 h-36 md:w-40 md:h-40 bg-gray-700 hover:bg-gray-800 text-white rounded-lg shadow-md p-4 flex flex-col justify-center items-center text-center transition-all duration-300">
                            <svg class="w-12 h-12 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.5H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                            <span class="font-medium text-sm md:text-base">Transaksi</span>
                        </a>

                        <!-- ================================================== -->
                        <!-- PERUBAHAN DI SINI: href diperbarui dari # -->
                        <!-- ================================================== -->
                        <a href="{{ route('admin.laporan.transaksi.form') }}" class="w-36 h-36 md:w-40 md:h-40 bg-gray-700 hover:bg-gray-800 text-white rounded-lg shadow-md p-4 flex flex-col justify-center items-center text-center transition-all duration-300">
                            <svg class="w-12 h-12 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.5H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                            <span class="font-medium text-sm md:text-base">Data Transaksi</span>
                        </a>
                        <!-- ================================================== -->

                        <!-- Kartu Laporan -->
                        <a href="#" class="w-36 h-36 md:w-40 md:h-40 bg-gray-700 hover:bg-gray-800 text-white rounded-lg shadow-md p-4 flex flex-col justify-center items-center text-center transition-all duration-300">
                            <svg class="w-12 h-12 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.5H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                            <span class="font-medium text-sm md:text-base">Penjualan Barang</span>
                        </a>

                        <!-- Kartu Laporan -->
                        <a href="#" class="w-36 h-36 md:w-40 md:h-40 bg-gray-700 hover:bg-gray-800 text-white rounded-lg shadow-md p-4 flex flex-col justify-center items-center text-center transition-all duration-300">
                            <svg class="w-12 h-12 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.5H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                            <span class="font-medium text-sm md:text-base">Penjualan Kategori</span>
                        </a>
                    </div>
                </section>

                <!-- Bagian: Pembelian -->
                <section>
                    <h2 class="text-xl font-semibold text-gray-700 mb-4">Pembelian</h2>
                    <div class="flex flex-wrap gap-5">
                        <!-- Kartu Laporan -->
                        <a href="#" class="w-36 h-36 md:w-40 md:h-40 bg-gray-700 hover:bg-gray-800 text-white rounded-lg shadow-md p-4 flex flex-col justify-center items-center text-center transition-all duration-300">
                            <svg class="w-12 h-12 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.5H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                            <span class="font-medium text-sm md:text-base">Pembelian</span>
                        </a>

                        <!-- Kartu Laporan -->
                        <a href="#" class="w-36 h-36 md:w-40 md:h-40 bg-gray-700 hover:bg-gray-800 text-white rounded-lg shadow-md p-4 flex flex-col justify-center items-center text-center transition-all duration-300">
                            <svg class="w-12 h-12 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.5H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                            <span class="font-medium text-sm md:text-base">Data Pembelian</span>
                        </a>
                    </div>
                </section>

                <!-- Bagian: Laba Rugi -->
                <section>
                    <h2 class="text-xl font-semibold text-gray-700 mb-4">Laba Rugi</h2>
                    <div class="flex flex-wrap gap-5">
                        <!-- Kartu Laporan -->
                        <a href="#" class="w-36 h-36 md:w-40 md:h-40 bg-gray-700 hover:bg-gray-800 text-white rounded-lg shadow-md p-4 flex flex-col justify-center items-center text-center transition-all duration-300">
                            <svg class="w-12 h-12 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.5H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                            <span class="font-medium text-sm md:text-base">Laba Rugi</span>
                        </a>
                    </div>
                </section>

                <!-- Bagian: Keuangan -->
                <section>
                    <h2 class="text-xl font-semibold text-gray-700 mb-4">Keuangan</h2>
                    <div class="flex flex-wrap gap-5">
                        <!-- Kartu Laporan -->
                        <a href="#" class="w-36 h-36 md:w-40 md:h-40 bg-gray-700 hover:bg-gray-800 text-white rounded-lg shadow-md p-4 flex flex-col justify-center items-center text-center transition-all duration-300">
                            <svg class="w-12 h-12 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.5H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                            <span class="font-medium text-sm md:text-base">Laba Rugi</span>
                        </a>
                    </div>
                </section>

            </div> <!-- akhir wrapper grup -->

        </div>
    </div>
    
    <!-- 
      Script untuk chart dashboard dihapus dari halaman ini 
      karena tidak ada chart di halaman laporan.
    -->

</body>
</html>