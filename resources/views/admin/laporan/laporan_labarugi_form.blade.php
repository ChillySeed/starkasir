<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Laba Rugi Detail - POS System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        @media print {
            body * { visibility: hidden; }
            #printArea, #printArea * { visibility: visible; }
            #printArea { position: absolute; left: 0; top: 0; width: 100%; padding: 20px; }
            .no-print { display: none !important; }
            nav, .sidebar-container { display: none !important; }
            /* Agar tabel rincian tercetak rapi bersebelahan jika muat, atau bawah-bawah */
            .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">
    <!-- Navigation -->
    <nav class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-center py-3">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/starlogo.png') }}" alt="Logo" class="h-10 w-auto">
                    <div class="w-px h-8 bg-gray-300"></div>
                    <h1 class="text-xl font-bold text-gray-900">Laporan Laba Rugi</h1>
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
        <div class="w-64 bg-white shadow-sm min-h-screen border-r border-gray-200 sidebar-container">
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
                        class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                        <i class="fas fa-user-friends mr-3 w-5"></i>
                        Data Pelanggan
                    </a>
                    <a href="{{ route('admin.laporan.index') }}" 
                        class="flex items-center px-4 py-3 bg-blue-50 text-blue-700 rounded-lg font-medium border border-blue-200">
                        <i class="fas fa-chart-bar mr-3 w-5 text-blue-600"></i>
                        Laporan
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Laporan Laba Rugi Detail</h2>
                    <p class="text-gray-600 mt-1">Analisis detail pendapatan, pengeluaran, dan laba bersih</p>
                </div>
                <a href="{{ route('admin.laporan.index') }}" 
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i>Kembali
                </a>
            </div>

            <div class="max-w-6xl">
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-base font-semibold text-gray-900">Filter Periode & Generate Laporan</h3>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.laporan.labarugi.generate') }}" method="GET" id="filterForm">
                            <!-- Filter Buttons -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-3">Pilih Periode</label>
                                <div class="flex flex-wrap gap-2">
                                    <button type="button" id="btnHariIni" 
                                        class="px-4 py-2 border rounded-lg text-sm font-medium transition-all periode-btn bg-white text-gray-700 border-gray-300 hover:border-blue-400 hover:bg-blue-50">
                                        <i class="fas fa-calendar-day mr-2"></i>Hari Ini
                                    </button>
                                    <button type="button" id="btnBulanIni" 
                                        class="px-4 py-2 border rounded-lg text-sm font-medium transition-all periode-btn bg-white text-gray-700 border-gray-300 hover:border-blue-400 hover:bg-blue-50">
                                        <i class="fas fa-calendar-alt mr-2"></i>Bulan Ini
                                    </button>
                                    <button type="button" id="btnBulanLalu" 
                                        class="px-4 py-2 border rounded-lg text-sm font-medium transition-all periode-btn bg-white text-gray-700 border-gray-300 hover:border-blue-400 hover:bg-blue-50">
                                        <i class="fas fa-calendar mr-2"></i>Bulan Lalu
                                    </button>
                                </div>
                            </div>

                            <!-- Date Input -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div>
                                    <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                                        value="{{ date('Y-m-d') }}">
                                </div>
                                <div>
                                    <label for="tanggal_akhir" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                                    <input type="date" name="tanggal_akhir" id="tanggal_akhir" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                                        value="{{ date('Y-m-d') }}">
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-center justify-end gap-3">
                                <button type="submit" name="action" value="pdf" 
                                    class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium flex items-center gap-2">
                                    <i class="fas fa-file-pdf"></i>Download PDF
                                </button>
                                <button type="button" id="showReportBtn" 
                                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium flex items-center gap-2">
                                    <i class="fas fa-chart-line"></i>Hitung Laba Rugi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Information Card -->
                <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="shrink-0">
                            <i class="fas fa-info-circle text-blue-600"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Informasi Laporan</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Laporan menampilkan rincian detail pemasukan dari penjualan dan pengeluaran dari pembelian</li>
                                    <li>Laba/Rugi Bersih = Total Pemasukan - Total Pengeluaran</li>
                                    <li>Anda dapat mengunduh laporan dalam format PDF untuk arsip</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL HASIL LABA RUGI -->
    <div id="reportModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-start pt-10 z-50 overflow-y-auto">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-6xl flex flex-col mb-10">
            <div class="flex justify-between items-center p-4 border-b no-print sticky top-0 bg-white z-10 rounded-t-lg">
                <h3 class="text-lg font-medium text-gray-900">Detail Laba Rugi</h3>
                <button id="closeReport" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times fa-lg"></i></button>
            </div>
            
            <div class="p-0">
                <div id="printArea" class="p-8">
                    <!-- Kop -->
                    <div class="text-center mb-8 pb-4 border-b-2 border-gray-200">
                        <h1 class="text-2xl font-bold text-gray-800 uppercase">INSPIRASI MEDIA KREATIF</h1>
                        <h2 class="text-lg text-gray-600 mt-1">LAPORAN LABA RUGI & RINCIAN</h2>
                        <p class="text-sm text-gray-500 mt-2" id="reportPeriode">Periode: -</p>
                    </div>

                    <!-- Bagian 1: Ringkasan Eksekutif -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                        <!-- Pendapatan Card -->
                        <div class="p-4 bg-green-50 rounded-lg border border-green-100 text-center">
                            <p class="text-sm text-green-600 font-medium uppercase mb-1">Total Pendapatan</p>
                            <p class="text-2xl font-bold text-green-700" id="valPendapatan">Rp 0</p>
                        </div>
                        <!-- Pengeluaran Card -->
                        <div class="p-4 bg-red-50 rounded-lg border border-red-100 text-center">
                            <p class="text-sm text-red-600 font-medium uppercase mb-1">Total Pengeluaran</p>
                            <p class="text-2xl font-bold text-red-700" id="valPengeluaran">- Rp 0</p>
                        </div>
                        <!-- Laba Bersih Card -->
                        <div class="p-4 bg-gray-100 rounded-lg border border-gray-200 text-center">
                            <p class="text-sm text-gray-600 font-medium uppercase mb-1">Laba / Rugi Bersih</p>
                            <p class="text-2xl font-extrabold text-gray-900" id="valLabaBersih">Rp 0</p>
                        </div>
                    </div>

                    <!-- Bagian 2: Rincian (Grid 2 Kolom) -->
                    <div class="detail-grid grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        <!-- Tabel Rincian Pemasukan -->
                        <div>
                            <h3 class="text-md font-bold text-green-700 mb-3 pb-2 border-b border-green-200">
                                <i class="fas fa-arrow-down mr-2"></i>Rincian Pemasukan (Penjualan)
                            </h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-xs">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-2 py-2 text-left font-medium text-gray-500">No. TRX</th>
                                            <th class="px-2 py-2 text-left font-medium text-gray-500">Tgl</th>
                                            <th class="px-2 py-2 text-right font-medium text-gray-500">Nominal</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tablePendapatan" class="divide-y divide-gray-100">
                                        <!-- Data JS -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Tabel Rincian Pengeluaran -->
                        <div>
                            <h3 class="text-md font-bold text-red-700 mb-3 pb-2 border-b border-red-200">
                                <i class="fas fa-arrow-up mr-2"></i>Rincian Pengeluaran (Pembelian)
                            </h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-xs">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-2 py-2 text-left font-medium text-gray-500">Faktur</th>
                                            <th class="px-2 py-2 text-left font-medium text-gray-500">Supplier</th>
                                            <th class="px-2 py-2 text-right font-medium text-gray-500">Nominal</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tablePengeluaran" class="divide-y divide-gray-100">
                                        <!-- Data JS -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div> <!-- End Grid -->

                </div>
            </div>
            
            <div class="flex justify-end items-center p-4 border-t gap-3 no-print bg-white rounded-b-lg sticky bottom-0">
                <button id="printReport" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    <i class="fas fa-print mr-2"></i>Cetak
                </button>
                <button id="closeReportSecondary" class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-medium">
                    <i class="fas fa-times mr-2"></i>Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        function formatNumber(number) {
            const num = parseFloat(number);
            return isNaN(num) ? '0' : new Intl.NumberFormat('id-ID').format(num);
        }
        function formatDate(dateStr) {
            if (!dateStr) return '-';
            return new Date(dateStr).toLocaleDateString('id-ID', {day:'2-digit', month:'2-digit', year:'2-digit'});
        }

        $(document).ready(function() {
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

            // Helper Tanggal
            const tglMulai = $('#tanggal_mulai');
            const tglAkhir = $('#tanggal_akhir');
            
            function setDate(d1, d2) { 
                tglMulai.val(d1); 
                tglAkhir.val(d2); 
            }
            
            function updateButtonStyles() {
                const start = tglMulai.val();
                const end = tglAkhir.val();
                $('.periode-btn').each(function() {
                    $(this).removeClass('bg-blue-600 text-white border-blue-600').addClass('bg-white text-gray-700 border-gray-300');
                });
            }
            
            const today = new Date().toISOString().split('T')[0];
            
            $('#btnHariIni').click(function() {
                setDate(today, today);
                updateButtonStyles();
                $(this).removeClass('bg-white text-gray-700 border-gray-300').addClass('bg-blue-600 text-white border-blue-600');
            });
            
            $('#btnBulanIni').click(function() {
                const date = new Date();
                const first = new Date(date.getFullYear(), date.getMonth(), 1).toISOString().split('T')[0];
                setDate(first, today);
                updateButtonStyles();
                $(this).removeClass('bg-white text-gray-700 border-gray-300').addClass('bg-blue-600 text-white border-blue-600');
            });
            
            $('#btnBulanLalu').click(function() {
                const date = new Date();
                const first = new Date(date.getFullYear(), date.getMonth()-1, 1).toISOString().split('T')[0];
                const last = new Date(date.getFullYear(), date.getMonth(), 0).toISOString().split('T')[0];
                setDate(first, last);
                updateButtonStyles();
                $(this).removeClass('bg-white text-gray-700 border-gray-300').addClass('bg-blue-600 text-white border-blue-600');
            });

            // AJAX Logic
            $('#showReportBtn').click(function() {
                const formData = $('#filterForm').serialize();
                $('#reportModal').removeClass('hidden').addClass('flex');
                
                $('#valPendapatan, #valPengeluaran, #valLabaBersih').text('...');
                $('#tablePendapatan').html('<tr><td colspan="3" class="text-center py-4 text-gray-400">Memuat data...</td></tr>');
                $('#tablePengeluaran').html('<tr><td colspan="3" class="text-center py-4 text-gray-400">Memuat data...</td></tr>');

                $.ajax({
                    url: "{{ route('admin.laporan.labarugi.generate') }}",
                    type: 'GET',
                    data: formData + "&action=json",
                    dataType: 'json',
                    success: function(response) {
                        const data = response.data;
                        const summary = data.summary;
                        const details = data.details;

                        $('#reportPeriode').text(`Periode: ${data.periode.mulai} s/d ${data.periode.akhir}`);
                        $('#valPendapatan').text('Rp ' + formatNumber(summary.pendapatan));
                        $('#valPengeluaran').text('- Rp ' + formatNumber(summary.pengeluaran));
                        
                        const laba = parseFloat(summary.laba_bersih);
                        let labaText = 'Rp ' + formatNumber(laba);
                        const labaElem = $('#valLabaBersih');
                        
                        if (laba < 0) {
                            labaElem.removeClass('text-gray-900 text-green-600').addClass('text-red-600');
                            labaText = '(Rugi) ' + labaText;
                        } else {
                            labaElem.removeClass('text-gray-900 text-red-600').addClass('text-green-600');
                        }
                        labaElem.text(labaText);

                        const tablePenjualan = $('#tablePendapatan');
                        tablePenjualan.empty();
                        if (details.penjualan && details.penjualan.length > 0) {
                            details.penjualan.forEach(item => {
                                tablePenjualan.append(`
                                    <tr>
                                        <td class="px-2 py-1 border-b border-gray-50">${item.kode_transaksi}</td>
                                        <td class="px-2 py-1 border-b border-gray-50 text-gray-500">${formatDate(item.tanggal_transaksi)}</td>
                                        <td class="px-2 py-1 border-b border-gray-50 text-right font-medium">Rp ${formatNumber(item.total_amount)}</td>
                                    </tr>
                                `);
                            });
                        } else {
                            tablePenjualan.html('<tr><td colspan="3" class="text-center py-4 text-gray-400 text-xs">Tidak ada transaksi penjualan.</td></tr>');
                        }

                        const tablePembelian = $('#tablePengeluaran');
                        tablePembelian.empty();
                        if (details.pembelian && details.pembelian.length > 0) {
                            details.pembelian.forEach(item => {
                                let supplierName = item.supplier ? item.supplier.nama : '-';
                                tablePembelian.append(`
                                    <tr>
                                        <td class="px-2 py-1 border-b border-gray-50">${item.no_faktur || '-'}</td>
                                        <td class="px-2 py-1 border-b border-gray-50 text-gray-500 truncate max-w-[100px]">${supplierName}</td>
                                        <td class="px-2 py-1 border-b border-gray-50 text-right font-medium">Rp ${formatNumber(item.total_biaya)}</td>
                                    </tr>
                                `);
                            });
                        } else {
                            tablePembelian.html('<tr><td colspan="3" class="text-center py-4 text-gray-400 text-xs">Tidak ada data pembelian.</td></tr>');
                        }

                    },
                    error: function() {
                        alert('Gagal mengambil data.');
                        $('#reportModal').addClass('hidden').removeClass('flex');
                    }
                });
            });

            $('#printReport').click(() => window.print());
            $('#closeReport, #closeReportSecondary').click(() => $('#reportModal').addClass('hidden').removeClass('flex'));
        });
    </script>
</body>
</html>