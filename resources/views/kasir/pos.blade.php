<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS - Kasir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body style="background-color: #2f3136;">
    <!-- Navigation -->
    <nav class="text-white shadow-lg" style="background-color: #FFDB58;">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-cash-register text-2xl"></i>
                    <span class="text-xl font-bold">POS System - Kasir</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('kasir.riwayat') }}" class="px-4 py-2 rounded-lg" style="background-color: #2f3136; hover-bg color: #2f3136">
                        <i class="fas fa-history mr-2"></i>Riwayat
                    </a>
                    <span>Halo, {{ auth()->user()->nama }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 rounded-lg" style="background-color: #2f3136; hover-bg color: #2f3136">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto p-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Product List -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-4">Daftar Produk</h2>
                    
                    <!-- Search and Filter -->
                    <div class="mb-6">
                        <input type="text" id="searchProduk" placeholder="Cari produk..." 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>

                    <!-- Product Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 max-h-96 overflow-y-auto">
                        @foreach($produks as $produk)
                        

                        <div class="bg-gray-50 rounded-lg p-4 cursor-pointer hover:bg-purple-50 transition-colors product-item"
                            data-produk-id="{{ $produk->id }}"
                            data-nama="{{ $produk->nama_produk }}"
                            data-harga="{{ $produk->harga_dasar }}"
                            data-stok="{{ $produk->stok_sekarang }}"
                            data-gambar="{{ $produk->gambar_url }}">
                            <div class="text-center">
                                <img src="{{ $produk->gambar_url }}" alt="{{ $produk->nama_produk }}" 
                                    class="w-16 h-16 mx-auto rounded-lg object-cover mb-2">
                                <h3 class="font-semibold text-sm text-gray-900">{{ $produk->nama_produk }}</h3>
                                <p class="text-green-600 font-bold text-sm">Rp {{ number_format($produk->harga_dasar, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-500">Stok: {{ $produk->stok_sekarang }} {{ $produk->satuan }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Cart and Checkout -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-4">Keranjang Belanja</h2>
                    
                    <!-- Customer Selection -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pelanggan</label>
                        <select id="pelangganSelect" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option value="">Umum (Non-Member)</option>
                            @foreach($pelanggans as $pelanggan)
                            <option value="{{ $pelanggan->id }}" data-diskon="{{ $pelanggan->golongan->diskon_persen ?? 0 }}">
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

    <!-- Product Quantity Modal -->
    <div id="quantityModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
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

    <script>
        let cart = [];
        let currentProduct = null;

        // Product item click
        $('.product-item').click(function() {
            const productId = $(this).data('produk-id');
            const productName = $(this).data('nama');
            const productPrice = $(this).data('harga');
            const productStock = $(this).data('stok');
            
            currentProduct = {
                id: productId,
                name: productName,
                price: parseFloat(productPrice),
                stock: parseInt(productStock)
            };

            $('#modalProductName').text(productName);
            $('#quantityInput').val(1).attr('max', productStock);
            $('#modalStockInfo').text(`Stok tersedia: ${productStock}`);
            $('#quantityModal').removeClass('hidden').addClass('flex');
        });

        // Add to cart
        $('#addToCart').click(function() {
            const quantity = parseInt($('#quantityInput').val());
            
            if (quantity < 1 || quantity > currentProduct.stock) {
                alert('Jumlah tidak valid!');
                return;
            }

            // Check if product already in cart
            const existingItem = cart.find(item => item.id === currentProduct.id);
            
            if (existingItem) {
                if (existingItem.quantity + quantity > currentProduct.stock) {
                    alert('Stok tidak mencukupi!');
                    return;
                }
                existingItem.quantity += quantity;
                existingItem.subtotal = existingItem.quantity * existingItem.price;
            } else {
                cart.push({
                    ...currentProduct,
                    quantity: quantity,
                    subtotal: quantity * currentProduct.price
                });
            }

            updateCartDisplay();
            $('#quantityModal').removeClass('flex').addClass('hidden');
        });

        // Remove from cart
        $(document).on('click', '.remove-item', function() {
            const productId = $(this).data('id');
            cart = cart.filter(item => item.id !== productId);
            updateCartDisplay();
        });

        // Update quantity
        $(document).on('change', '.item-quantity', function() {
            const productId = $(this).data('id');
            const newQuantity = parseInt($(this).val());
            const item = cart.find(item => item.id === productId);
            
            if (newQuantity < 1) {
                cart = cart.filter(item => item.id !== productId);
            } else if (newQuantity > item.stock) {
                alert('Stok tidak mencukupi!');
                $(this).val(item.quantity);
                return;
            } else {
                item.quantity = newQuantity;
                item.subtotal = newQuantity * item.price;
            }
            
            updateCartDisplay();
        });

        // Clear cart
        $('#clearCartBtn').click(function() {
            if (confirm('Yakin ingin mengosongkan keranjang?')) {
                cart = [];
                updateCartDisplay();
            }
        });

        // Calculate change
        $('#amountPaid').on('input', function() {
            calculateChange();
        });

        // Checkout
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

            $.ajax({
                url: '{{ route("kasir.store-transaksi") }}',
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        alert('Transaksi berhasil! Kode: ' + response.transaksi.kode_transaksi);
                        cart = [];
                        updateCartDisplay();
                        $('#amountPaid').val('');
                        $('#pelangganSelect').val('');
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr) {
                    const error = xhr.responseJSON;
                    alert('Error: ' + (error.message || 'Terjadi kesalahan'));
                }
            });
        });

        // Update cart display
        function updateCartDisplay() {
            const cartItems = $('#cartItems');
            const emptyCart = $('#emptyCart');
            const checkoutBtn = $('#checkoutBtn');

            if (cart.length === 0) {
                cartItems.empty();
                emptyCart.show();
                checkoutBtn.prop('disabled', true);
            } else {
                emptyCart.hide();
                checkoutBtn.prop('disabled', false);
                
                cartItems.empty();
                cart.forEach(item => {
                    const row = `
                        <tr class="border-b">
                            <td class="px-3 py-2">
                                <div class="text-sm font-medium text-gray-900">${item.name}</div>
                                <div class="text-sm text-gray-500">Rp ${formatNumber(item.price)}</div>
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
                });
            }

            calculateTotals();
        }

        // Calculate totals
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

        // Calculate change
        function calculateChange() {
            const total = calculateTotal();
            const amountPaid = parseFloat($('#amountPaid').val()) || 0;
            const change = amountPaid - total.finalTotal;
            
            $('#changeAmount').text(`Rp ${formatNumber(Math.max(0, change))}`);
        }

        // Calculate total
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

        // Format number
        function formatNumber(number) {
            return number.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        // Modal events
        $('#cancelQuantity').click(function() {
            $('#quantityModal').removeClass('flex').addClass('hidden');
        });

        $('#pelangganSelect').change(function() {
            calculateTotals();
        });

        // Search functionality
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

        // Initialize
        updateCartDisplay();
    </script>
</body>
</html>
