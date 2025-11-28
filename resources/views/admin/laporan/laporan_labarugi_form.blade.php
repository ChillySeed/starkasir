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
<body class="bg-gray-100">
    <!-- Navbar & Sidebar (Sama seperti sebelumnya) -->
    <nav class="bg-purple-600 text-white shadow-lg no-print">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <div class="font-bold text-xl"><i class="fas fa-chart-pie mr-2"></i>POS - Laba Rugi</div>
            <form method="POST" action="{{ route('logout') }}"> @csrf <button type="submit">Logout</button></form>
        </div>
    </nav>

    <div class="flex">
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
            <h1 class="text-3xl font-bold text-gray-800 mb-8">Laporan Laba Rugi</h1>

            <div class="bg-white rounded-lg shadow-lg p-6 md:p-8">
                <form action="{{ route('admin.laporan.labarugi.generate') }}" method="GET" id="filterForm">
                    <h2 class="text-xl font-semibold text-gray-700 mb-4">Filter Periode</h2>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <button type="button" id="btnHariIni" class="px-4 py-2 bg-purple-100 text-purple-700 rounded-lg text-sm font-medium">Hari Ini</button>
                        <button type="button" id="btnBulanIni" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium">Bulan Ini</button>
                        <button type="button" id="btnBulanLalu" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium">Bulan Lalu</button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="w-full px-3 py-2 border rounded-lg" value="{{ date('Y-m-d') }}">
                        <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="w-full px-3 py-2 border rounded-lg" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="flex items-center justify-end gap-4">
                        <button type="submit" name="action" value="pdf" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            <i class="fas fa-file-pdf mr-2"></i>Download PDF
                        </button>
                        <button type="button" id="showReportBtn" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                            <i class="fas fa-chart-line mr-2"></i>Hitung Laba Rugi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL HASIL LABA RUGI (Lebih Lebar untuk Tabel Rincian) -->
    <div id="reportModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-start pt-10 z-50 overflow-y-auto">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-6xl flex flex-col mb-10">
            <div class="flex justify-between items-center p-4 border-b no-print sticky top-0 bg-white z-10 rounded-t-lg">
                <h3 class="text-lg font-medium">Detail Laba Rugi</h3>
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
                <button id="printReport" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">Cetak</button>
                <button id="closeReportSecondary" class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Tutup</button>
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
            // Helper Tanggal
            const tglMulai = $('#tanggal_mulai');
            const tglAkhir = $('#tanggal_akhir');
            function setDate(d1, d2) { tglMulai.val(d1); tglAkhir.val(d2); }
            const today = new Date().toISOString().split('T')[0];
            $('#btnHariIni').click(() => setDate(today, today));
            $('#btnBulanIni').click(() => {
                const date = new Date();
                const first = new Date(date.getFullYear(), date.getMonth(), 1).toISOString().split('T')[0];
                setDate(first, today);
            });
            $('#btnBulanLalu').click(() => {
                const date = new Date();
                const first = new Date(date.getFullYear(), date.getMonth()-1, 1).toISOString().split('T')[0];
                const last = new Date(date.getFullYear(), date.getMonth(), 0).toISOString().split('T')[0];
                setDate(first, last);
            });

            // AJAX Logic
            $('#showReportBtn').click(function() {
                const formData = $('#filterForm').serialize();
                $('#reportModal').removeClass('hidden').addClass('flex');
                
                // Loading State
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

                        // 1. Isi Ringkasan
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

                        // 2. Isi Tabel Rincian Penjualan
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

                        // 3. Isi Tabel Rincian Pembelian
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