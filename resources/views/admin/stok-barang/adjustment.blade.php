<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perubahan Stok - POS System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F3F4F6;
        }
        select {
            cursor: pointer;
        }
    </style>
</head>
<body class="text-gray-800">
    <!-- Navigation -->
    <nav class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-center py-3">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/starlogo.png') }}" alt="Logo" class="h-10 w-auto">
                    <div class="w-px h-8 bg-gray-300"></div>
                    <h1 class="text-xl font-bold text-gray-900">Perubahan Stok</h1>
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
        <div class="w-64 bg-white shadow-sm min-h-screen border-r border-gray-200">
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
                        class="flex items-center px-4 py-3 bg-yellow-50 text-yellow-700 rounded-lg font-medium border border-yellow-200">
                        <i class="fas fa-warehouse mr-3 w-5 text-yellow-600"></i>
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
                        class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                        <i class="fas fa-chart-bar mr-3 w-5"></i>
                        Laporan
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Tambah Perubahan Stok</h2>
                    <p class="text-gray-600 mt-1">Catat pembelian, adjustment, atau perubahan stok lainnya</p>
                </div>
                <a href="{{ route('admin.stok-barang.index') }}" 
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i>Kembali
                </a>
            </div>

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 flex items-center gap-2">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            <div class="max-w-2xl mx-auto">
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-base font-semibold text-gray-900">Form Perubahan Stok</h3>
                    </div>
                    <div class="p-6">
                        <form method="POST" action="{{ route('admin.stok-barang.store-adjustment') }}">
                            @csrf
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1 cursor-pointer">Produk</label>
                                    <select name="produk_id" required 
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 cursor-pointer"
                                        id="produkSelect">
                                        <option value="">Pilih Produk</option>
                                        @foreach($produks as $produk)
                                        <option value="{{ $produk->id }}" data-stok="{{ $produk->stok_sekarang }}">
                                            {{ $produk->nama_produk }} (Stok: {{ $produk->stok_sekarang }} {{ $produk->satuan }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Perubahan</label>
                                    <select name="jenis_perubahan" required 
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 cursor-pointer"
                                        id="jenisPerubahanSelect">
                                        <option value="">Pilih Jenis Perubahan</option>
                                        @foreach($jenisPerubahanOptions as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                                    <input type="number" name="quantity" min="1" required
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                                        placeholder="Jumlah barang"
                                        id="quantityInput">
                                    <p class="text-xs text-gray-500 mt-1" id="quantityHelp">
                                        Masukkan jumlah barang yang berubah
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Perubahan</label>
                                    <input type="datetime-local" name="tanggal_perubahan" required 
                                        value="{{ now()->format('Y-m-d\TH:i') }}"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                                    <textarea name="keterangan" required rows="3"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                                        placeholder="Deskripsi perubahan stok..."
                                        id="keteranganInput"></textarea>
                                    <p class="text-xs text-gray-500 mt-1">Jelaskan alasan perubahan stok (wajib)</p>
                                </div>

                                <!-- Preview Section -->
                                <div id="previewSection" class="hidden p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <h3 class="font-medium text-gray-900 mb-2">Preview Perubahan Stok</h3>
                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-500">Stok Awal:</span>
                                            <span id="previewStokAwal" class="font-medium ml-2">-</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Stok Akhir:</span>
                                            <span id="previewStokAkhir" class="font-medium ml-2">-</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Jenis:</span>
                                            <span id="previewJenis" class="font-medium ml-2">-</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Perubahan:</span>
                                            <span id="previewPerubahan" class="font-medium ml-2">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 flex space-x-3">
                                <button type="submit" 
                                    class="bg-yellow-500 text-gray-900 px-6 py-2 rounded-lg hover:bg-yellow-600 transition-colors font-medium flex items-center gap-2">
                                    <i class="fas fa-save"></i>Simpan Perubahan
                                </button>
                                <button type="reset" 
                                    class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition-colors font-medium flex items-center gap-2">
                                    <i class="fas fa-refresh"></i>Reset
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
                            <h3 class="text-sm font-medium text-blue-800">Jenis Perubahan Stok</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li><strong>Pembelian</strong>: Restock barang dari supplier</li>
                                    <li><strong>Adjustment Masuk</strong>: Koreksi stok (penambahan karena kesalahan input dll)</li>
                                    <li><strong>Adjustment Keluar</strong>: Koreksi stok (pengurangan karena kesalahan input dll)</li>
                                    <li><strong>Retur</strong>: Barang dikembalikan oleh pelanggan</li>
                                    <li><strong>Lainnya</strong>: Barang hilang, rusak, atau sebab lain</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
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

        document.addEventListener('DOMContentLoaded', function() {
            const produkSelect = document.getElementById('produkSelect');
            const jenisPerubahanSelect = document.getElementById('jenisPerubahanSelect');
            const quantityInput = document.getElementById('quantityInput');
            const keteranganInput = document.getElementById('keteranganInput');
            const quantityHelp = document.getElementById('quantityHelp');
            const previewSection = document.getElementById('previewSection');
            const previewStokAwal = document.getElementById('previewStokAwal');
            const previewStokAkhir = document.getElementById('previewStokAkhir');
            const previewJenis = document.getElementById('previewJenis');
            const previewPerubahan = document.getElementById('previewPerubahan');

            // Update quantity help text based on jenis perubahan
            function updateQuantityHelp() {
                const jenis = jenisPerubahanSelect.value;
                let helpText = 'Masukkan jumlah barang yang berubah';
                
                switch(jenis) {
                    case 'pembelian':
                        helpText = 'Jumlah barang yang dibeli dari supplier';
                        break;
                    case 'adjustment_masuk':
                        helpText = 'Jumlah barang yang ditambahkan (koreksi)';
                        break;
                    case 'adjustment_keluar':
                        helpText = 'Jumlah barang yang dikurangi (koreksi)';
                        break;
                    case 'retur':
                        helpText = 'Jumlah barang yang dikembalikan pelanggan';
                        break;
                    case 'lainnya':
                        helpText = 'Jumlah barang yang hilang/rusak/dll';
                        break;
                }
                
                quantityHelp.textContent = helpText;
            }

            // Update preview based on inputs
            function updatePreview() {
                const selectedOption = produkSelect.options[produkSelect.selectedIndex];
                const stokAwal = selectedOption ? parseInt(selectedOption.dataset.stok) : 0;
                const jenis = jenisPerubahanSelect.value;
                const quantity = parseInt(quantityInput.value) || 0;

                if (produkSelect.value && jenis && quantity > 0) {
                    let stokAkhir = stokAwal;
                    let perubahanText = '';
                    
                    switch(jenis) {
                        case 'pembelian':
                        case 'adjustment_masuk':
                        case 'retur':
                            stokAkhir = stokAwal + quantity;
                            perubahanText = `+${quantity}`;
                            break;
                        case 'adjustment_keluar':
                        case 'lainnya':
                            stokAkhir = stokAwal - quantity;
                            perubahanText = `-${quantity}`;
                            break;
                    }

                    previewStokAwal.textContent = stokAwal;
                    previewStokAkhir.textContent = stokAkhir;
                    previewJenis.textContent = jenisPerubahanSelect.options[jenisPerubahanSelect.selectedIndex].text;
                    previewPerubahan.textContent = perubahanText;

                    // Show warning if stock goes negative
                    if (stokAkhir < 0) {
                        previewStokAkhir.classList.add('text-red-600');
                        previewStokAkhir.classList.remove('text-gray-900');
                    } else {
                        previewStokAkhir.classList.remove('text-red-600');
                        previewStokAkhir.classList.add('text-gray-900');
                    }

                    previewSection.classList.remove('hidden');
                } else {
                    previewSection.classList.add('hidden');
                }
            }

            // Auto-fill keterangan based on jenis perubahan
            function autoFillKeterangan() {
                const jenis = jenisPerubahanSelect.value;
                const produkName = produkSelect.options[produkSelect.selectedIndex]?.text.split(' (Stok:')[0] || '';
                
                if (jenis && produkName && !keteranganInput.value) {
                    let keterangan = '';
                    
                    switch(jenis) {
                        case 'pembelian':
                            keterangan = `Pembelian ${produkName} dari supplier`;
                            break;
                        case 'adjustment_masuk':
                            keterangan = `Koreksi stok ${produkName} - penambahan`;
                            break;
                        case 'adjustment_keluar':
                            keterangan = `Koreksi stok ${produkName} - pengurangan`;
                            break;
                        case 'retur':
                            keterangan = `Retur ${produkName} dari pelanggan`;
                            break;
                        case 'lainnya':
                            keterangan = `Perubahan stok ${produkName} - lainnya`;
                            break;
                    }
                    
                    keteranganInput.value = keterangan;
                }
            }

            // Event listeners
            produkSelect.addEventListener('change', updatePreview);
            jenisPerubahanSelect.addEventListener('change', function() {
                updateQuantityHelp();
                updatePreview();
                autoFillKeterangan();
            });
            quantityInput.addEventListener('input', updatePreview);
            
            // Initial setup
            updateQuantityHelp();
        });
    </script>
</body>
</html>