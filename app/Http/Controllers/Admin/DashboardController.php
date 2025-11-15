<?php
// app/Http/Controllers/Admin/DashboardController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Produk;
use App\Models\Pelanggan;
use App\Models\User;
use App\Models\StokBarang;
use App\Models\Laporan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $today = Carbon::today();
        $weekStart = Carbon::now()->startOfWeek();
        $monthStart = Carbon::now()->startOfMonth();
        
        // Basic Stats
        $stats = [
            'total_transaksi_hari_ini' => Transaksi::whereDate('tanggal_transaksi', $today)->count(),
            'total_pendapatan_hari_ini' => Transaksi::whereDate('tanggal_transaksi', $today)->sum('total_amount'),
            'total_pendapatan_bulan_ini' => Transaksi::whereDate('tanggal_transaksi', '>=', $monthStart)->sum('total_amount'),
            'total_produk' => Produk::where('is_active', true)->count(),
            'total_pelanggan' => Pelanggan::count(),
            'produk_habis' => Produk::where('stok_sekarang', '<=', 5)->where('is_active', true)->count(),
        ];

        // Revenue Chart Data (Last 7 days)
        $revenueData = Transaksi::whereDate('tanggal_transaksi', '>=', Carbon::now()->subDays(7))
            ->selectRaw('DATE(tanggal_transaksi) as date, SUM(total_amount) as revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function($item) {
                return [
                    'date' => Carbon::parse($item->date)->format('M d'),
                    'revenue' => (float) $item->revenue
                ];
            });

        // Top Selling Products (This Month)
        $produk_terlaris = Produk::withCount(['detailTransaksis as total_terjual' => function($query) use ($monthStart) {
                $query->join('transaksis', 'detail_transaksis.transaksi_id', '=', 'transaksis.id')
                      ->whereDate('transaksis.tanggal_transaksi', '>=', $monthStart);
            }])
            ->withSum(['detailTransaksis as total_pendapatan' => function($query) use ($monthStart) {
                $query->join('transaksis', 'detail_transaksis.transaksi_id', '=', 'transaksis.id')
                      ->whereDate('transaksis.tanggal_transaksi', '>=', $monthStart);
            }], 'subtotal')
            ->orderBy('total_terjual', 'desc')
            ->take(5)
            ->get();

        // Recent Stock Movements
        $stok_perubahan = StokBarang::with('produk')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Recent Transactions
        $transaksi_terbaru = Transaksi::with(['user', 'pelanggan'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Membership Distribution
        $membership_distribution = Pelanggan::join('golongans', 'pelanggans.golongan_id', '=', 'golongans.id')
            ->select('golongans.nama_tier', DB::raw('COUNT(pelanggans.id) as total'))
            ->groupBy('golongans.nama_tier')
            ->get();

        // Low Stock Products
        $produk_stok_rendah = Produk::where('stok_sekarang', '<=', 5)
            ->where('is_active', true)
            ->orderBy('stok_sekarang')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'revenueData',
            'produk_terlaris',
            'stok_perubahan',
            'transaksi_terbaru',
            'membership_distribution',
            'produk_stok_rendah'
        ));
    }

    public function getDashboardData(Request $request)
    {
        $period = $request->get('period', 'week');
        
        switch ($period) {
            case 'month':
                $startDate = Carbon::now()->subDays(30);
                break;
            case 'year':
                $startDate = Carbon::now()->subDays(365);
                break;
            default:
                $startDate = Carbon::now()->subDays(7);
        }

        $revenueData = Transaksi::whereDate('tanggal_transaksi', '>=', $startDate)
            ->selectRaw('DATE(tanggal_transaksi) as date, SUM(total_amount) as revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function($item) {
                return [
                    'date' => Carbon::parse($item->date)->format('M d'),
                    'revenue' => (float) $item->revenue
                ];
            });

        return response()->json($revenueData);
    }
}