<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Golongan;
use App\Models\Produk;
use App\Models\Pelanggan;
use App\Models\LevelHargaQuantity;
use App\Models\LevelHargaGolongan;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\StokBarang;
use App\Models\Laporan;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create Users
        User::create([
            'username' => 'admin',
            'password' => Hash::make('password'),
            'nama' => 'Administrator',
            'email' => 'admin@pos.com',
            'role' => 'admin',
        ]);

        User::create([
            'username' => 'kasir',
            'password' => Hash::make('password'),
            'nama' => 'Kasir Utama',
            'email' => 'kasir@pos.com',
            'role' => 'kasir',
        ]);

        // Create Golongan
        $golongans = [
            ['nama_tier' => 'General', 'diskon_persen' => 0, 'deskripsi' => 'Pelanggan umum'],
            ['nama_tier' => 'Bronze', 'diskon_persen' => 5, 'deskripsi' => 'Member bronze'],
            ['nama_tier' => 'Silver', 'diskon_persen' => 10, 'deskripsi' => 'Member silver'],
            ['nama_tier' => 'Gold', 'diskon_persen' => 15, 'deskripsi' => 'Member gold'],
        ];

        foreach ($golongans as $golongan) {
            Golongan::create($golongan);
        }

        // Create Sample Products
        $produks = [
            [
                'kode_produk' => 'PRD001',
                'nama_produk' => 'Kopi Arabica 250gr',
                'satuan' => 'kemasan',
                'harga_dasar' => 75000,
                'stok_awal' => 150,
                'stok_sekarang' => 150,
                'is_active' => 1,
                'gambar' => 'kopi-arabica-250gr.jpg',
                'deskripsi' => 'Kopi arabica pilihan, diproses dengan cara terbaik.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_produk' => 'PRD002',
                'nama_produk' => 'Teh Hijau 100gr',
                'satuan' => 'kemasan',
                'harga_dasar' => 35000,
                'stok_awal' => 30,
                'stok_sekarang' => 30,
                'is_active' => 1,
                'gambar' => 'teh-hijau-100gr.jpg',
                'deskripsi' => 'Teh hijau organik dengan rasa yang segar dan menyehatkan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_produk' => 'PRD003',
                'nama_produk' => 'Air Mineral 600ml',
                'satuan' => 'botol',
                'harga_dasar' => 5000,
                'stok_awal' => 100,
                'stok_sekarang' => 100,
                'is_active' => 1,
                'gambar' => 'air-mineral-600ml.jpg',
                'deskripsi' => 'Air mineral dalam kemasan botol praktis.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_produk' => 'PRD004',
                'nama_produk' => 'Snack Coklat',
                'satuan' => 'pcs',
                'harga_dasar' => 12000,
                'stok_awal' => 80,
                'stok_sekarang' => 80,
                'is_active' => 1,
                'gambar' => 'snack-coklat.jpg',
                'deskripsi' => 'Snack coklat enak dengan rasa manis yang memanjakan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_produk' => 'PRD005',
                'nama_produk' => 'Mie Instan',
                'satuan' => 'pcs',
                'harga_dasar' => 3000,
                'stok_awal' => 200,
                'stok_sekarang' => 200,
                'is_active' => 1,
                'gambar' => 'mie-instan.jpg',
                'deskripsi' => 'Mie instan dengan berbagai pilihan rasa yang lezat.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_produk' => 'PRD006',
                'nama_produk' => 'Beras 5kg',
                'satuan' => 'kg',
                'harga_dasar' => 50000,
                'stok_awal' => 150,
                'stok_sekarang' => 150,
                'is_active' => 1,
                'gambar' => 'beras-5kg.jpg',
                'deskripsi' => 'Beras kualitas premium, sangat cocok untuk keluarga.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_produk' => 'PRD007',
                'nama_produk' => 'Telur Ayam 1 Dus',
                'satuan' => 'pcs',
                'harga_dasar' => 50000,
                'stok_awal' => 80,
                'stok_sekarang' => 80,
                'is_active' => 1,
                'gambar' => 'telur-ayam.jpg',
                'deskripsi' => 'Telur ayam segar, kualitas terbaik untuk masakan Anda.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_produk' => 'PRD008',
                'nama_produk' => 'Minyak Goreng 1L',
                'satuan' => 'botol',
                'harga_dasar' => 25000,
                'stok_awal' => 100,
                'stok_sekarang' => 100,
                'is_active' => 1,
                'gambar' => 'minyak-goreng.jpg',
                'deskripsi' => 'Minyak goreng murni untuk memasak sehari-hari.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_produk' => 'PRD009',
                'nama_produk' => 'Sabun Mandi 125gr',
                'satuan' => 'pcs',
                'harga_dasar' => 5000,
                'stok_awal' => 200,
                'stok_sekarang' => 200,
                'is_active' => 1,
                'gambar' => 'sabun-mandi.jpg',
                'deskripsi' => 'Sabun mandi dengan bahan alami yang menyegarkan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_produk' => 'PRD010',
                'nama_produk' => 'Deterjen 1kg',
                'satuan' => 'kg',
                'harga_dasar' => 30000,
                'stok_awal' => 120,
                'stok_sekarang' => 120,
                'is_active' => 1,
                'gambar' => 'deterjen.jpg',
                'deskripsi' => 'Deterjen untuk mencuci pakaian dengan hasil bersih dan wangi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_produk' => 'PRD011',
                'nama_produk' => 'Pasta Spaghetti 500gr',
                'satuan' => 'kemasan',
                'harga_dasar' => 22000,
                'stok_awal' => 70,
                'stok_sekarang' => 70,
                'is_active' => 1,
                'gambar' => 'pasta-spaghetti.jpg',
                'deskripsi' => 'Pasta spaghetti berkualitas untuk hidangan Italia.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_produk' => 'PRD012',
                'nama_produk' => 'Keju Cheddar 200gr',
                'satuan' => 'kemasan',
                'harga_dasar' => 45000,
                'stok_awal' => 60,
                'stok_sekarang' => 60,
                'is_active' => 1,
                'gambar' => 'keju-cheddar.jpg',
                'deskripsi' => 'Keju cheddar lezat, sempurna untuk roti dan masakan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_produk' => 'PRD013',
                'nama_produk' => 'Mayones 500gr',
                'satuan' => 'kemasan',
                'harga_dasar' => 22000,
                'stok_awal' => 40,
                'stok_sekarang' => 40,
                'is_active' => 1,
                'gambar' => 'mayones.jpg',
                'deskripsi' => 'Mayones creamy untuk berbagai hidangan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_produk' => 'PRD014',
                'nama_produk' => 'Coca Cola 500ml',
                'satuan' => 'botol',
                'harga_dasar' => 12000,
                'stok_awal' => 150,
                'stok_sekarang' => 150,
                'is_active' => 1,
                'gambar' => 'coca-cola.jpg',
                'deskripsi' => 'Minuman ringan Coca Cola, menyegarkan di setiap waktu.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_produk' => 'PRD015',
                'nama_produk' => 'Sprite 500ml',
                'satuan' => 'botol',
                'harga_dasar' => 12000,
                'stok_awal' => 150,
                'stok_sekarang' => 150,
                'is_active' => 1,
                'gambar' => 'sprite.jpg',
                'deskripsi' => 'Minuman ringan Sprite dengan rasa lemon-lime.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_produk' => 'PRD016',
                'nama_produk' => 'Biskuit Coklat 150gr',
                'satuan' => 'kemasan',
                'harga_dasar' => 15000,
                'stok_awal' => 100,
                'stok_sekarang' => 100,
                'is_active' => 1,
                'gambar' => 'biskuit-coklat.jpg',
                'deskripsi' => 'Biskuit coklat yang enak dan renyah.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_produk' => 'PRD017',
                'nama_produk' => 'Yogurt 400gr',
                'satuan' => 'kemasan',
                'harga_dasar' => 18000,
                'stok_awal' => 50,
                'stok_sekarang' => 50,
                'is_active' => 1,
                'gambar' => 'yogurt.jpg',
                'deskripsi' => 'Yogurt segar dan menyehatkan untuk pencernaan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_produk' => 'PRD018',
                'nama_produk' => 'Susu UHT 1L',
                'satuan' => 'botol',
                'harga_dasar' => 15000,
                'stok_awal' => 200,
                'stok_sekarang' => 200,
                'is_active' => 1,
                'gambar' => 'susu-uht.jpg',
                'deskripsi' => 'Susu UHT segar dalam kemasan botol praktis.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_produk' => 'PRD019',
                'nama_produk' => 'Sereal Sarapan 500gr',
                'satuan' => 'kemasan',
                'harga_dasar' => 35000,
                'stok_awal' => 50,
                'stok_sekarang' => 50,
                'is_active' => 1,
                'gambar' => 'sereal-sarapan.jpg',
                'deskripsi' => 'Sereal sarapan sehat dan mengenyangkan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($produks as $produk) {
            Produk::create($produk);
        }

        // Create Sample Customers
        $pelanggans = [
            [
                'kode_pelanggan' => 'CUST004',
                'nama' => 'Dewi Lestari',
                'golongan_id' => 1, // General
                'no_telp' => '081311122233',
                'alamat' => 'Jl. Melati No. 12',
            ],
            [
                'kode_pelanggan' => 'CUST005',
                'nama' => 'Rizki Pratama',
                'golongan_id' => 1, // General
                'no_telp' => '081322233344',
                'alamat' => 'Jl. Anggrek No. 34',
            ],
            [
                'kode_pelanggan' => 'CUST006',
                'nama' => 'Maya Sari',
                'golongan_id' => 2, // Bronze
                'no_telp' => '081333344455',
                'alamat' => 'Jl. Mawar No. 56',
            ],
            [
                'kode_pelanggan' => 'CUST007',
                'nama' => 'Hendra Wijaya',
                'golongan_id' => 2, // Bronze
                'no_telp' => '081344455566',
                'alamat' => 'Jl. Kenanga No. 78',
            ],
            [
                'kode_pelanggan' => 'CUST008',
                'nama' => 'Linda Hartati',
                'golongan_id' => 3, // Silver
                'no_telp' => '081355566677',
                'alamat' => 'Jl. Flamboyan No. 90',
            ],
            [
                'kode_pelanggan' => 'CUST009',
                'nama' => 'Fajar Nugroho',
                'golongan_id' => 4, // Gold
                'no_telp' => '081366677788',
                'alamat' => 'Jl. Bougenville No. 11',
            ],
            [
                'kode_pelanggan' => 'CUST010',
                'nama' => 'Siti Rahayu',
                'golongan_id' => 4, // Gold
                'no_telp' => '081377788899',
                'alamat' => 'Jl. Kamboja No. 22',
            ],
        ];

        foreach ($pelanggans as $pelanggan) {
            Pelanggan::create($pelanggan);
        }
        $levelHargaQuantities = [
        [
            'produk_id' => 1,
            'qty_min' => 10,
            'qty_max' => 49,
            'harga_khusus' => 70000,
            'keterangan' => 'Harga grosir kecil',
        ],
        [
            'produk_id' => 1,
            'qty_min' => 50,
            'harga_khusus' => 65000,
            'keterangan' => 'Harga grosir besar',
        ],
        [
            'produk_id' => 2,
            'qty_min' => 5,
            'harga_khusus' => 32000,
            'keterangan' => 'Harga khusus quantity',
        ],
        ];

        foreach ($levelHargaQuantities as $level) {
            LevelHargaQuantity::create($level);
        }

        // Create sample LevelHargaGolongan
        $levelHargaGolongans = [
            [
                'produk_id' => 1,
                'golongan_id' => 4, // Gold
                'harga_khusus' => 68000,
                'keterangan' => 'Harga khusus member gold',
            ],
            [
                'produk_id' => 2,
                'golongan_id' => 3, // Silver
                'harga_khusus' => 33000,
                'keterangan' => 'Harga khusus member silver',
            ],
        ];

        foreach ($levelHargaGolongans as $level) {
            LevelHargaGolongan::create($level);
        }
        for ($i = 0; $i < 50; $i++) {
            $daysAgo = rand(0, 6);
            $transactionDate = Carbon::now()->subDays($daysAgo);
            
            $transaksi = Transaksi::create([
                'kode_transaksi' => 'TRX-' . $transactionDate->format('Ymd') . '-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'user_id' => 2, // kasir
                'pelanggan_id' => rand(1, 3),
                'tanggal_transaksi' => $transactionDate,
                'total_amount' => rand(50000, 500000),
                'total_diskon' => rand(0, 50000),
                'amount_paid' => rand(50000, 500000),
                'kembalian' => rand(0, 50000),
                'metode_pembayaran' => ['tunai', 'debit', 'qris'][rand(0, 2)],
                'status' => 'completed',
            ]);

            // Create transaction details
            $produkCount = rand(1, 5);
            for ($j = 0; $j < $produkCount; $j++) {
                $produk = Produk::find(rand(1, 5));
                $qty = rand(1, 10);
                
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $produk->id,
                    'qty' => $qty,
                    'harga_satuan' => $produk->harga_dasar,
                    'diskon_persen' => 0,
                    'diskon_amount' => 0,
                    'subtotal' => $qty * $produk->harga_dasar,
                ]);

                // Record stock movement
                StokBarang::recordMovement(
                    $produk->id,
                    'penjualan',
                    $qty,
                    "Penjualan transaksi {$transaksi->kode_transaksi}",
                    $transaksi->id
                );
            }
        }

        // Create some stock adjustments
        StokBarang::recordMovement(1, 'pembelian', 20, 'Restock supplier', null);
        StokBarang::recordMovement(2, 'pembelian', 15, 'Restock supplier', null);
        StokBarang::recordMovement(3, 'adjustment', 5, 'Koreksi stok', null);
        }
    }