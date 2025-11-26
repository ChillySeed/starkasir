<?php
// routes/web.php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\ProdukController as AdminProduk;
use App\Http\Controllers\Admin\StokBarangController ;
use App\Http\Controllers\Admin\GolonganController as AdminGolongan;
use App\Http\Controllers\Admin\PelangganController as AdminPelanggan;
use App\Http\Controllers\Admin\LevelHargaController as AdminLevelHarga;
use App\Http\Controllers\Kasir\POSController as KasirPos;
use App\Http\Controllers\Admin\LaporanController;

// Authentication Routes
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Quick login for demo
Route::get('/quick-login/{role}', [AuthController::class, 'quickLogin'])->name('quick-login');

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/dashboard/data', [AdminDashboard::class, 'getDashboardData'])->name('admin.dashboard.data');
    
    // Produk Routes
    Route::resource('produk', AdminProduk::class)->names('admin.produk');
    Route::post('produk/{produk}/update-stok', [AdminProduk::class, 'updateStok'])->name('admin.produk.update-stok');
    
    // Golongan Routes
    Route::resource('golongan', AdminGolongan::class)->names('admin.golongan');
    
    // Pelanggan Routes
    Route::resource('pelanggan', AdminPelanggan::class)->names('admin.pelanggan');
    
    // Level Harga Routes - FIXED: Add 'admin.' prefix to route names
    Route::prefix('level-harga')->name('admin.level-harga.')->group(function () {
        Route::get('/', [AdminLevelHarga::class, 'index'])->name('index');
        Route::get('/{id}', [AdminLevelHarga::class, 'show'])->name('show');
        
        // Quantity routes
        Route::post('/quantity', [AdminLevelHarga::class, 'storeQuantity'])->name('store-quantity');
        Route::put('/quantity/{levelHargaQuantity}', [AdminLevelHarga::class, 'updateQuantity'])->name('update-quantity');
        Route::delete('/quantity/{levelHargaQuantity}', [AdminLevelHarga::class, 'destroyQuantity'])->name('destroy-quantity');
        
        // Golongan routes
        Route::post('/golongan', [AdminLevelHarga::class, 'storeGolongan'])->name('store-golongan');
        Route::put('/golongan/{levelHargaGolongan}', [AdminLevelHarga::class, 'updateGolongan'])->name('update-golongan');
        Route::delete('/golongan/{levelHargaGolongan}', [AdminLevelHarga::class, 'destroyGolongan'])->name('destroy-golongan');
    });
    Route::prefix('admin/stok-barang')->name('admin.stok-barang.')->group(function () {
        Route::get('/', [StokBarangController::class, 'index'])->name('index');
        Route::get('/export', [StokBarangController::class, 'export'])->name('export');
        Route::get('/produk/{produk}', [StokBarangController::class, 'show'])->name('show');
        Route::get('/adjustment', [StokBarangController::class, 'createAdjustment'])->name('create-adjustment');
        Route::post('/adjustment', [StokBarangController::class, 'storeAdjustment'])->name('store-adjustment');
    });

    Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');

    Route::get('/laporan/transaksi', [LaporanController::class, 'showTransaksiForm'])
         ->name('admin.laporan.transaksi.form');
         
    Route::get('/laporan/transaksi/hasil', [LaporanController::class, 'generateTransaksi'])
         ->name('admin.laporan.transaksi.generate');

});

// Kasir Routes
Route::prefix('kasir')->middleware(['auth', 'kasir'])->group(function () {
    Route::get('/pos', [KasirPos::class, 'index'])->name('kasir.pos');
    Route::get('/produk/{id}', [KasirPos::class, 'getProduk'])->name('kasir.get-produk');
    Route::post('/transaksi', [KasirPos::class, 'storeTransaksi'])->name('kasir.store-transaksi');
    Route::get('/riwayat', [KasirPos::class, 'riwayatTransaksi'])->name('kasir.riwayat');
    Route::get('/transaksi/{transaksi}', [KasirPos::class, 'showTransaksi'])->name('kasir.show-transaksi');
    
    // --- Route ini ditambahkan dari file Anda ---
    Route::get('/transaksi-json/{transaksi}', [KasirPos::class, 'getTransaksiJson'])->name('kasir.transaksi-json');
});