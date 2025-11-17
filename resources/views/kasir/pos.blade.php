<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS - Kasir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- CSS untuk Print Struk (dari file Anda) -->
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
    </style>
</head>
<body class="bg-gray-100">
    <!-- Area POS Utama (tidak dicetak) -->
    <div class="no-print">
        <!-- Navigation (Identik) -->
        <nav class="bg-purple-600 text-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center space-x-4">
                        <i class="fas fa-cash-register text-2xl"></i>
                        <span class="text-xl font-bold">POS System - Kasir</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('kasir.riwayat') }}" class="bg-purple-700 hover:bg-purple-800 px-4 py-2 rounded-lg">
                            <i class="fas fa-history mr-2"></i>Riwayat
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

        <div class="max-w-7xl mx-auto p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Product List (Logika dari Teman) -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-bold mb-4">Daftar Produk</h2>
                        
                        <div class="mb-6">
                            <input type="text" id="searchProduk" placeholder="Cari produk..." 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>

                        <!-- Product Grid (dari Teman, dengan data-prices) -->
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 max-h-96 overflow-y-auto">
                            @foreach($produks as $produk)
                            <div class="bg-gray-50 rounded-lg p-4 cursor-pointer hover:bg-purple-50 transition-colors product-item"
                                data-produk-id="{{ $produk->id }}"
                                data-nama="{{ $produk->nama_produk }}"
                                data-harga="{{ $produk->harga_dasar }}"
                                data-stok="{{ $produk->stok_sekarang }}"
                                data-gambar="{{ $produk->gambar_url }}"
                                data-quantity-prices="{{ $produk->levelHargaQuantities->where('is_active', true)->toJson() }}"
                                data-golongan-prices="{{ $produk->levelHargaGolongans->where('is_active', true)->toJson() }}">
                                <div class="text-center">
                                    <img src="{{ $produk->gambar_url }}" alt="{{ $produk->nama_produk }}" 
                                        class="w-16 h-16 mx-auto rounded-lg object-cover mb-2">
                                    <h3 class="font-semibold text-sm text-gray-900">{{ $produk->nama_produk }}</h3>
                                    <p class="text-green-600 font-bold text-sm">Rp {{ number_format($produk->harga_dasar, 0, ',', '.') }}</p>
                                    <p class="text-xs text-gray-500">Stok: {{ $produk->stok_sekarang }} {{ $produk->satuan }}</p>
                                    
                                    <!-- Info Harga Spesial (dari Teman) -->
                                    @if($produk->levelHargaQuantities->where('is_active', true)->count() > 0)
                                    <p class="text-xs text-blue-600 mt-1">
                                        <i class="fas fa-tag mr-1"></i>Harga quantity tersedia
                                    </p>
                                    @endif
                                    @if($produk->levelHargaGolongans->where('is_active', true)->count() > 0)
                                    <p class="text-xs text-purple-600 mt-1">
                                        <i class="fas fa-crown mr-1"></i>Harga member tersedia
                                    </p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Cart and Checkout (Logika dari Teman) -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-bold mb-4">Keranjang Belanja</h2>
                        
                        <!-- Customer Selection (dari Teman, dengan data-golongan-id) -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pelanggan</label>
                            <select id="pelangganSelect" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="">Umum (Non-Member)</option>
                                @foreach($pelanggans as $pelanggan)
                                <option value="{{ $pelanggan->id }}" 
                                    data-diskon="{{ $pelanggan->golongan->diskon_persen ?? 0 }}"
                                    data-golongan-id="{{ $pelanggan->golongan_id }}">
                                    {{ $pelanggan->nama }} - {{ $pelanggan->golongan->nama_tier }} ({{ $pelanggan->golongan->diskon_persen }}%)
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Cart Items -->
                        <div class="border rounded-lg mb-4 max-h-64 overflow-y-auto">
                            <table class="w-full" id="cartTable">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Produk</th>
                                        <th class="px-3 py-2 text-right text-xs font-medium text-gray-500">Qty</th>
                                        <th class="px-3 py-2 text-right text-xs font-medium text-gray-500">Subtotal</th>
                                        <th class="px-3 py-2 text-right text-xs font-medium text-gray-500"></th>
                                    </tr>
                                </thead>
                                <tbody id="cartItems">
                                    <!-- Cart items will be populated by JavaScript -->
                                </tbody>
                            </table>
                            <div id="emptyCart" class="p-8 text-center text-gray-500">
                                <i class="fas fa-shopping-cart text-4xl mb-2"></i>
                                <p>Keranjang kosong</p>
                            </div>
                        </div>

                        <!-- Totals -->
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between">
                                <span>Subtotal:</span>
                                <span id="subtotalAmount">Rp 0</span>
                            </div>
                            <div class="flex justify-between text-green-600">
                                <span>Diskon:</span>
                                <span id="diskonAmount">Rp 0</span>
                            </div>
                            <div class="flex justify-between font-bold text-lg border-t pt-2">
                                <span>Total:</span>
                                <span id="totalAmount">Rp 0</span>
                            </div>
                        </div>
                        
                        <!-- Applied Pricing Info (dari Teman) -->
                        <div id="pricingInfo" class="mb-4 p-3 bg-blue-50 rounded-lg hidden">
                            <h4 class="font-medium text-blue-900 text-sm mb-2">Info Harga Terpakai:</h4>
                            <div id="pricingDetails" class="text-xs text-blue-800 space-y-1">
                                <!-- Pricing details will be shown here -->
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                            <select id="paymentMethod" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="tunai">Tunai</option>
                                <option value="debit">Debit</option>
                                <option value="kredit">Kredit</option>
                                <option value="qris">QRIS</option>
                            </select>
                        </div>

                        <!-- Amount Paid -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Bayar</label>
                            <input type="number" id="amountPaid" 
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500" 
                                placeholder="0">
                        </div>

                        <!-- Change -->
                        <div class="mb-4">
                            <div class="flex justify-between font-bold text-lg">
                                <span>Kembalian:</span>
                                <span id="changeAmount">Rp 0</span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="space-y-2">
                            <button id="checkoutBtn" 
                                class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed"
                                disabled>
                                <i class="fas fa-check mr-2"></i>Proses Transaksi
                            </button>
                            <button id="clearCartBtn" 
                                class="w-full bg-red-600 text-white py-2 rounded-lg font-semibold hover:bg-red-700 transition-colors">
                                <i class="fas fa-trash mr-2"></i>Kosongkan Keranjang
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Quantity Modal (Identik) -->
    <div id="quantityModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 no-print">
        <div class="bg-white rounded-lg p-6 w-96">
            <h3 class="text-lg font-bold mb-4" id="modalProductName">Produk Name</h3>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah</label>
                <input type="number" id="quantityInput" min="1" value="1" 
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                <p class="text-sm text-gray-500 mt-1" id="modalStockInfo">Stok tersedia: 0</p>
            </div>
            <div class="flex space-x-2">
                <button id="cancelQuantity" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400 transition-colors">
                    Batal
                </button>
                <button id="addToCart" class="flex-1 bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700 transition-colors">
                    Tambah ke Keranjang
                </button>
            </div>
        </div>
    </div>

    <!-- ========== MULAI STRUK MODAL (dari file Anda) ========== -->
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
        let cart = [];
        let currentProduct = null;

        // Product item click (dari Teman)
        $('.product-item').click(function() {
            const productId = $(this).data('produk-id');
            const productName = $(this).data('nama');
            const productPrice = $(this).data('harga');
            const productStock = $(this).data('stok');
            const quantityPrices = $(this).data('quantity-prices');
            const golonganPrices = $(this).data('golongan-prices');
            
            currentProduct = {
                id: productId,
                name: productName,
                price: parseFloat(productPrice),
                stock: parseInt(productStock),
                quantityPrices: quantityPrices || [],
                golonganPrices: golonganPrices || []
            };

            $('#modalProductName').text(productName);
            $('#quantityInput').val(1).attr('max', productStock);
            $('#modalStockInfo').text(`Stok tersedia: ${productStock}`);
            $('#quantityModal').removeClass('hidden').addClass('flex');
        });

        // --- Logika Harga Kompleks (dari Teman) ---
        function getQuantityPrice(product, quantity) {
            let bestPrice = product.price;
            let priceType = 'Reguler';

            for (const priceRule of product.quantityPrices) {
                const min = priceRule.qty_min;
                const max = priceRule.qty_max;
                const price = parseFloat(priceRule.harga_khusus);
                
                if (quantity >= min && (max === null || quantity <= max)) {
                    if (price < bestPrice) {
                        bestPrice = price;
                        priceType = `Quantity (${min}+)`;
                    }
                }
            }
            return { price: bestPrice, type: priceType };
        }

        function getGolonganPrice(product, golonganId) {
            let bestPrice = product.price;
            let priceType = 'Reguler';

            for (const priceRule of product.golonganPrices) {
                if (parseInt(priceRule.golongan_id) === parseInt(golonganId)) {
                    const price = parseFloat(priceRule.harga_khusus);
                    if (price < bestPrice) {
                        bestPrice = price;
                        priceType = 'Member Special';
                    }
                }
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
        // --- Akhir Logika Harga Kompleks ---


        // Add to cart (dari Teman)
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
                // Perbarui harga berdasarkan total kuantitas baru
                const updatedBestPrice = getBestPrice(existingItem, existingItem.quantity, golonganId);
                existingItem.appliedPrice = updatedBestPrice.price;
                existingItem.priceType = updatedBestPrice.type;
                existingItem.subtotal = existingItem.quantity * existingItem.appliedPrice;
            } else {
                cart.push({
                    ...currentProduct,
                    quantity: quantity,
                    appliedPrice: bestPrice.price,
                    priceType: bestPrice.type,
                    subtotal: quantity * bestPrice.price
                });
            }

            updateCartDisplay();
            $('#quantityModal').removeClass('flex').addClass('hidden');
        });

        // Remove from cart (Identik)
        $(document).on('click', '.remove-item', function() {
            const productId = $(this).data('id');
            cart = cart.filter(item => item.id !== productId);
            updateCartDisplay();
        });

        // Update quantity (dari Teman)
        $(document).on('change', '.item-quantity', function() {
            const productId = $(this).data('id');
            const newQuantity = parseInt($(this).val());
            const item = cart.find(item => item.id === productId);
            const golonganSelect = $('#pelangganSelect');
            const golonganId = golonganSelect.val() ? golonganSelect.find(':selected').data('golongan-id') : null;
            
            if (newQuantity < 1) {
                cart = cart.filter(item => item.id !== productId);
            } else if (newQuantity > item.stock) {
                alert('Stok tidak mencukupi!');
                $(this).val(item.quantity);
                return;
            } else {
                const bestPrice = getBestPrice(item, newQuantity, golonganId);
                item.quantity = newQuantity;
                item.appliedPrice = bestPrice.price;
                item.priceType = bestPrice.type;
                item.subtotal = newQuantity * bestPrice.price;
            }
            
            updateCartDisplay();
        });

        // Clear cart (Gabungan)
        $('#clearCartBtn').click(function() {
            if (confirm('Yakin ingin mengosongkan keranjang?')) {
                cart = [];
                updateCartDisplay();
                $('#pricingInfo').addClass('hidden'); // Reset info harga
            }
        });

        // Calculate change (Identik)
        $('#amountPaid').on('input', function() {
            calculateChange();
        });

        // Checkout (GABUNGAN)
        $('#checkoutBtn').click(function() {
            if (cart.length === 0) {
                alert('Keranjang kosong!');
                return;
            }

            const amountPaid = parseFloat($('#amountPaid').val()) || 0;
            const total = calculateTotal();
            
            if (amountPaid < total.finalTotal) {
                alert('Jumlah pembayaran kurang!');
                return;
            }

            if (!confirm('Proses transaksi ini?')) {
                return;
            }

            const formData = {
                items: cart.map(item => ({
                    produk_id: item.id,
                    qty: item.quantity
                })),
                pelanggan_id: $('#pelangganSelect').val() || null,
                metode_pembayaran: $('#paymentMethod').val(),
                amount_paid: amountPaid,
                catatan: ''
            };

            console.log("Mengirim data:", formData);

            $.ajax({
                url: '{{ route("kasir.store-transaksi") }}',
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                // --- Success handler (dari file Anda) ---
                success: function(response) {
                    console.log("Transaksi Berhasil Diterima:", response);

                    if (response.success) {
                        console.log("Memanggil showReceipt...");
                        showReceipt(response.transaksi); // Panggil modal struk
                        console.log("showReceipt Selesai.");

                        // Reset tampilan POS
                        cart = [];
                        updateCartDisplay();
                        $('#amountPaid').val('');
                        $('#pelangganSelect').val('');
                        $('#pricingInfo').addClass('hidden'); // Reset info harga
                        console.log("Reset POS Selesai.");
                    } else {
                        console.error("Server merespon success=false:", response.message);
                        alert('Error: ' + response.message);
                    }
                },
                // --- Error handler (dari file Anda) ---
                error: function(xhr) {
                    console.error("AJAX Error:", xhr.status, xhr.responseText);
                    const error = xhr.responseJSON;
                    alert('Error: ' + (error ? error.message : 'Terjadi kesalahan. Cek console F12.'));
                }
            });
        });

        // Update cart display (dari Teman)
        function updateCartDisplay() {
            const cartItems = $('#cartItems');
            const emptyCart = $('#emptyCart');
            const checkoutBtn = $('#checkoutBtn');
            const pricingInfo = $('#pricingInfo');

            if (cart.length === 0) {
                cartItems.empty();
                emptyCart.show();
                checkoutBtn.prop('disabled', true);
                pricingInfo.addClass('hidden');
            } else {
                emptyCart.hide();
                checkoutBtn.prop('disabled', false);
                
                cartItems.empty();
                let hasSpecialPricing = false;
                const pricingDetails = [];

                cart.forEach(item => {
                    const priceBadge = item.priceType !== 'Reguler' ? 
                        `<span class="text-xs text-green-600 ml-1">(${item.priceType})</span>` : '';

                    const row = `
                        <tr class="border-b">
                            <td class="px-3 py-2">
                                <div class="text-sm font-medium text-gray-900">${item.name}</div>
                                <div class="text-sm text-gray-500">
                                    Rp ${formatNumber(item.appliedPrice)}${priceBadge}
                                </div>
                            </td>
                            <td class="px-3 py-2 text-right">
                                <input type="number" class="item-quantity w-16 text-right border rounded px-1 py-1 text-sm" 
                                    data-id="${item.id}" value="${item.quantity}" min="1" max="${item.stock}">
                            </td>
                            <td class="px-3 py-2 text-right text-sm font-medium">
                                Rp ${formatNumber(item.subtotal)}
                            </td>
                            <td class="px-3 py-2 text-right">
                                <button class="remove-item text-red-600 hover:text-red-800" data-id="${item.id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    cartItems.append(row);

                    if (item.priceType !== 'Reguler') {
                        hasSpecialPricing = true;
                        if (!pricingDetails.includes(item.priceType)) {
                            pricingDetails.push(item.priceType);
                        }
                    }
                });

                if (hasSpecialPricing) {
                    const pricingInfoHtml = pricingDetails.map(detail => 
                        `<div><i class="fas fa-check text-green-500 mr-1"></i>${detail}</div>`
                    ).join('');
                    $('#pricingDetails').html(pricingInfoHtml);
                    pricingInfo.removeClass('hidden');
                } else {
                    pricingInfo.addClass('hidden');
                }
            }

            calculateTotals();
        }

        // Calculate totals (Identik)
        function calculateTotals() {
            const subtotal = cart.reduce((sum, item) => sum + item.subtotal, 0);
            const diskonPersen = $('#pelangganSelect').find(':selected').data('diskon') || 0;
            const diskonAmount = (subtotal * diskonPersen) / 100;
            const finalTotal = subtotal - diskonAmount;

            $('#subtotalAmount').text(`Rp ${formatNumber(subtotal)}`);
            $('#diskonAmount').text(`-Rp ${formatNumber(diskonAmount)}`);
            $('#totalAmount').text(`Rp ${formatNumber(finalTotal)}`);

            calculateChange();
        }

        // Calculate change (Identik)
        function calculateChange() {
            const total = calculateTotal();
            const amountPaid = parseFloat($('#amountPaid').val()) || 0;
            const change = amountPaid - total.finalTotal;
            
            $('#changeAmount').text(`Rp ${formatNumber(Math.max(0, change))}`);
        }

        // Calculate total (Identik)
        function calculateTotal() {
            const subtotal = cart.reduce((sum, item) => sum + item.subtotal, 0);
            const diskonPersen = $('#pelangganSelect').find(':selected').data('diskon') || 0;
            const diskonAmount = (subtotal * diskonPersen) / 100;
            const finalTotal = subtotal - diskonAmount;

            return {
                subtotal,
                diskonAmount,
                finalTotal
            };
        }

        // Format number (dari file Anda, lebih aman)
        function formatNumber(number) {
            const num = parseFloat(number) || 0;
            return num.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        // Modal events
        $('#cancelQuantity').click(function() {
            $('#quantityModal').removeClass('flex').addClass('hidden');
        });

        // Pelanggan select change (dari Teman)
        $('#pelangganSelect').change(function() {
            const golonganId = $(this).val() ? $(this).find(':selected').data('golongan-id') : null;
            
            cart.forEach(item => {
                const bestPrice = getBestPrice(item, item.quantity, golonganId);
                item.appliedPrice = bestPrice.price;
                item.priceType = bestPrice.type;
                item.subtotal = item.quantity * bestPrice.price;
            });
            
            updateCartDisplay();
        });

        // Search functionality (Identik)
        $('#searchProduk').on('input', function() {
            const searchTerm = $(this).val().toLowerCase();
            $('.product-item').each(function() {
                const productName = $(this).data('nama').toLowerCase();
                if (productName.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Initialize (Identik)
        updateCartDisplay();


        // ========== FUNGSI STRUK (dari file Anda) ==========

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
                alert("Terjadi error saat menampilkan struk. Cek console F12.");
            }
        }

        function printReceipt() {
            window.print();
        }

        $('#closeReceipt').click(function() {
            $('#receiptModal').removeClass('flex').addClass('hidden');
            $('#searchProduk').focus();
        });
    </script>
</body>
</html>