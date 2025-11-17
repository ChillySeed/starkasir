<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - POS System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- 1. Tambahkan jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- 2. Tambahkan CSS untuk Print Struk -->
    <style>
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
<body class="bg-gray-100">
    <!-- Area Navigasi (tidak dicetak) -->
    <nav class="bg-purple-600 text-white shadow-lg no-print">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-cash-register text-2xl"></i>
                    <span class="text-xl font-bold">POS System - Kasir</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('kasir.pos') }}" class="bg-purple-700 hover:bg-purple-800 px-4 py-2 rounded-lg">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke POS
                    </a>
                    <span>Halo, {{ auth()->user()->nama }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-purple-700 hover:bg-purple-800 px-4 py-2 rounded-lg">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Area Riwayat (tidak dicetak) -->
    <div class="max-w-7xl mx-auto p-6 no-print">
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Riwayat Transaksi</h2>
            </div>
            <div class="p-6">

                <!-- ========== MULAI FORM FILTER TANGGAL ========== -->
                <form method="GET" action="{{ route('kasir.riwayat') }}" class="mb-6">
                    <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-4 items-end">
                        
                        <!-- Input Mulai Tanggal -->
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Mulai Tanggal</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fas fa-calendar-alt"></i>
                                </span>
                                <input type="date" name="start_date" id="start_date" 
                                       class="block w-full border-gray-300 rounded-lg shadow-sm pl-10 py-2 focus:ring-purple-500 focus:border-purple-500" 
                                       value="{{ request('start_date') }}">
                            </div>
                        </div>
                        
                        <!-- Input Sampai Tanggal -->
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                             <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fas fa-calendar-alt"></i>
                                </span>
                                <input type="date" name="end_date" id="end_date" 
                                       class="block w-full border-gray-300 rounded-lg shadow-sm pl-10 py-2 focus:ring-purple-500 focus:border-purple-500" 
                                       value="{{ request('end_date') }}">
                            </div>
                        </div>

                        <!-- Tombol Filter dan Reset -->
                        <div class="flex space-x-2">
                            <button type="submit" class="w-full sm:w-auto bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors">
                                <i class="fas fa-filter mr-1"></i> Filter
                            </button>
                            <a href="{{ route('kasir.riwayat') }}" class="w-full sm:w-auto bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors text-center">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
                <!-- ========== AKHIR FORM FILTER TANGGAL ========== -->


                @if($transaksis->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full table-auto">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelanggan</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($transaksis as $transaksi)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">{{ $transaksi->kode_transaksi }}</div>
                                    <div class="text-sm text-gray-500">{{ $transaksi->metode_pembayaran }}</div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $transaksi->tanggal_transaksi->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm text-gray-900">{{ $transaksi->pelanggan->nama ?? 'Umum' }}</div>
                                    @if($transaksi->pelanggan)
                                    <div class="text-xs text-gray-500">{{ $transaksi->pelanggan->golongan->nama_tier ?? '' }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right text-sm font-medium text-gray-900">
                                    <!-- 4. Perbaikan: Menampilkan Grand Total (Total - Diskon) -->
                                    Rp {{ number_format($transaksi->total_amount - $transaksi->total_diskon, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <!-- 3. DIUBAH DARI <a> MENJADI <button> -->
                                    <button type="button" 
                                        class="text-blue-600 hover:text-blue-900 show-receipt-btn"
                                        data-url="{{ route('kasir.transaksi-json', $transaksi) }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    <!-- ========== MODIFIKASI PAGINASI ========== -->
                    <!-- Kita tambahkan ->appends(request()->query()) agar filter tetap terbawa saat pindah halaman -->
                    {{ $transaksis->links() }}
                </div>
                @else
                <div class="text-center py-8">
                    <i class="fas fa-receipt text-4xl text-gray-400 mb-4"></i>
                    <p class="text-gray-500">Belum ada transaksi</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- ========== 5. MULAI STRUK MODAL ========== -->
    <div id="receiptModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div id="printArea" class="bg-white rounded-lg w-full max-w-sm">
            <!-- Bagian Isi Struk -->
            <div class="p-6 font-mono text-gray-900">
                <!-- Header Struk -->
                <div class="text-center mb-4">
                    <h4 class="text-xl font-bold">Toko Anda</h4>
                    <p class="text-sm">Jl. Contoh Alamat No. 123</p>
                    <p class="text-sm">Telp: 08123456789</p>
                </div>

                <!-- Info Transaksi -->
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
                    <!-- Item akan di-generate oleh JS -->
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
            
            <!-- Tombol Aksi (Tidak dicetak) -->
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
    <!-- ========== AKHIR STRUK MODAL ========== -->

    <!-- ========== 6. JAVASCRIPT BARU ========== -->
    <script>
        // Fungsi untuk menampilkan struk (Disalin dari pos.blade.php)
        function showReceipt(data) {
            try {
                const date = new Date(data.tanggal);
                const formattedDate = date.toLocaleDateString('id-ID', {
                    day: '2-digit', month: '2-digit', year: 'numeric',
                    hour: '2-digit', minute: '2-digit'
                }).replace('.', ':');

                $('#receiptKode').text(data.kode_transaksi);
                $('#receiptTanggal').text(formattedDate);
                $('#receiptKasir').text(data.kasir.nama);
                $('#receiptPelanggan').text(data.pelanggan ? data.pelanggan.nama : 'Umum');

                const itemsContainer = $('#receiptItems');
                itemsContainer.empty();
                data.items.forEach(item => {
                    const itemHtml = `
                        <div class="item">
                            <div class="font-medium">${item.nama_produk}</div>
                            <div class="flex justify-between pl-2">
                                <span>${item.qty} x ${formatNumber(item.harga)}</span>
                                <span>${formatNumber(item.subtotal)}</span>
                            </div>
                        </div>
                    `;
                    itemsContainer.append(itemHtml);
                });

                $('#receiptSubtotal').text('Rp ' + formatNumber(data.subtotal_raw));
                $('#receiptDiskon').text('-Rp ' + formatNumber(data.diskon_raw));
                $('#receiptTotal').text('Rp ' + formatNumber(data.total_raw));
                $('#receiptBayar').text('Rp ' + formatNumber(data.bayar_raw));
                $('#receiptKembali').text('Rp ' + formatNumber(data.kembali_raw));
                
                $('#receiptModal').removeClass('hidden').addClass('flex');
            } catch (e) {
                console.error("Error di dalam showReceipt:", e);
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

        // Event listener JQuery
        $(document).ready(function() {
            // Tombol tutup modal struk (Disalin dari pos.blade.php)
            $('#closeReceipt').click(function() {
                $('#receiptModal').removeClass('flex').addClass('hidden');
            });

            // Tombol 'mata' di klik
            $('.show-receipt-btn').click(function() {
                const url = $(this).data('url'); // Ambil URL dari data-url
                
                // Tampilkan loading (opsional)
                const icon = $(this).find('i');
                icon.removeClass('fa-eye').addClass('fa-spinner').addClass('animate-spin');

                $.ajax({
                    url: url,
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Untuk keamanan
                    },
                    success: function(response) {
                        if (response.success) {
                            showReceipt(response.transaksi);
                        } else {
                            alert('Error: ' + response.message);
                        }
                        // Kembalikan ikon mata
                        icon.addClass('fa-eye').removeClass('fa-spinner').removeClass('animate-spin');
                    },
                    error: function(xhr) {
                        alert('Gagal mengambil data transaksi. Cek console.');
                        console.error("AJAX Error:", xhr.status, xhr.responseText);
                        // Kembalikan ikon mata
                        icon.addClass('fa-eye').removeClass('fa-spinner').removeClass('animate-spin');
                    }
                });
            });
        });
    </script>

</body>
</html>