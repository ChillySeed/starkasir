<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pembelian - POS System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F3F4F6;
        }
        @media print {
            body * {
                visibility: hidden;
            }
            #printArea, #printArea * {
                visibility: visible;
            }
            #printArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 10px;
                font-size: 12px;
            }
            .no-print {
                display: none !important;
            }
            nav, .sidebar-container { 
                display: none !important;
            }
        }
    </style>
</head>
<body class="text-gray-800">
    <!-- Navigation -->
    <nav class="bg-white border-b border-gray-200 shadow-sm no-print">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-center py-3">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/starlogo.png') }}" alt="Logo" class="h-10 w-auto">
                    <div class="w-px h-8 bg-gray-300"></div>
                    <h1 class="text-xl font-bold text-gray-900">Laporan Pembelian (Stok Masuk)</h1>
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
        <div class="w-64 bg-white shadow-sm min-h-screen border-r border-gray-200 no-print sidebar-container">
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
                    <h2 class="text-2xl font-bold text-gray-900">Laporan Data Pembelian (Stok Masuk)</h2>
                    <p class="text-gray-600 mt-1">Filter dan tampilkan laporan pembelian sesuai periode</p>
                </div>
                <a href="{{ route('admin.laporan.index') }}" 
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i>Kembali
                </a>
            </div>

            <div class="max-w-6xl mx-auto">
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-base font-semibold text-gray-900">Filter Laporan Pembelian</h3>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.laporan.pembelian.generate') }}" method="GET" id="filterForm">
                            
                            <!-- Filter Periode -->
                            <div class="mb-6">
                                <h4 class="text-sm font-semibold text-gray-900 mb-3">Filter Periode</h4>
                                <div class="flex flex-wrap gap-2">
                                    <button type="button" class="preset-btn px-4 py-2 bg-blue-500 text-white rounded-lg text-sm font-medium hover:bg-blue-600 transition-colors" id="btnHariIni">Hari Ini</button>
                                    <button type="button" class="preset-btn px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-300 transition-colors" id="btnKemarin">Kemarin</button>
                                    <button type="button" class="preset-btn px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-300 transition-colors" id="btn7Hari">7 Hari Terakhir</button>
                                    <button type="button" class="preset-btn px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-300 transition-colors" id="btnBulanIni">Bulan Ini</button>
                                    <button type="button" class="preset-btn px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-300 transition-colors" id="btnBulanLalu">Bulan Lalu</button>
                                </div>
                            </div>

                            <!-- Filter Tanggal Custom -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai *</label>
                                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" required
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                                        value="{{ date('Y-m-d') }}">
                                </div>
                                <div>
                                    <label for="tanggal_akhir" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir *</label>
                                    <input type="date" name="tanggal_akhir" id="tanggal_akhir" required
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                                        value="{{ date('Y-m-d') }}">
                                </div>
                            </div>

                            <!-- Filter Lainnya -->
                            <div class="mb-8">
                                <h4 class="text-sm font-semibold text-gray-900 mb-3">Filter Lainnya</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="jenis_perubahan" class="block text-sm font-medium text-gray-700 mb-1">Jenis Pembelian</label>
                                        <select name="jenis_perubahan" id="jenis_perubahan" 
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent cursor-pointer">
                                            <option value="">Semua Jenis</option>
                                            <option value="pembelian">Pembelian (Restock)</option>
                                            <option value="adjustment_masuk">Adjustment Masuk</option>
                                            <option value="adjustment">Adjustment</option>
                                            <option value="retur">Retur dari Pelanggan</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="flex items-center justify-end gap-3">
                                <button type="submit" name="action" value="pdf" class="bg-red-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-red-700 transition-colors flex items-center gap-2">
                                    <i class="fas fa-file-pdf"></i>Download PDF
                                </button>
                                <button type="button" id="showReportBtn" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-700 transition-colors flex items-center gap-2">
                                    <i class="fas fa-eye"></i>Tampilkan Laporan
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
                            <h3 class="text-sm font-medium text-blue-800">Informasi Filter</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Gunakan tombol preset untuk memilih periode dengan cepat</li>
                                    <li>Atau masukkan tanggal custom untuk periode spesifik</li>
                                    <li>Filter jenis pembelian untuk melihat tipe transaksi tertentu</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- MODAL LAPORAN -->
    <div id="reportModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-6xl max-h-[90vh] flex flex-col">
            <!-- Modal Header -->
            <div class="flex justify-between items-center p-4 border-b no-print">
                <h3 class="text-lg font-medium text-gray-900">Hasil Laporan Pembelian (Stok Masuk)</h3>
                <button id="closeReport" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times fa-lg"></i>
                </button>
            </div>

            <!-- Area Konten -->
            <div class="p-0 overflow-y-auto">
                <!-- Area Cetak -->
                <div id="printArea" class="p-6">
                    <!-- Header Laporan -->
                    <div class="flex justify-between items-start mb-4 pb-4 border-b-2 border-gray-700">
                        <div class="flex items-start">
                            <img src="https://placehold.co/80x80/4299E1/FFFFFF?text=LOGO" alt="Logo" class="w-16 h-16 mr-4 rounded">
                            <div>
                                <h1 class="text-lg font-bold text-gray-800 uppercase">STAR KASIR</h1>
                                <p class="text-xs text-gray-600">JL. AMBARUWO 69A NGAWI TIMUR</p>
                                <p class="text-xs text-gray-600">0361-2008044 / 0361-710963</p>
                            </div>
                        </div>
                        <div class="text-right text-xs">
                            <h2 class="text-lg font-bold text-gray-800">Laporan Pembelian (Stok Masuk)</h2>
                            <p class="font-medium text-gray-800" id="reportPeriode">Periode: -</p>
                            <p class="text-gray-600" id="reportFilters">Filter: -</p>
                        </div>
                    </div>

                    <!-- Summary Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6" id="summaryCards">
                        <!-- Summary akan diisi oleh JavaScript -->
                    </div>

                    <!-- Tabel Hasil Laporan -->
                    <table class="min-w-full divide-y divide-gray-200" style="font-size: 11px;">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Jenis</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Qty Masuk</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Harga Satuan</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="reportTableBody">
                            <tr>
                                <td colspan="7" class="p-8 text-center text-gray-500">Memuat data...</td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-gray-50 font-bold" id="reportTableFoot">
                            <tr>
                                <td colspan="5" class="px-4 py-2 text-right uppercase">Total Nilai Pembelian:</td>
                                <td class="px-4 py-2 text-right" id="reportTotal">Rp 0</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end items-center p-4 border-t gap-3 no-print">
                <button id="printReport" class="bg-green-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-green-700 transition-colors flex items-center gap-2">
                    <i class="fas fa-print"></i>Cetak
                </button>
                <button id="closeReportSecondary" class="bg-gray-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-gray-700 transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        // Helper untuk format angka
        function formatNumber(number) {
            const num = parseFloat(number);
            if (isNaN(num)) {
                return '0';
            }
            return new Intl.NumberFormat('id-ID').format(num);
        }

        // Helper untuk format tanggal
        function formatDate(dateStr) {
            if (!dateStr) return 'N/A';
            const date = new Date(dateStr);
            const options = {
                day: '2-digit', month: 'short', year: 'numeric',
                hour: '2-digit', minute: '2-digit'
            };
            return date.toLocaleDateString('id-ID', options).replace(/\./g, ':');
        }

        // Helper untuk format tanggal pendek
        function formatDateShort(dateStr) {
            if (!dateStr) return 'N/A';
            const date = new Date(dateStr);
            return date.toLocaleDateString('id-ID', {
                day: '2-digit', month: 'short', year: 'numeric'
            });
        }

        // Helper untuk mendapatkan label jenis perubahan
        function getJenisLabel(jenis) {
            const jenisMap = {
                'pembelian': 'Pembelian',
                'adjustment_masuk': 'Adjustment Masuk',
                'adjustment': 'Adjustment',
                'retur': 'Retur Pelanggan',
                'lainnya': 'Lainnya'
            };
            return jenisMap[jenis] || jenis;
        }

        $(document).ready(function() {
            const tglMulai = $('#tanggal_mulai');
            const tglAkhir = $('#tanggal_akhir');
            const presetBtns = $('.preset-btn');
            let activePresetBtn = $('#btnHariIni');
            
            function setTanggal(mulai, akhir) {
                tglMulai.val(mulai);
                tglAkhir.val(akhir);
            }

            // Fungsi helper untuk format YYYY-MM-DD
            function formatDateYMD(date) {
                return date.toISOString().split('T')[0];
            }

            function updatePresetBtnStyle(btn) {
                presetBtns.removeClass('bg-blue-500 text-white hover:bg-blue-600').addClass('bg-gray-200 text-gray-700 hover:bg-gray-300');
                btn.removeClass('bg-gray-200 text-gray-700 hover:bg-gray-300').addClass('bg-blue-500 text-white hover:bg-blue-600');
                activePresetBtn = btn;
            }

            const today = new Date();
            setTanggal(formatDateYMD(today), formatDateYMD(today));

            $('#btnHariIni').click(function() {
                const now = new Date();
                setTanggal(formatDateYMD(now), formatDateYMD(now));
                updatePresetBtnStyle($(this));
            });
            
            $('#btnKemarin').click(function() {
                const yesterday = new Date();
                yesterday.setDate(today.getDate() - 1);
                setTanggal(formatDateYMD(yesterday), formatDateYMD(yesterday));
                updatePresetBtnStyle($(this));
            });
            
            $('#btn7Hari').click(function() {
                const last7 = new Date();
                last7.setDate(today.getDate() - 6);
                setTanggal(formatDateYMD(last7), formatDateYMD(today));
                updatePresetBtnStyle($(this));
            });
            
            $('#btnBulanIni').click(function() {
                const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
                setTanggal(formatDateYMD(startOfMonth), formatDateYMD(today));
                updatePresetBtnStyle($(this));
            });
            
            $('#btnBulanLalu').click(function() {
                const startOfLastMonth = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                const endOfLastMonth = new Date(today.getFullYear(), today.getMonth(), 0);
                setTanggal(formatDateYMD(startOfLastMonth), formatDateYMD(endOfLastMonth));
                updatePresetBtnStyle($(this));
            });

            // Reset preset style ketika tanggal manual diubah
            tglMulai.add(tglAkhir).on('change', function() {
                presetBtns.removeClass('bg-blue-500 text-white hover:bg-blue-600').addClass('bg-gray-200 text-gray-700 hover:bg-gray-300');
                activePresetBtn = null;
            });

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

            // Tampilkan Laporan (via AJAX)
            $('#showReportBtn').click(function() {
                const formData = $('#filterForm').serialize();
                
                $('#reportTableBody').html('<tr><td colspan="7" class="p-8 text-center text-gray-500"><i class="fas fa-spinner fa-spin mr-2"></i>Memuat data laporan...</td></tr>');
                $('#summaryCards').html('<div class="col-span-3 p-4 text-center"><i class="fas fa-spinner fa-spin mr-2"></i>Memuat summary...</div>');
                $('#reportTotal').text('Menghitung...');
                
                $('#reportModal').removeClass('hidden').addClass('flex');

                $.ajax({
                    url: "{{ route('admin.laporan.pembelian.generate') }}",
                    type: 'GET',
                    data: formData + "&action=json",
                    dataType: 'json',
                    success: function(response) {
                        populatePembelianReportModal(response);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("AJAX Error:", textStatus, errorThrown, jqXHR);
                        $('#reportTableBody').html('<tr><td colspan="7" class="p-8 text-center text-red-500">Gagal mengambil data. Cek console (F12) untuk detail.</td></tr>');
                    }
                });
            });

            // Fungsi untuk mengisi modal dengan data pembelian
            function populatePembelianReportModal(data) {
                const tableBody = $('#reportTableBody');
                const summaryCards = $('#summaryCards');
                tableBody.empty();

                // Isi info header
                $('#reportPeriode').text(`Periode: ${formatDateShort(data.filters.tanggal_mulai)} s/d ${formatDateShort(data.filters.tanggal_akhir)}`);
                let filterText = `Jenis: ${data.filters.jenis_perubahan || 'Semua'}`;
                $('#reportFilters').text(filterText);

                if (data.stok_masuk && data.stok_masuk.length > 0) {
                    let totalNilai = 0;
                    let totalQty = 0;
                    let jenisCount = {};
                    let produkCount = new Set();

                    data.stok_masuk.forEach(function(item) {
                        // Hitung subtotal
                        const subtotal = item.qty_masuk * item.produk.harga_dasar;
                        totalNilai += subtotal;
                        totalQty += item.qty_masuk;
                        
                        // Hitung jumlah per jenis
                        if (!jenisCount[item.jenis_perubahan]) {
                            jenisCount[item.jenis_perubahan] = 0;
                        }
                        jenisCount[item.jenis_perubahan]++;
                        
                        // Tambah produk ke set
                        produkCount.add(item.produk_id);

                        // Tentukan warna badge berdasarkan jenis
                        let badgeClass = '';
                        switch(item.jenis_perubahan) {
                            case 'pembelian':
                                badgeClass = 'bg-green-100 text-green-800';
                                break;
                            case 'adjustment_masuk':
                            case 'adjustment':
                                badgeClass = 'bg-blue-100 text-blue-800';
                                break;
                            case 'retur':
                                badgeClass = 'bg-purple-100 text-purple-800';
                                break;
                            default:
                                badgeClass = 'bg-gray-100 text-gray-800';
                        }

                        const row = `
                            <tr>
                                <td class="px-4 py-2 whitespace-nowrap">${formatDate(item.tanggal_perubahan)}</td>
                                <td class="px-4 py-2 whitespace-nowrap">
                                    <span class="inline-block px-2 py-1 text-xs rounded-full ${badgeClass}">
                                        ${getJenisLabel(item.jenis_perubahan)}
                                    </span>
                                </td>
                                <td class="px-4 py-2">
                                    <div class="font-medium">${item.produk.nama_produk}</div>
                                    <div class="text-xs text-gray-500">${item.produk.kode_produk}</div>
                                </td>
                                <td class="px-4 py-2 text-right">${formatNumber(item.qty_masuk)} ${item.produk.satuan}</td>
                                <td class="px-4 py-2 text-right">Rp ${formatNumber(item.produk.harga_dasar)}</td>
                                <td class="px-4 py-2 text-right">Rp ${formatNumber(subtotal)}</td>
                                <td class="px-4 py-2 text-sm text-gray-500 max-w-xs">${item.keterangan || '-'}</td>
                            </tr>
                        `;
                        tableBody.append(row);
                    });

                    // Buat summary dari data
                    const jenisLabels = Object.keys(jenisCount).map(jenis => 
                        `${getJenisLabel(jenis)}: ${jenisCount[jenis]}`
                    ).join(', ');

                    // Update Summary Cards
                    summaryCards.html(`
                        <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                            <div class="flex items-center">
                                <div class="p-3 bg-green-100 rounded-lg">
                                    <i class="fas fa-boxes text-green-600"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm text-green-600">Total Barang Masuk</p>
                                    <p class="text-2xl font-bold text-green-700">${formatNumber(totalQty)}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                            <div class="flex items-center">
                                <div class="p-3 bg-blue-100 rounded-lg">
                                    <i class="fas fa-money-bill-wave text-blue-600"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm text-blue-600">Total Nilai Pembelian</p>
                                    <p class="text-2xl font-bold text-blue-700">Rp ${formatNumber(totalNilai)}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-4 border border-purple-200">
                            <div class="flex items-center">
                                <div class="p-3 bg-purple-100 rounded-lg">
                                    <i class="fas fa-clipboard-list text-purple-600"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm text-purple-600">Jumlah Transaksi</p>
                                    <p class="text-2xl font-bold text-purple-700">${data.stok_masuk.length}</p>
                                    <p class="text-xs text-purple-600 mt-1">${jenisLabels}</p>
                                </div>
                            </div>
                        </div>
                    `);

                    // Update Total
                    $('#reportTotal').text('Rp ' + formatNumber(totalNilai));
                } else {
                    tableBody.html('<tr><td colspan="7" class="p-8 text-center text-gray-500">Tidak ada data pembelian untuk filter ini.</td></tr>');
                    summaryCards.html('<div class="col-span-3 p-4 text-center text-gray-500">Tidak ada data summary.</div>');
                    $('#reportTotal').text('Rp 0');
                }
            }

            // Tombol Cetak
            $('#printReport').click(function() {
                window.print();
            });

            // Tombol Tutup Modal
            $('#closeReport, #closeReportSecondary').click(function() {
                $('#reportModal').removeClass('flex').addClass('hidden');
            });
        });
    </script>
</body>
</html>