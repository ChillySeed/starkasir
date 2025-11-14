<?php
// routes/web.php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\ProdukController as AdminProduk;
use App\Http\Controllers\Admin\GolonganController as AdminGolongan;
use App\Http\Controllers\Admin\PelangganController as AdminPelanggan;
use App\Http\Controllers\Kasir\PosController as KasirPos;

// Authentication Routes
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Quick login for demo
Route::get('/quick-login/{role}', [AuthController::class, 'quickLogin'])->name('quick-login');

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'dashboard'])->name('admin.dashboard');
    
    // Produk Routes
    Route::resource('produk', AdminProduk::class)->names('admin.produk');
    Route::post('produk/{produk}/update-stok', [AdminProduk::class, 'updateStok'])->name('admin.produk.update-stok');
    
    // Golongan Routes
    Route::resource('golongan', AdminGolongan::class)->names('admin.golongan');
    
    // Pelanggan Routes
    Route::resource('pelanggan', AdminPelanggan::class)->names('admin.pelanggan');
});

// Kasir Routes
Route::prefix('kasir')->middleware(['auth', 'kasir'])->group(function () {
    Route::get('/pos', [KasirPos::class, 'index'])->name('kasir.pos');
    Route::get('/produk/{id}', [KasirPos::class, 'getProduk'])->name('kasir.get-produk');
    Route::post('/transaksi', [KasirPos::class, 'storeTransaksi'])->name('kasir.store-transaksi');
    Route::get('/riwayat', [KasirPos::class, 'riwayatTransaksi'])->name('kasir.riwayat');
    Route::get('/transaksi/{transaksi}', [KasirPos::class, 'showTransaksi'])->name('kasir.show-transaksi');
});