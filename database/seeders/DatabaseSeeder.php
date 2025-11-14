<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Golongan;
use App\Models\Produk;
use App\Models\Pelanggan;

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
                'stok_awal' => 50,
                'stok_sekarang' => 50,
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
                'nama_produk' => 'Paket Makanan Anak',
                'satuan' => 'kemasan',
                'harga_dasar' => 45000,
                'stok_awal' => 30,
                'stok_sekarang' => 30,
                'is_active' => 1,
                'gambar' => 'paket-makanan-anak.jpg',
                'deskripsi' => 'Paket makanan anak dengan menu bergizi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_produk' => 'PRD020',
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
                'kode_pelanggan' => 'CUST001',
                'nama' => 'Budi Santoso',
                'golongan_id' => 2, // Bronze
                'no_telp' => '081234567890',
                'alamat' => 'Jl. Merdeka No. 123',
            ],
            [
                'kode_pelanggan' => 'CUST002',
                'nama' => 'Sari Indah',
                'golongan_id' => 3, // Silver
                'no_telp' => '081298765432',
                'alamat' => 'Jl. Sudirman No. 45',
            ],
            [
                'kode_pelanggan' => 'CUST003',
                'nama' => 'Ahmad Wijaya',
                'golongan_id' => 4, // Gold
                'no_telp' => '081277788899',
                'alamat' => 'Jl. Gatot Subroto No. 67',
            ],
        ];

        foreach ($pelanggans as $pelanggan) {
            Pelanggan::create($pelanggan);
        }
    }
}