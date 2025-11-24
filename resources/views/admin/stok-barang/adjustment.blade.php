<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adjustment Stok - POS System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-cash-register text-2xl"></i>
                    <span class="text-xl font-bold">POS System - Admin</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span>Halo, {{ auth()->user()->nama }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-blue-700 hover:bg-blue-800 px-4 py-2 rounded-lg">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar and Main Content -->
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg min-h-screen">
            <nav class="mt-6">
                <div class="px-4 space-y-2">
                    <a href="{{ route('admin.dashboard') }}" 
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.produk.index') }}" 
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-box mr-3"></i>
                        Manajemen Produk
                    </a>
                    <a href="{{ route('admin.stok-barang.index') }}" 
                        class="flex items-center px-4 py-3 bg-blue-100 text-blue-700 rounded-lg">
                        <i class="fas fa-warehouse mr-3"></i>
                        Riwayat Stok
                    </a>
                    <a href="{{ route('admin.level-harga.index') }}" 
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-tags mr-3"></i>
                        Level Harga
                    </a>
                    <a href="{{ route('admin.golongan.index') }}" 
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-users mr-3"></i>
                        Golongan Member
                    </a>
                    <a href="{{ route('admin.pelanggan.index') }}" 
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-user-friends mr-3"></i>
                        Data Pelanggan
                    </a>
                    <a href="{{ route('admin.laporan.index') }}" 
                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-chart-bar mr-3"></i>
                        Laporan
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Adjustment Stok</h1>
                    <p class="text-gray-600">Koreksi atau penyesuaian stok barang</p>
                </div>
                <a href="{{ route('admin.stok-barang.index') }}" 
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="max-w-2xl mx-auto">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Form Adjustment Stok</h2>
                    </div>
                    <div class="p-6">
                        <form method="POST" action="{{ route('admin.stok-barang.store-adjustment') }}">
                            @csrf
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Produk</label>
                                    <select name="produk_id" required 
                                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Pilih Produk</option>
                                        @foreach($produks as $produk)
                                        <option value="{{ $produk->id }}" data-stok="{{ $produk->stok_sekarang }}">
                                            {{ $produk->nama_produk }} (Stok: {{ $produk->stok_sekarang }} {{ $produk->satuan }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok Masuk</label>
                                        <input type="number" name="qty_masuk" min="0" 
                                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            placeholder="0">
                                        <p class="text-xs text-gray-500 mt-1">Jumlah barang yang ditambahkan ke stok</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok Keluar</label>
                                        <input type="number" name="qty_keluar" min="0" 
                                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            placeholder="0">
                                        <p class="text-xs text-gray-500 mt-1">Jumlah barang yang dikurangi dari stok</p>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Perubahan</label>
                                    <input type="datetime-local" name="tanggal_perubahan" required 
                                        value="{{ now()->format('Y-m-d\TH:i') }}"
                                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                                    <textarea name="keterangan" required rows="3"
                                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="Alasan adjustment stok..."></textarea>
                                    <p class="text-xs text-gray-500 mt-1">Jelaskan alasan penyesuaian stok (wajib)</p>
                                </div>

                                <!-- Preview Section -->
                                <div id="previewSection" class="hidden p-4 bg-gray-50 rounded-lg">
                                    <h3 class="font-medium text-gray-900 mb-2">Preview Adjustment</h3>
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
                                            <span class="text-gray-500">Perubahan:</span>
                                            <span id="previewPerubahan" class="font-medium ml-2">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 flex space-x-3">
                                <button type="submit" 
                                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-save mr-2"></i>Simpan Adjustment
                                </button>
                                <button type="reset" 
                                    class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                                    <i class="fas fa-refresh mr-2"></i>Reset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Information Card -->
                <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="shrink-0">
                            <i class="fas fa-info-circle text-yellow-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Informasi Penting</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Adjustment stok akan langsung mempengaruhi stok produk</li>
                                    <li>Pastikan keterangan diisi dengan jelas untuk audit trail</li>
                                    <li>Stok akhir tidak boleh bernilai minus</li>
                                    <li>Riwayat adjustment akan tercatat permanen</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const produkSelect = document.querySelector('select[name="produk_id"]');
            const qtyMasukInput = document.querySelector('input[name="qty_masuk"]');
            const qtyKeluarInput = document.querySelector('input[name="qty_keluar"]');
            const previewSection = document.getElementById('previewSection');
            const previewStokAwal = document.getElementById('previewStokAwal');
            const previewStokAkhir = document.getElementById('previewStokAkhir');
            const previewPerubahan = document.getElementById('previewPerubahan');

            function updatePreview() {
                const selectedOption = produkSelect.options[produkSelect.selectedIndex];
                const stokAwal = selectedOption ? parseInt(selectedOption.dataset.stok) : 0;
                const qtyMasuk = parseInt(qtyMasukInput.value) || 0;
                const qtyKeluar = parseInt(qtyKeluarInput.value) || 0;
                const stokAkhir = stokAwal + qtyMasuk - qtyKeluar;

                if (produkSelect.value && (qtyMasuk > 0 || qtyKeluar > 0)) {
                    previewStokAwal.textContent = stokAwal;
                    previewStokAkhir.textContent = stokAkhir;
                    
                    let perubahanText = '';
                    if (qtyMasuk > 0 && qtyKeluar > 0) {
                        perubahanText = `+${qtyMasuk} / -${qtyKeluar}`;
                    } else if (qtyMasuk > 0) {
                        perubahanText = `+${qtyMasuk}`;
                    } else if (qtyKeluar > 0) {
                        perubahanText = `-${qtyKeluar}`;
                    }
                    previewPerubahan.textContent = perubahanText;

                    previewSection.classList.remove('hidden');
                } else {
                    previewSection.classList.add('hidden');
                }
            }

            produkSelect.addEventListener('change', updatePreview);
            qtyMasukInput.addEventListener('input', updatePreview);
            qtyKeluarInput.addEventListener('input', updatePreview);
        });
    </script>
</body>
</html>