<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS - Kasir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F3F4F6;
        }

        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        .numpad-btn {
            background: linear-gradient(145deg, #E5E7EB, #F3F4F6);
            box-shadow: 2px 2px 5px rgba(0,0,0,0.1), -2px -2px 5px rgba(255,255,255,0.7);
            transition: all 0.1s;
        }
        .numpad-btn:active {
            box-shadow: inset 2px 2px 5px rgba(0,0,0,0.1);
            transform: scale(0.98);
        }

        @media print {
            body * { visibility: hidden; }
            #printArea, #printArea * { visibility: visible; }
            #printArea { position: absolute; left: 0; top: 0; width: 100%; margin: 0; padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body class="text-gray-800 h-screen flex flex-col overflow-hidden">
    
    <div class="no-print h-full flex flex-col">
        <!-- Header -->
        <nav class="bg-white border-b border-gray-200 px-6 py-3 flex justify-between items-center shrink-0 shadow-sm">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/starlogo.png') }}" alt="Logo" class="h-10 w-auto">
                <div class="w-px h-8 bg-gray-300"></div>
                <h1 class="text-xl font-bold text-gray-900">Transaksi</h1>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('kasir.riwayat') }}" class="text-gray-600 hover:text-gray-900 flex items-center gap-2 group" title="Riwayat Transaksi">
                    <i class="fas fa-history text-lg"></i>
                    <span class="text-sm font-medium text-gray-600 group-hover:text-gray-900">Riwayat</span>
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

        <div class="flex-1 p-4 overflow-hidden">
            <div class="grid grid-cols-12 gap-4 h-full">
                
                <!-- Left Column: Info Cards + Products -->
                <div class="col-span-7 flex flex-col gap-3 h-full min-h-0">
                    
                    <!-- Info Cards -->
                    <div class="grid grid-cols-4 gap-3 flex-shrink-0">
                        <div class="bg-white border border-gray-200 rounded-lg px-3 py-2.5 shadow-sm flex items-center gap-2">
                            <i class="far fa-file-alt text-gray-500 text-sm"></i>
                            <span class="font-medium text-xs text-gray-700">0123/KASR/UTM/2025</span>
                        </div>
                        <div class="bg-white border border-gray-200 rounded-lg px-3 py-2.5 shadow-sm flex items-center gap-2">
                            <i class="far fa-user text-gray-500 text-sm"></i>
                            <span class="font-medium text-xs text-gray-700">{{ auth()->user()->nama }}</span>
                        </div>
                        <div class="bg-white border border-gray-200 rounded-lg px-3 py-2.5 shadow-sm flex items-center gap-2">
                            <i class="far fa-calendar-alt text-gray-500 text-sm"></i>
                            <span class="font-medium text-xs text-gray-700">{{ date('d M Y') }}</span>
                        </div>
                        <div class="bg-white border border-gray-200 rounded-lg px-3 py-2.5 shadow-sm flex items-center gap-2 relative">
                            <i class="fas fa-users text-gray-500 text-sm"></i>
                            <select id="pelangganSelect" class="bg-transparent flex-1 text-xs font-semibold text-gray-700 focus:outline-none appearance-none cursor-pointer uppercase">
                                <option value="">UMUM</option>
                                @foreach($pelanggans as $pelanggan)
                                <option value="{{ $pelanggan->id }}" 
                                    data-diskon="{{ $pelanggan->golongan->diskon_persen ?? 0 }}"
                                    data-golongan-id="{{ $pelanggan->golongan_id }}">
                                    {{ $pelanggan->nama }}
                                </option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Products Section -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm flex-1 flex flex-col min-h-0 overflow-hidden">
                        <div class="p-3 border-b border-gray-200 flex-shrink-0">
                            <div class="relative">
                                <input type="text" id="searchProduk" placeholder="Cari item..." 
                                    class="w-full bg-gray-50 border border-gray-200 rounded-lg pl-9 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm">
                                <i class="fas fa-search absolute left-3 top-2.5 text-gray-400 text-sm"></i>
                            </div>
                        </div>

                        <div class="flex-1 min-h-0 overflow-hidden p-3">
                            <div class="h-full overflow-y-auto custom-scrollbar pr-2">
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach($produks as $produk)
                                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 cursor-pointer hover:border-purple-500 hover:shadow-md transition-all product-item relative"
                                        data-produk-id="{{ $produk->id }}"
                                        data-nama="{{ $produk->nama_produk }}"
                                        data-harga="{{ $produk->harga_dasar }}"
                                        data-stok="{{ $produk->stok_sekarang }}"
                                        data-gambar="{{ $produk->gambar_url }}"
                                        data-quantity-prices="{{ $produk->levelHargaQuantities->where('is_active', true)->toJson() }}"
                                        data-golongan-prices="{{ $produk->levelHargaGolongans->where('is_active', true)->toJson() }}">
                                        
                                        <div class="flex items-start gap-2">
                                            <img src="{{ $produk->gambar_url }}" alt="" class="w-12 h-12 rounded-lg object-cover border border-gray-200 flex-shrink-0">
                                            <div class="flex-1 min-w-0">
                                                <h3 class="font-semibold text-xs text-gray-900 line-clamp-2 mb-1">{{ $produk->nama_produk }}</h3>
                                                <p class="text-xs font-bold text-green-600">Rp {{ number_format($produk->harga_dasar, 0, ',', '.') }}</p>
                                                <p class="text-xs text-gray-500">Stok: {{ $produk->stok_sekarang }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="absolute top-2 right-2 w-6 h-6 bg-yellow-400 rounded-full flex items-center justify-center font-bold text-xs hidden item-badge-qty" id="badge-{{$produk->id}}">0</div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Cart -->
                <div class="col-span-5 flex flex-col gap-3 h-full min-h-0">
                    
                    <!-- Total Display -->
                    <div class="bg-white border border-gray-200 rounded-lg px-6 py-4 shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-xl font-bold text-gray-900">Rp</span>
                            <span id="totalAmountDisplay" class="text-3xl font-extrabold text-gray-900">26.000,00</span>
                        </div>
                    </div>

                    <!-- Cart Items -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm flex-1 flex flex-col min-h-0 overflow-hidden">
                        <div class="flex-1 overflow-y-auto custom-scrollbar p-3">
                            <table class="w-full">
                                <tbody id="cartItems">
                                    <!-- Cart items akan di-populate -->
                                </tbody>
                            </table>
                            
                            <div id="emptyCart" class="h-full flex flex-col items-center justify-center text-gray-400">
                                <i class="fas fa-shopping-cart text-4xl mb-2"></i>
                                <p class="text-sm">Keranjang kosong</p>
                            </div>
                        </div>

                        <!-- Summary -->
                        <div class="p-3 bg-gray-50 border-t border-gray-200 flex-shrink-0">
                            <div class="text-xs space-y-1">
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal</span>
                                    <span id="subtotalAmount">Rp 0</span>
                                </div>
                                <div class="flex justify-between text-green-600">
                                    <span>Diskon</span>
                                    <span id="diskonAmount">Rp 0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bayar Button -->
                    <button id="openPaymentModalBtn" class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold py-4 rounded-lg shadow-lg flex items-center justify-center gap-2 transition-all disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                        <i class="fas fa-wallet text-lg"></i>
                        <span class="text-lg">BAYAR</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Quantity Modal -->
    <div id="quantityModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl p-6 w-96 shadow-2xl">
            <h3 class="text-lg font-bold mb-1" id="modalProductName">Nama Produk</h3>
            <p class="text-sm text-gray-500 mb-6" id="modalStockInfo">Stok: 0</p>
            
            <div class="flex items-center justify-center mb-6 gap-4">
                <button onclick="adjustQty(-1)" class="w-12 h-12 rounded-lg bg-gray-100 hover:bg-gray-200 font-bold text-xl">-</button>
                <input type="number" id="quantityInput" min="1" value="1" class="w-20 text-center py-2 text-3xl font-bold border-b-2 border-gray-300 focus:border-purple-500 focus:outline-none bg-transparent">
                <button onclick="adjustQty(1)" class="w-12 h-12 rounded-lg bg-gray-100 hover:bg-gray-200 font-bold text-xl">+</button>
            </div>
            
            <div class="grid grid-cols-2 gap-3">
                <button id="cancelQuantity" class="py-3 rounded-lg border border-gray-300 text-gray-700 font-semibold hover:bg-gray-50">Batal</button>
                <button id="addToCart" class="py-3 rounded-lg bg-purple-600 text-white font-semibold hover:bg-purple-700">Tambah</button>
            </div>
        </div>
    </div>

    <!-- Payment Modal (NEW DESIGN) -->
    <div id="paymentModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl w-full max-w-4xl shadow-2xl overflow-hidden">
            
            <!-- Header -->
            <div class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
                <button id="closePaymentModal" class="flex items-center gap-2 text-gray-700 hover:text-gray-900 font-medium">
                    <i class="fas fa-chevron-left"></i>
                    <span>Kembali</span>
                </button>
                <div class="text-right">
                    <span class="text-xs text-gray-500 uppercase tracking-wide">Total Biaya :</span>
                    <span id="popupTotalAmountDisplay" class="text-2xl font-extrabold text-gray-900 ml-2">Rp 26.000,00</span>
                </div>
            </div>

            <div class="p-6 grid grid-cols-2 gap-6">
                
                <!-- Left: Numpad -->
                <div>
                    <div class="mb-6 text-right bg-gray-50 rounded-xl p-4 border-2 border-gray-200">
                        <h2 class="text-4xl font-extrabold text-gray-900" id="displayBigTotal">Rp 26.000</h2>
                    </div>

                    <div class="grid grid-cols-4 gap-2">
                        <button class="numpad-btn text-2xl font-semibold h-16 rounded-lg text-gray-700" onclick="inputKey('7')">7</button>
                        <button class="numpad-btn text-2xl font-semibold h-16 rounded-lg text-gray-700" onclick="inputKey('8')">8</button>
                        <button class="numpad-btn text-2xl font-semibold h-16 rounded-lg text-gray-700" onclick="inputKey('9')">9</button>
                        <button class="text-2xl font-semibold h-16 rounded-lg text-white bg-red-500 hover:bg-red-600 shadow-md" onclick="inputKey('C')">C</button>

                        <button class="numpad-btn text-2xl font-semibold h-16 rounded-lg text-gray-700" onclick="inputKey('4')">4</button>
                        <button class="numpad-btn text-2xl font-semibold h-16 rounded-lg text-gray-700" onclick="inputKey('5')">5</button>
                        <button class="numpad-btn text-2xl font-semibold h-16 rounded-lg text-gray-700" onclick="inputKey('6')">6</button>
                        <button class="numpad-btn text-xl font-semibold h-16 rounded-lg text-gray-700 flex items-center justify-center" onclick="inputKey('backspace')">
                            <i class="fas fa-backspace"></i>
                        </button>

                        <button class="numpad-btn text-2xl font-semibold h-16 rounded-lg text-gray-700" onclick="inputKey('1')">1</button>
                        <button class="numpad-btn text-2xl font-semibold h-16 rounded-lg text-gray-700" onclick="inputKey('2')">2</button>
                        <button class="numpad-btn text-2xl font-semibold h-16 rounded-lg text-gray-700" onclick="inputKey('3')">3</button>
                        <div class="h-16"></div>

                        <button class="numpad-btn text-2xl font-semibold h-16 rounded-lg text-gray-700 col-span-3" onclick="inputKey('0')">0</button>
                        <button class="numpad-btn text-2xl font-semibold h-16 rounded-lg text-gray-700" onclick="inputKey('000')">000</button>
                    </div>
                </div>

                <!-- Right: Payment Method + Bayar -->
                <div class="flex flex-col justify-between">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Metode Pembayaran</label>
                        <div class="bg-gray-800 text-white rounded-xl p-4 flex items-center justify-between cursor-pointer hover:bg-gray-700 transition relative">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-wallet text-2xl text-yellow-400"></i>
                                <span class="text-lg font-semibold" id="paymentMethodLabel">Cash</span>
                            </div>
                            <select id="popupPaymentMethod" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer bg-white text-gray-900" onchange="updatePaymentMethod()">
                                <option value="tunai">Cash</option>
                                <option value="debit">Debit</option>
                                <option value="kredit">Kredit</option>
                                <option value="qris">QRIS</option>
                            </select>
                            <i class="fas fa-chevron-down text-white/70"></i>
                        </div>
                    </div>

                    <button id="processTransactionBtn" class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold py-5 rounded-xl shadow-lg flex items-center justify-center gap-3 text-xl transition-all">
                        <i class="fas fa-wallet"></i>
                        <span>BAYAR</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Receipt Modal (SAMA) -->
    <div id="receiptModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div id="printArea" class="bg-white rounded-lg w-full max-w-sm">
            <!-- Isi Struk -->
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


    <!-- ========== SCRIPT GABUNGAN ========== -->
    <script>
        // User Dropdown Toggle
        const userDropdownBtn = document.querySelector('#userDropdown button');
        const dropdownMenu = document.getElementById('dropdownMenu');
        
        userDropdownBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdownMenu.classList.toggle('hidden');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!document.getElementById('userDropdown').contains(e.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });

        let cart = [];
        let currentProduct = null;
        let currentInputMoney = '';

        const formatRupiah = (num) => new Intl.NumberFormat('id-ID', { minimumFractionDigits: 0 }).format(num);
        const formatRupiahFull = (num) => new Intl.NumberFormat('id-ID', { minimumFractionDigits: 2 }).format(num);
        const parseRupiah = (str) => parseFloat(str.replace(/\./g, '').replace(',', '.')) || 0;

        // Product Click
        $('.product-item').click(function() {
            const productId = $(this).data('produk-id');
            const productName = $(this).data('nama');
            const productPrice = $(this).data('harga');
            const productStock = $(this).data('stok');
            const productImage = $(this).data('gambar');
            const quantityPrices = $(this).data('quantity-prices');
            const golonganPrices = $(this).data('golongan-prices');
            
            currentProduct = {
                id: productId,
                name: productName,
                price: parseFloat(productPrice),
                stock: parseInt(productStock),
                gambar_url: productImage,
                quantityPrices: quantityPrices || [],
                golonganPrices: golonganPrices || []
            };

            $('#modalProductName').text(productName);
            $('#quantityInput').val(1).attr('max', productStock);
            $('#modalStockInfo').text(`Stok tersedia: ${productStock}`);
            $('#quantityModal').removeClass('hidden').addClass('flex');
        });

        window.adjustQty = function(change) {
            const input = $('#quantityInput');
            let newQty = parseInt(input.val()) + change;
            if (newQty < 1) newQty = 1;
            if (newQty > currentProduct.stock) newQty = currentProduct.stock;
            input.val(newQty);
        };

        $('#cancelQuantity').click(() => $('#quantityModal').removeClass('flex').addClass('hidden'));

        // Helper Functions untuk Harga Bertingkat
        function getQuantityPrice(product, quantity) {
            let bestPrice = product.price;
            let priceType = 'Reguler';

            if (Array.isArray(product.quantityPrices)) {
                product.quantityPrices.forEach(rule => {
                    const min = rule.qty_min;
                    const max = rule.qty_max;
                    const price = parseFloat(rule.harga_khusus);
                    
                    if (quantity >= min && (max === null || quantity <= max)) {
                        if (price < bestPrice) {
                            bestPrice = price;
                            priceType = `Quantity (${min}+)`;
                        }
                    }
                });
            }
            return { price: bestPrice, type: priceType };
        }

        function getGolonganPrice(product, golonganId) {
            let bestPrice = product.price;
            let priceType = 'Reguler';

            if (Array.isArray(product.golonganPrices)) {
                product.golonganPrices.forEach(rule => {
                    if (parseInt(rule.golongan_id) === parseInt(golonganId)) {
                        const price = parseFloat(rule.harga_khusus);
                        if (price < bestPrice) {
                            bestPrice = price;
                            priceType = 'Member Special';
                        }
                    }
                });
            }
            return { price: bestPrice, type: priceType };
        }

        function getBestPrice(product, quantity, golonganId) {
            const quantityPrice = getQuantityPrice(product, quantity);
            let bestPrice = quantityPrice;
            
            if (golonganId) {
                const golonganPrice = getGolonganPrice(product, golonganId);
                if (golonganPrice.price < bestPrice.price) {
                    bestPrice = golonganPrice;
                }
            }
            return bestPrice;
        }

        $('#addToCart').click(function() {
            const quantity = parseInt($('#quantityInput').val());
            const golonganSelect = $('#pelangganSelect');
            const golonganId = golonganSelect.val() ? golonganSelect.find(':selected').data('golongan-id') : null;
            
            if (quantity < 1 || quantity > currentProduct.stock) {
                alert('Jumlah tidak valid!');
                return;
            }

            const bestPrice = getBestPrice(currentProduct, quantity, golonganId);

            const existingItem = cart.find(item => item.id === currentProduct.id);
            
            if (existingItem) {
                if (existingItem.quantity + quantity > currentProduct.stock) {
                    alert('Stok tidak mencukupi!');
                    return;
                }
                existingItem.quantity += quantity;
                const updatedBestPrice = getBestPrice(existingItem, existingItem.quantity, golonganId);
                existingItem.appliedPrice = updatedBestPrice.price;
                existingItem.priceType = updatedBestPrice.type;
                existingItem.subtotal = existingItem.quantity * existingItem.appliedPrice;
            } else {
                cart.push({
                    id: currentProduct.id,
                    name: currentProduct.name,
                    price: currentProduct.price,
                    stock: currentProduct.stock,
                    gambar_url: currentProduct.gambar_url,
                    quantity: quantity,
                    appliedPrice: bestPrice.price,
                    priceType: bestPrice.type,
                    subtotal: quantity * bestPrice.price,
                    quantityPrices: currentProduct.quantityPrices,
                    golonganPrices: currentProduct.golonganPrices
                });
            }

            renderCart();
            $('#quantityModal').removeClass('flex').addClass('hidden');
        });

        function renderCart() {
            const tbody = $('#cartItems');
            tbody.empty();
            let subtotal = 0;
            
            $('.item-badge-qty').addClass('hidden').text('0');

            if (cart.length === 0) {
                $('#emptyCart').show();
                $('#openPaymentModalBtn').prop('disabled', true);
            } else {
                $('#emptyCart').hide();
                $('#openPaymentModalBtn').prop('disabled', false);

                cart.forEach(item => {
                    subtotal += item.subtotal;
                    $(`#badge-${item.id}`).removeClass('hidden').text(item.quantity);

                    tbody.append(`
                        <tr class="border-b border-gray-100">
                            <td class="py-3 px-2">
                                <div class="flex gap-2 items-start">
                                    <img src="${item.gambar_url || 'https://via.placeholder.com/40'}" class="w-10 h-10 rounded-lg object-cover border border-gray-200 flex-shrink-0">
                                    <div class="flex-1 min-w-0">
                                        <div class="font-semibold text-xs text-gray-900 line-clamp-1 mb-1">${item.name}</div>
                                        <div class="text-xs text-gray-500 mb-2">@ Rp ${formatRupiah(item.appliedPrice)}</div>
                                        
                                        <!-- Quantity Controls -->
                                        <div class="flex items-center gap-2">
                                            <button class="decrease-qty w-6 h-6 rounded bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-700 font-bold transition" data-id="${item.id}">
                                                <i class="fas fa-minus text-xs"></i>
                                            </button>
                                            <span class="text-xs font-bold text-gray-900 min-w-[20px] text-center">${item.quantity}</span>
                                            <button class="increase-qty w-6 h-6 rounded bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-700 font-bold transition" data-id="${item.id}" data-stock="${item.stock}">
                                                <i class="fas fa-plus text-xs"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="text-right flex-shrink-0">
                                        <div class="font-bold text-sm text-gray-900 mb-2">Rp ${formatRupiah(item.subtotal)}</div>
                                        <button class="remove-item text-red-500 hover:text-red-700 text-xs font-medium" data-id="${item.id}">
                                            <i class="fas fa-trash mr-1"></i>Hapus
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    `);
                });
            }

            const diskonPersen = $('#pelangganSelect').find(':selected').data('diskon') || 0;
            const diskonVal = (subtotal * diskonPersen) / 100;
            const finalTotal = subtotal - diskonVal;

            $('#subtotalAmount').text('Rp ' + formatRupiah(subtotal));
            $('#diskonAmount').text('-Rp ' + formatRupiah(diskonVal));
            $('#totalAmountDisplay').text(formatRupiahFull(finalTotal));
        }

        // Increase Quantity
        $(document).on('click', '.increase-qty', function() {
            const id = $(this).data('id');
            const stock = $(this).data('stock');
            const item = cart.find(i => i.id === id);
            
            if (item && item.quantity < stock) {
                item.quantity++;
                const golonganId = $('#pelangganSelect').val() ? $('#pelangganSelect').find(':selected').data('golongan-id') : null;
                const bestPrice = getBestPrice(item, item.quantity, golonganId);
                item.appliedPrice = bestPrice.price;
                item.priceType = bestPrice.type;
                item.subtotal = item.quantity * item.appliedPrice;
                renderCart();
            } else {
                alert('Stok tidak mencukupi!');
            }
        });

        // Decrease Quantity
        $(document).on('click', '.decrease-qty', function() {
            const id = $(this).data('id');
            const item = cart.find(i => i.id === id);
            
            if (item) {
                if (item.quantity > 1) {
                    item.quantity--;
                    const golonganId = $('#pelangganSelect').val() ? $('#pelangganSelect').find(':selected').data('golongan-id') : null;
                    const bestPrice = getBestPrice(item, item.quantity, golonganId);
                    item.appliedPrice = bestPrice.price;
                    item.priceType = bestPrice.type;
                    item.subtotal = item.quantity * item.appliedPrice;
                    renderCart();
                } else {
                    // Jika quantity = 1, hapus item
                    if (confirm('Hapus item dari keranjang?')) {
                        cart = cart.filter(i => i.id !== id);
                        renderCart();
                    }
                }
            }
        });

        $(document).on('click', '.remove-item', function() {
            const id = $(this).data('id');
            cart = cart.filter(i => i.id !== id);
            renderCart();
        });

        $('#pelangganSelect').change(function() {
            const golonganId = $(this).val() ? $(this).find(':selected').data('golongan-id') : null;
            
            cart.forEach(item => {
                const bestPrice = getBestPrice(item, item.quantity, golonganId);
                item.appliedPrice = bestPrice.price;
                item.priceType = bestPrice.type;
                item.subtotal = item.quantity * bestPrice.price;
            });
            
            renderCart();
        });

        // Payment Modal
        $('#openPaymentModalBtn').click(function() {
            if(cart.length === 0) return;

            const totalTextRaw = $('#totalAmountDisplay').text(); 
            const totalVal = parseRupiah(totalTextRaw);
            
            $('#popupTotalAmountDisplay').text('Rp ' + totalTextRaw);
            $('#popupTotalAmountDisplay').data('val', totalVal); 
            
            currentInputMoney = '';
            updateMoneyInputDisplay();
            
            $('#paymentModal').removeClass('hidden').addClass('flex');
        });

        $('#closePaymentModal').click(() => $('#paymentModal').removeClass('flex').addClass('hidden'));

        window.inputKey = function(val) {
            if (val === 'C') {
                currentInputMoney = '';
            } else if (val === 'backspace') {
                currentInputMoney = currentInputMoney.slice(0, -1);
            } else {
                if(currentInputMoney === '0') currentInputMoney = val;
                else currentInputMoney += val;
            }
            updateMoneyInputDisplay();
        };

        // Keyboard support untuk Payment Modal
        document.addEventListener('keydown', function(e) {
            if ($('#paymentModal').hasClass('flex')) {
                // Number keys (0-9)
                if (e.key >= '0' && e.key <= '9') {
                    e.preventDefault();
                    inputKey(e.key);
                }
                // Backspace
                else if (e.key === 'Backspace') {
                    e.preventDefault();
                    inputKey('backspace');
                }
                // Delete untuk clear
                else if (e.key === 'Delete') {
                    e.preventDefault();
                    inputKey('C');
                }
                // Enter untuk bayar
                else if (e.key === 'Enter') {
                    e.preventDefault();
                    $('#processTransactionBtn').click();
                }
                // Escape untuk close
                else if (e.key === 'Escape') {
                    e.preventDefault();
                    $('#closePaymentModal').click();
                }
            }
        });

        function updateMoneyInputDisplay() {
            if (currentInputMoney === '') {
                $('#displayBigTotal').text('Rp 0');
            } else {
                const num = parseFloat(currentInputMoney);
                if(!isNaN(num)) {
                    $('#displayBigTotal').text('Rp ' + formatRupiah(num));
                } else {
                    $('#displayBigTotal').text('Rp ' + currentInputMoney);
                }
            }
        }

        function updatePaymentMethod() {
            const txt = $('#popupPaymentMethod').find("option:selected").text();
            $('#paymentMethodLabel').text(txt);
        }

        $('#processTransactionBtn').click(function() {
            const totalTagihan = $('#popupTotalAmountDisplay').data('val');
            
            let uangBayar = 0;
            if(currentInputMoney !== '') {
                uangBayar = parseFloat(currentInputMoney);
            }

            if (uangBayar < totalTagihan) {
                alert('Uang pembayaran kurang!');
                return;
            }

            const formData = {
                items: cart.map(item => ({
                    produk_id: item.id,
                    qty: item.quantity
                })),
                pelanggan_id: $('#pelangganSelect').val() || null,
                metode_pembayaran: $('#popupPaymentMethod').val(),
                amount_paid: uangBayar,
                catatan: ''
            };

            $.ajax({
                url: '{{ route("kasir.store-transaksi") }}',
                method: 'POST',
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.success) {
                        $('#paymentModal').removeClass('flex').addClass('hidden');
                        showReceipt(response.transaksi);
                        
                        cart = [];
                        renderCart();
                        $('#pelangganSelect').val('');
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr) {
                    console.error(xhr);
                    alert('Error: Gagal memproses transaksi');
                }
            });
        });

        function showReceipt(data) {
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
                            <span>${item.qty} x ${formatRupiah(item.harga)}</span>
                            <span>${formatRupiah(item.subtotal)}</span>
                        </div>
                    </div>
                `);
            });

            $('#receiptSubtotal').text('Rp ' + formatRupiah(data.subtotal_raw));
            $('#receiptDiskon').text('-Rp ' + formatRupiah(data.diskon_raw));
            $('#receiptTotal').text('Rp ' + formatRupiah(data.total_raw));
            $('#receiptBayar').text('Rp ' + formatRupiah(data.bayar_raw));
            $('#receiptKembali').text('Rp ' + formatRupiah(data.kembali_raw));
            
            $('#receiptModal').removeClass('hidden').addClass('flex');
        }

        function printReceipt() {
            window.print();
        }

        $('#closeReceipt').click(() => $('#receiptModal').removeClass('flex').addClass('hidden'));

        $('#searchProduk').on('input', function() {
            const term = $(this).val().toLowerCase();
            $('.product-item').each(function() {
                const name = $(this).data('nama').toLowerCase();
                $(this).toggle(name.includes(term));
            });
        });

        renderCart();
    </script>
</body>
</html>