<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pembelian - POS System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        /* CSS Khusus untuk Mencetak (Print) */
        @media print {
            body * { visibility: hidden; }
            #printArea, #printArea * { visibility: visible; }
            #printArea { position: absolute; left: 0; top: 0; width: 100%; padding: 10px; font-size: 12px; }
            .no-print { display: none !important; }
            nav, .sidebar-container { display: none !important; }
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-blue-600 text-white shadow-lg no-print">
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
        <div class="w-64 bg-white shadow-lg min-h-screen no-print sidebar-container">
            <nav class="mt-6 px-4 space-y-2">
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
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8 no-print">
            <h1 class="text-3xl font-bold text-gray-800 mb-8">Laporan Pembelian (Stok Masuk)</h1>

            <div class="bg-white rounded-lg shadow-lg p-6 md:p-8">
                <!-- Form Filter -->
                <form action="{{ route('admin.laporan.pembelian.generate') }}" method="GET" id="filterForm">
                    
                    <h2 class="text-xl font-semibold text-gray-700 mb-4">Filter Periode</h2>
                    <!-- Tombol Preset -->
                    <div class="flex flex-wrap gap-2 mb-4">
                        <button type="button" id="btnHariIni" class="px-4 py-2 bg-green-100 text-green-700 rounded-lg text-sm font-medium">Hari Ini</button>
                        <button type="button" id="btnBulanIni" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium">Bulan Ini</button>
                        <button type="button" id="btnBulanLalu" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium">Bulan Lalu</button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="w-full px-3 py-2 border rounded-lg" value="{{ date('Y-m-d') }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                            <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="w-full px-3 py-2 border rounded-lg" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status Pembayaran</label>
                            <select name="status" class="w-full px-3 py-2 border rounded-lg">
                                <option value="">Semua Status</option>
                                <option value="lunas">Lunas</option>
                                <option value="utang">Utang / Belum Lunas</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4">
                        <button type="submit" name="action" value="pdf" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            <i class="fas fa-file-pdf mr-2"></i>Download PDF
                        </button>
                        <button type="button" id="showReportBtn" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <i class="fas fa-eye mr-2"></i>Tampilkan Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL POP UP LAPORAN (Untuk Tampilan Hasil) -->
    <div id="reportModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] flex flex-col">
            <!-- Header Modal -->
            <div class="flex justify-between items-center p-4 border-b no-print">
                <h3 class="text-lg font-medium">Hasil Laporan Pembelian</h3>
                <button id="closeReport" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times fa-lg"></i></button>
            </div>
            
            <!-- Konten Laporan (Scrollable) -->
            <div class="p-0 overflow-y-auto">
                <div id="printArea" class="p-6">
                    <!-- Kop Laporan -->
                    <div class="flex justify-between items-start mb-4 pb-4 border-b-2 border-gray-700">
                        <div class="flex items-start">
                            <!-- Ganti src dengan logo Anda -->
                            <img src="https://placehold.co/80x80/4299E1/FFFFFF?text=LOGO" alt="Logo" class="w-16 h-16 mr-4 rounded">
                            <div>
                                <h1 class="text-lg font-bold text-gray-800 uppercase">INSPIRASI MEDIA KREATIF</h1>
                                <p class="text-xs text-gray-600">JL. MERTASARI 170B SIDOARJO</p>
                                <p class="text-xs text-gray-600">0361-2008044 / 0361-710963</p>
                            </div>
                        </div>
                        <div class="text-right text-xs">
                            <h2 class="text-lg font-bold text-gray-800">Laporan Pembelian</h2>
                            <p class="font-medium" id="reportPeriode">Periode: -</p>
                            <p class="text-gray-600" id="reportFilters">Filter: -</p>
                        </div>
                    </div>

                    <!-- Tabel Data -->
                    <table class="min-w-full divide-y divide-gray-200" style="font-size: 11px;">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">No. Faktur</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Supplier</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Total Biaya</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="reportTableBody">
                            <!-- Data akan diisi oleh JavaScript -->
                        </tbody>
                        <tfoot class="bg-gray-50 font-bold">
                            <tr>
                                <td colspan="4" class="px-4 py-2 text-right uppercase">Total Pengeluaran:</td>
                                <td class="px-4 py-2 text-right" id="reportTotal">Rp 0</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            
            <!-- Footer Modal -->
            <div class="flex justify-end items-center p-4 border-t gap-3 no-print">
                <button id="printReport" class="px-6 py-2 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition-colors">
                    <i class="fas fa-print mr-2"></i>Cetak
                </button>
                <button id="closeReportSecondary" class="px-6 py-2 bg-gray-600 text-white rounded-lg font-medium hover:bg-gray-700 transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Script JavaScript untuk Interaksi -->
    <script>
        function formatNumber(number) {
            const num = parseFloat(number);
            return isNaN(num) ? '0' : new Intl.NumberFormat('id-ID').format(num);
        }
        
        function formatDate(dateStr) {
            if (!dateStr) return '-';
            // Format tanggal Indonesia
            const options = { year: 'numeric', month: 'short', day: 'numeric' };
            return new Date(dateStr).toLocaleDateString('id-ID', options);
        }

        $(document).ready(function() {
            // --- Helper Tanggal Preset ---
            const tglMulai = $('#tanggal_mulai');
            const tglAkhir = $('#tanggal_akhir');
            
            function setDate(d1, d2) { tglMulai.val(d1); tglAkhir.val(d2); }
            
            const today = new Date().toISOString().split('T')[0];
            
            $('#btnHariIni').click(() => setDate(today, today));
            
            $('#btnBulanIni').click(() => {
                const date = new Date();
                const firstDay = new Date(date.getFullYear(), date.getMonth(), 1).toISOString().split('T')[0];
                setDate(firstDay, today);
            });
            
            $('#btnBulanLalu').click(() => {
                const date = new Date();
                const firstDay = new Date(date.getFullYear(), date.getMonth() - 1, 1).toISOString().split('T')[0];
                const lastDay = new Date(date.getFullYear(), date.getMonth(), 0).toISOString().split('T')[0];
                setDate(firstDay, lastDay);
            });

            // --- Logika AJAX (Tampilkan Laporan) ---
            $('#showReportBtn').click(function() {
                const formData = $('#filterForm').serialize();
                
                // Tampilkan status loading
                $('#reportTableBody').html('<tr><td colspan="5" class="p-8 text-center"><i class="fas fa-spinner fa-spin mr-2"></i>Memuat data...</td></tr>');
                $('#reportTotal').text('Menghitung...');
                $('#reportModal').removeClass('hidden').addClass('flex');

                // Panggil API Controller
                $.ajax({
                    url: "{{ route('admin.laporan.pembelian.generate') }}",
                    type: 'GET',
                    data: formData + "&action=json", // Flag JSON
                    dataType: 'json',
                    success: function(response) {
                        const tbody = $('#reportTableBody');
                        tbody.empty();
                        
                        // Update Info Header
                        $('#reportPeriode').text(`Periode: ${response.filters.tanggal_mulai} s/d ${response.filters.tanggal_akhir}`);
                        let filterText = response.filters.status ? `Status: ${response.filters.status}` : 'Status: Semua';
                        $('#reportFilters').text(filterText);

                        if (response.data && response.data.length > 0) {
                            let total = 0;
                            response.data.forEach(item => {
                                // PENTING: Gunakan parseFloat untuk penjumlahan yang benar
                                total += parseFloat(item.total_biaya);
                                
                                let supplierName = item.supplier ? item.supplier.nama : 'Umum'; 
                                let statusBadge = item.status == 'lunas' 
                                    ? '<span class="text-green-600 font-bold">Lunas</span>' 
                                    : '<span class="text-red-600 font-bold capitalize">' + item.status + '</span>';

                                tbody.append(`
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap">${item.no_faktur || '-'}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">${formatDate(item.tanggal_pembelian)}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">${supplierName}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">${statusBadge}</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-right">Rp ${formatNumber(item.total_biaya)}</td>
                                    </tr>
                                `);
                            });
                            // Update Total
                            $('#reportTotal').text('Rp ' + formatNumber(total));
                        } else {
                            // Jika Data Kosong
                            tbody.html('<tr><td colspan="5" class="p-8 text-center text-gray-500">Tidak ada data pembelian untuk filter ini.</td></tr>');
                            $('#reportTotal').text('Rp 0');
                        }
                    },
                    error: function(jqXHR) {
                        console.error(jqXHR);
                        $('#reportTableBody').html('<tr><td colspan="5" class="p-8 text-center text-red-500">Gagal mengambil data. Cek koneksi atau log server.</td></tr>');
                    }
                });
            });

            // Tombol Cetak
            $('#printReport').click(() => window.print());
            
            // Tombol Tutup
            $('#closeReport, #closeReportSecondary').click(() => $('#reportModal').addClass('hidden').removeClass('flex'));
        });
    </script>
</body>
</html>