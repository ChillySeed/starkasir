<?php
// app/Http/Controllers/Admin/DashboardController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Produk;
use App\Models\Pelanggan;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $today = Carbon::today();
        
        $stats = [
            'total_transaksi_hari_ini' => Transaksi::whereDate('tanggal_transaksi', $today)->count(),
            'total_pendapatan_hari_ini' => Transaksi::whereDate('tanggal_transaksi', $today)->sum('total_amount'),
            'total_produk' => Produk::where('is_active', true)->count(),
            'total_pelanggan' => Pelanggan::count(),
        ];

        $transaksi_terbaru = Transaksi::with(['user', 'pelanggan'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $produk_terlaris = Produk::withCount(['detailTransaksis as total_terjual' => function($query) use ($today) {
                $query->join('transaksis', 'detail_transaksis.transaksi_id', '=', 'transaksis.id')
                      ->whereDate('transaksis.tanggal_transaksi', $today);
            }])
            ->orderBy('total_terjual', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'transaksi_terbaru', 'produk_terlaris'));
    }
}