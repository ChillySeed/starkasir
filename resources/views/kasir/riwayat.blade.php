<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - POS System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- 1. Tambahkan jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- 2. Tambahkan CSS untuk Print Struk -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F3F4F6;
        }

        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* Cursor pointer untuk input date */
        input[type="date"] {
            cursor: pointer;
        }
        
        input[type="date"]::-webkit-calendar-picker-indicator {
            cursor: pointer;
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
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
        /* Style untuk menyembunyikan ikon kalender bawaan (jika diperlukan) */
        input[type="date"]::-webkit-calendar-picker-indicator {
             /* display: none; */ /* Aktifkan jika ingin ikon kustom penuh */
             /* opacity: 0.5; */
        }
    </style>
</head>
<body class="text-gray-800 h-screen flex flex-col overflow-hidden">
    
    <div class="no-print h-full flex flex-col">
        <!-- Header - Same as POS -->
        <nav class="bg-white border-b border-gray-200 px-6 py-3 flex justify-between items-center shrink-0 shadow-sm">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/starlogo.png') }}" alt="Logo" class="h-10 w-auto">
                <div class="w-px h-8 bg-gray-300"></div>
                <h1 class="text-xl font-bold text-gray-900">Riwayat Transaksi</h1>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('kasir.pos') }}" class="text-gray-600 hover:text-gray-900 flex items-center gap-2 group">
                    <i class="fas fa-arrow-left text-lg"></i>
                    <span class="text-sm font-medium text-gray-600 group-hover:text-gray-900">Kembali ke POS</span>
                </a>
                
                <!-- User Account with Dropdown -->
                <div class="relative" id="userDropdown">
                    <button class="flex items-center gap-0 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
                        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->nama }}&background=6366F1&color=fff" class="w-9 h-9 rounded-l-lg">
                        <div class="px-3 py-1.5 flex items-center gap-2">
                            <span class="text-sm font-medium text-gray-700">{{ auth()->user()->nama }}</span>
                            <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                        </div>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 hidden" id="dropdownMenu">
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
        </nav>

        <!-- Main Content -->
        <div class="flex-1 p-4 overflow-hidden">
            <div class="h-full bg-white border border-gray-200 rounded-lg shadow-sm flex flex-col overflow-hidden">
                
                <!-- Filter Section -->
                <div class="p-4 border-b border-gray-200 flex-shrink-0">
                    <form method="GET" action="{{ route('kasir.riwayat') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3">
                        <div>
                            <label for="start_date" class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase">Dari Tanggal</label>
                            <input type="date" name="start_date" id="start_date" 
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400" 
                                value="{{ request('start_date') }}">
                        </div>
                        
                        <div>
                            <label for="end_date" class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase">Sampai Tanggal</label>
                            <input type="date" name="end_date" id="end_date" 
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400" 
                                value="{{ request('end_date') }}">
                        </div>

                        <div class="flex items-end gap-2">
                            <button type="submit" class="flex-1 bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg font-semibold text-sm transition-colors flex items-center justify-center gap-2">
                                <i class="fas fa-filter"></i>
                                <span>Filter</span>
                            </button>
                            <a href="{{ route('kasir.riwayat') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-semibold text-sm transition-colors flex items-center justify-center">
                                <i class="fas fa-redo"></i>
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Table Section -->
                <div class="flex-1 overflow-y-auto custom-scrollbar">
                    @if($transaksis->count() > 0)
                    <table class="w-full">
                        <thead class="bg-gray-50 sticky top-0">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Kode Transaksi</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Pelanggan</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Total</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($transaksis as $transaksi)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-sm text-gray-900">{{ $transaksi->kode_transaksi }}</div>
                                    <div class="text-xs text-gray-500 capitalize">
                                        <i class="fas fa-wallet text-xs mr-1"></i>{{ $transaksi->metode_pembayaran }}
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm text-gray-900">{{ $transaksi->tanggal_transaksi->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $transaksi->tanggal_transaksi->format('H:i') }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm font-medium text-gray-900">{{ $transaksi->pelanggan->nama ?? 'Umum' }}</div>
                                    @if($transaksi->pelanggan)
                                    <div class="text-xs text-gray-500">{{ $transaksi->pelanggan->golongan->nama_tier ?? '' }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="text-sm font-bold text-gray-900">Rp {{ number_format($transaksi->total_amount - $transaksi->total_diskon, 0, ',', '.') }}</div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <button type="button" 
                                        class="text-gray-700 hover:text-gray-900 show-receipt-btn bg-yellow-400 hover:bg-yellow-500 px-3 py-1.5 rounded-lg transition-colors"
                                        data-url="{{ route('kasir.transaksi-json', $transaksi) }}">
                                        <i class="fas fa-eye mr-1"></i>
                                        <span class="text-xs font-semibold">Lihat</span>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="h-full flex flex-col items-center justify-center text-gray-400 py-16">
                        <i class="fas fa-receipt text-6xl mb-4 opacity-40"></i>
                        <p class="text-lg font-medium">Belum ada transaksi</p>
                        <p class="text-sm">Transaksi yang Anda buat akan muncul di sini</p>
                    </div>
                    @endif
                </div>

                <!-- Pagination -->
                @if($transaksis->count() > 0)
                <div class="p-4 border-t border-gray-200 flex-shrink-0">
                    {{ $transaksis->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Receipt Modal - Same as POS -->
    <div id="receiptModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div id="printArea" class="bg-white rounded-lg w-full max-w-sm">
            <div class="p-6 font-mono text-gray-900">
                <div class="text-center mb-4">
                    <h4 class="text-xl font-bold">Toko Anda</h4>
                    <p class="text-sm">Jl. Contoh Alamat No. 123</p>
                    <p class="text-sm">Telp: 08123456789</p>
                </div>
                <div class="mb-4 text-sm">
                    <div class="flex justify-between">
                        <span>No. Transaksi:</span>
                        <span id="receiptKode"></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Tanggal:</span>
                        <span id="receiptTanggal"></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Kasir:</span>
                        <span id="receiptKasir"></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Pelanggan:</span>
                        <span id="receiptPelanggan"></span>
                    </div>
                </div>
                <div class="border-t border-dashed border-gray-400 my-2"></div>
                <div id="receiptItems" class="text-sm space-y-1">
                    <!-- Items -->
                </div>
                <div class="border-t border-dashed border-gray-400 my-2"></div>
                <div class="text-sm space-y-1">
                    <div class="flex justify-between">
                        <span>Subtotal:</span>
                        <span id="receiptSubtotal"></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Diskon:</span>
                        <span id="receiptDiskon"></span>
                    </div>
                    <div class="flex justify-between font-bold text-base">
                        <span>Total:</span>
                        <span id="receiptTotal"></span>
                    </div>
                </div>
                <div class="border-t border-dashed border-gray-400 my-2"></div>
                <div class="text-sm space-y-1">
                    <div class="flex justify-between">
                        <span>Bayar:</span>
                        <span id="receiptBayar"></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Kembali:</span>
                        <span id="receiptKembali"></span>
                    </div>
                </div>
                <div class="text-center mt-6 text-xs">
                    <p>Terima kasih telah berbelanja</p>
                    <p>Barang yang sudah dibeli tidak dapat ditukar</p>
                </div>
            </div>
            
            <div class="bg-gray-100 p-4 flex space-x-2 no-print">
                <button id="closeReceipt" class="flex-1 bg-gray-600 text-white py-2 rounded-lg hover:bg-gray-700 transition-colors">
                    <i class="fas fa-times mr-2"></i>Tutup
                </button>
                <button onclick="printReceipt()" class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-print mr-2"></i>Cetak Struk
                </button>
            </div>
        </div>
    </div>

    <script>
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

        // Fungsi untuk menampilkan struk (Disalin dari pos.blade.php)
        function showReceipt(data) {
            try {
                const date = new Date(data.tanggal);
                const formattedDate = date.toLocaleDateString('id-ID', {
                    day: '2-digit', month: '2-digit', year: 'numeric',
                    hour: '2-digit', minute: '2-digit'
                });

                $('#receiptKode').text(data.kode_transaksi);
                $('#receiptTanggal').text(formattedDate);
                $('#receiptKasir').text(data.kasir.nama);
                $('#receiptPelanggan').text(data.pelanggan ? data.pelanggan.nama : 'Umum');

                const itemsContainer = $('#receiptItems');
                itemsContainer.empty();
                data.items.forEach(item => {
                    itemsContainer.append(`
                        <div class="item">
                            <div class="font-medium">${item.nama_produk}</div>
                            <div class="flex justify-between pl-2">
                                <span>${item.qty} x ${formatNumber(item.harga)}</span>
                                <span>${formatNumber(item.subtotal)}</span>
                            </div>
                        </div>
                    `);
                });

                $('#receiptSubtotal').text('Rp ' + formatNumber(data.subtotal_raw));
                $('#receiptDiskon').text('-Rp ' + formatNumber(data.diskon_raw));
                $('#receiptTotal').text('Rp ' + formatNumber(data.total_raw));
                $('#receiptBayar').text('Rp ' + formatNumber(data.bayar_raw));
                $('#receiptKembali').text('Rp ' + formatNumber(data.kembali_raw));
                
                $('#receiptModal').removeClass('hidden').addClass('flex');
            } catch (e) {
                console.error("Error:", e);
                alert("Terjadi error saat menampilkan struk.");
            }
        }

        // Fungsi format angka (Disalin dari pos.blade.php)
        function formatNumber(number) {
            const num = parseFloat(number) || 0;
            return num.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        // Fungsi print (Disalin dari pos.blade.php)
        function printReceipt() {
            window.print();
        }

        $(document).ready(function() {
            $('#closeReceipt').click(function() {
                $('#receiptModal').removeClass('flex').addClass('hidden');
            });

            $('.show-receipt-btn').click(function() {
                const url = $(this).data('url');
                const icon = $(this).find('i');
                icon.removeClass('fa-eye').addClass('fa-spinner fa-spin');

                $.ajax({
                    url: url,
                    method: 'GET',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    success: function(response) {
                        if (response.success) {
                            showReceipt(response.transaksi);
                        } else {
                            alert('Error: ' + response.message);
                        }
                        icon.addClass('fa-eye').removeClass('fa-spinner fa-spin');
                    },
                    error: function(xhr) {
                        alert('Gagal mengambil data transaksi.');
                        console.error("AJAX Error:", xhr);
                        icon.addClass('fa-eye').removeClass('fa-spinner fa-spin');
                    }
                });
            });
        });
    </script>
</body>
</html>