<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filter Laporan Transaksi - POS System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
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
<body class="bg-gray-100 text-gray-800">
    <!-- Navigation -->
    <nav class="bg-white border-b border-gray-200 shadow-sm no-print">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-center py-3">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/starlogo.png') }}" alt="Logo" class="h-10 w-auto">
                    <div class="w-px h-8 bg-gray-300"></div>
                    <h1 class="text-xl font-bold text-gray-900">Laporan Data Transaksi</h1>
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
        <div class="w-64 bg-white shadow-sm min-h-screen border-r border-gray-200 sidebar-container no-print">
            <nav class="mt-6">
                <div class="px-4 space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                        <i class="fas fa-tachometer-alt mr-3 w-5"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.produk.index') }}" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                        <i class="fas fa-box mr-3 w-5"></i> Manajemen Produk
                    </a>
                    <a href="{{ route('admin.stok-barang.index') }}" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                        <i class="fas fa-warehouse mr-3 w-5"></i> Riwayat Stok
                    </a>
                    <a href="{{ route('admin.level-harga.index') }}" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                        <i class="fas fa-tags mr-3 w-5"></i> Level Harga
                    </a>
                    <a href="{{ route('admin.golongan.index') }}" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                        <i class="fas fa-users mr-3 w-5"></i> Golongan Member
                    </a>
                    <a href="{{ route('admin.pelanggan.index') }}" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                        <i class="fas fa-user-friends mr-3 w-5"></i> Data Pelanggan
                    </a>
                    <a href="{{ route('admin.laporan.index') }}" class="flex items-center px-4 py-3 bg-blue-50 text-blue-700 rounded-lg font-medium border border-blue-200">
                        <i class="fas fa-chart-bar mr-3 w-5 text-blue-600"></i> Laporan
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Filter Laporan Transaksi</h2>
                    <p class="text-gray-600 mt-1">Pilih periode dan filter untuk melihat laporan transaksi</p>
                </div>
                <a href="{{ route('admin.laporan.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors flex items-center gap-2 no-print">
                    <i class="fas fa-arrow-left"></i>Kembali
                </a>
            </div>

            <div class="max-w-4xl">
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-base font-semibold text-gray-900">Filter Laporan</h3>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.laporan.transaksi.generate') }}" method="GET" id="filterForm">
                            
                            <!-- Filter Periode -->
                            <div class="mb-6">
                                <h4 class="text-sm font-semibold text-gray-700 mb-3">Filter Periode</h4>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <button type="button" data-period="hari_ini" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium preset-btn hover:bg-blue-500 hover:text-white transition-colors">
                                        <i class="fas fa-calendar-day mr-1"></i>Hari Ini
                                    </button>
                                    <button type="button" data-period="kemarin" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium preset-btn hover:bg-blue-500 hover:text-white transition-colors">
                                        <i class="fas fa-calendar mr-1"></i>Kemarin
                                    </button>
                                    <button type="button" data-period="7_hari" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium preset-btn hover:bg-blue-500 hover:text-white transition-colors">
                                        <i class="fas fa-calendar-week mr-1"></i>7 Hari Terakhir
                                    </button>
                                    <button type="button" data-period="bulan_ini" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium preset-btn hover:bg-blue-500 hover:text-white transition-colors">
                                        <i class="fas fa-calendar-alt mr-1"></i>Bulan Ini
                                    </button>
                                    <button type="button" data-period="bulan_lalu" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium preset-btn hover:bg-blue-500 hover:text-white transition-colors">
                                        <i class="fas fa-calendar-alt mr-1"></i>Bulan Lalu
                                    </button>
                                </div>
                            </div>

                            <!-- Filter Tanggal Custom -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="{{ request('tanggal_mulai') }}">
                                </div>
                                <div>
                                    <label for="tanggal_akhir" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                                    <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="{{ request('tanggal_akhir') }}">
                                </div>
                            </div>

                            <!-- Filter Lainnya -->
                            <div class="mb-6">
                                <h4 class="text-sm font-semibold text-gray-700 mb-3">Filter Tambahan</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="metode_pembayaran" class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran</label>
                                        <select name="metode_pembayaran" id="metode_pembayaran" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent cursor-pointer">
                                            <option value="">Semua Metode</option>
                                            <option value="tunai" {{ request('metode_pembayaran') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                                            <option value="qris" {{ request('metode_pembayaran') == 'qris' ? 'selected' : '' }}>QRIS</option>
                                            <option value="transfer" {{ request('metode_pembayaran') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Transaksi</label>
                                        <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent cursor-pointer">
                                            <option value="">Semua Status</option>
                                            <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                                            <option value="batal" {{ request('status') == 'batal' ? 'selected' : '' }}>Batal</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="flex items-center justify-end gap-3">
                                <button type="submit" name="action" value="pdf" class="px-6 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition-colors flex items-center gap-2">
                                    <i class="fas fa-file-pdf"></i>Download PDF
                                </button>
                                <button type="button" id="showReportBtn" class="px-6 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors flex items-center gap-2">
                                    <i class="fas fa-eye"></i>Tampilkan Laporan
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================================== -->
    <!-- MODAL LAPORAN -->
    <!-- ========================================================== -->
    <div id="reportModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] flex flex-col">
            <!-- Modal Header -->
            <div class="flex justify-between items-center p-4 border-b no-print">
                <h3 class="text-lg font-medium text-gray-900">Hasil Laporan Transaksi</h3>
                <button id="closeReport" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times fa-lg"></i>
                </button>
            </div>

            <!-- Area Konten (Bisa di-scroll) -->
            <div class="p-0 overflow-y-auto flex-1">
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
                            <h2 class="text-lg font-bold text-gray-800">Daftar Transaksi</h2>
                            <p class="font-medium text-gray-800" id="reportPeriode">Periode: -</p>
                            <p class="text-gray-600" id="reportFilters">Filter: -</p>
                        </div>
                    </div>

                    <!-- Tabel Hasil Laporan -->
                    <table class="min-w-full divide-y divide-gray-200" style="font-size: 11px;">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">No. Transaksi</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Pelanggan</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Metode</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="reportTableBody">
                            <tr>
                                <td colspan="6" class="p-8 text-center text-gray-500">Memuat data...</td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-gray-50 font-bold" id="reportTableFoot">
                            <tr>
                                <td colspan="5" class="px-4 py-2 text-right uppercase">Total Keseluruhan:</td>
                                <td class="px-4 py-2 text-right" id="reportTotal">Rp 0</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end items-center p-4 border-t gap-3 no-print">
                <button id="printReport" class="px-6 py-2 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition-colors flex items-center gap-2">
                    <i class="fas fa-print"></i>Cetak
                </button>
                <button id="closeReportSecondary" class="px-6 py-2 bg-gray-600 text-white rounded-lg font-medium hover:bg-gray-700 transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        function formatNumber(number) {
            const num = parseFloat(number);
            if (isNaN(num)) return '0';
            return new Intl.NumberFormat('id-ID').format(num);
        }

        function formatDate(dateStr) {
            if (!dateStr) return 'N/A';
            const date = new Date(dateStr);
            const options = {
                day: '2-digit', month: 'short', year: 'numeric',
                hour: '2-digit', minute: '2-digit'
            };
            return date.toLocaleDateString('id-ID', options).replace(/\./g, ':');
        }

        $(document).ready(function() {
            // User Dropdown
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

            // Logika untuk Tombol Preset Tanggal
            const tglMulai = $('#tanggal_mulai');
            const tglAkhir = $('#tanggal_akhir');
            
            function formatDateYMD(date) {
                return date.toISOString().split('T')[0];
            }

            function setTanggal(mulai, akhir) {
                tglMulai.val(mulai);
                tglAkhir.val(akhir);
            }

            const today = new Date();
            setTanggal(formatDateYMD(today), formatDateYMD(today));

            // Logika Tombol Preset dengan State
            $('.preset-btn').click(function() {
                const period = $(this).data('period');
                let mulai, akhir;

                if (period === 'hari_ini') {
                    mulai = akhir = formatDateYMD(today);
                } else if (period === 'kemarin') {
                    const yesterday = new Date(today);
                    yesterday.setDate(today.getDate() - 1);
                    mulai = akhir = formatDateYMD(yesterday);
                } else if (period === '7_hari') {
                    const last7 = new Date(today);
                    last7.setDate(today.getDate() - 6);
                    mulai = formatDateYMD(last7);
                    akhir = formatDateYMD(today);
                } else if (period === 'bulan_ini') {
                    const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
                    mulai = formatDateYMD(startOfMonth);
                    akhir = formatDateYMD(today);
                } else if (period === 'bulan_lalu') {
                    const startOfLastMonth = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                    const endOfLastMonth = new Date(today.getFullYear(), today.getMonth(), 0);
                    mulai = formatDateYMD(startOfLastMonth);
                    akhir = formatDateYMD(endOfLastMonth);
                }

                setTanggal(mulai, akhir);

                // Update styling - aktifkan tombol yang diklik
                $('.preset-btn').removeClass('bg-blue-500 text-white').addClass('bg-gray-100 text-gray-700');
                $(this).removeClass('bg-gray-100 text-gray-700').addClass('bg-blue-500 text-white');
            });

            // Set button aktif saat form change
            $('#tanggal_mulai, #tanggal_akhir').change(function() {
                $('.preset-btn').removeClass('bg-blue-500 text-white').addClass('bg-gray-100 text-gray-700');
            });

            // Tampilkan Laporan (via AJAX)
            $('#showReportBtn').click(function() {
                const formData = $('#filterForm').serialize();
                
                $('#reportTableBody').html('<tr><td colspan="6" class="p-8 text-center text-gray-500"><i class="fas fa-spinner fa-spin mr-2"></i>Memuat data laporan...</td></tr>');
                $('#reportTotal').text('Menghitung...');
                
                $('#reportModal').removeClass('hidden').addClass('flex');

                $.ajax({
                    url: "{{ route('admin.laporan.transaksi.generate') }}",
                    type: 'GET',
                    data: formData + "&action=json",
                    dataType: 'json',
                    success: function(response) {
                        populateReportModal(response);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("AJAX Error:", textStatus, errorThrown, jqXHR);
                        $('#reportTableBody').html('<tr><td colspan="6" class="p-8 text-center text-red-500">Gagal mengambil data. Cek console (F12) untuk detail.</td></tr>');
                    }
                });
            });

            function populateReportModal(data) {
                const tableBody = $('#reportTableBody');
                tableBody.empty();

                $('#reportPeriode').text(`Periode: ${data.filters.tanggal_mulai} s/d ${data.filters.tanggal_akhir}`);
                let filterText = `Metode: ${data.filters.metode_pembayaran || 'Semua'} | Status: ${data.filters.status || 'Semua'}`;
                $('#reportFilters').text(filterText);

                if (data.transaksis && data.transaksis.length > 0) {
                    let totalKeseluruhan = 0;
                    
                    data.transaksis.forEach(function(trx) {
                        totalKeseluruhan += parseFloat(trx.total_amount);

                        let statusBadge = (trx.status == 'lunas') 
                            ? `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Lunas</span>`
                            : `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">${trx.status}</span>`;

                        const row = `
                            <tr>
                                <td class="px-4 py-2 whitespace-nowrap">${trx.kode_transaksi}</td>
                                <td class="px-4 py-2 whitespace-nowrap">${formatDate(trx.tanggal_transaksi)}</td>
                                <td class="px-4 py-2 whitespace-nowrap">${trx.pelanggan ? trx.pelanggan.nama : 'Umum'}</td>
                                <td class="px-4 py-2 whitespace-nowrap capitalize">${trx.metode_pembayaran}</td>
                                <td class="px-4 py-2 whitespace-nowrap">${statusBadge}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-right">Rp ${formatNumber(trx.total_amount)}</td>
                            </tr>
                        `;
                        tableBody.append(row);
                    });
                    
                    $('#reportTotal').text('Rp ' + formatNumber(totalKeseluruhan));

                } else {
                    tableBody.html('<tr><td colspan="6" class="p-8 text-center text-gray-500">Tidak ada data transaksi yang ditemukan untuk filter ini.</td></tr>');
                    $('#reportTotal').text('Rp 0');
                }
            }

            $('#printReport').click(function() {
                window.print();
            });

            $('#closeReport, #closeReportSecondary').click(function() {
                $('#reportModal').removeClass('flex').addClass('hidden');
            });
        });
    </script>

</body>
</html>