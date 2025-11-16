<?php
// app/Http/Controllers/Admin/PelangganController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Golongan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        // Build query with filters
        $query = Pelanggan::with('golongan');
        
        // Apply filters
        if ($request->has('golongan_id') && $request->golongan_id) {
            $query->where('golongan_id', $request->golongan_id);
        }
        
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('kode_pelanggan', 'like', "%{$search}%")
                  ->orWhere('no_telp', 'like', "%{$search}%");
            });
        }

        $pelanggans = $query->orderBy('total_belanja', 'desc')->paginate(20);
        $golongans = Golongan::all();
        
        // Stats
        $stats = [
            'total_pelanggan' => Pelanggan::count(),
            'gold_members' => Pelanggan::whereHas('golongan', function($q) {
                $q->where('nama_tier', 'Gold');
            })->count(),
            'transaksi_bulan_ini' => Pelanggan::where('created_at', '>=', Carbon::now()->startOfMonth())->count(),
            'total_belanja' => Pelanggan::sum('total_belanja'),
        ];

        // Top customers
        $top_pelanggan = Pelanggan::with('golongan')
            ->orderBy('total_belanja', 'desc')
            ->take(5)
            ->get();

        // Membership distribution - FIXED QUERY
        $membership_distribution = Golongan::select(
                'golongans.id',
                'golongans.nama_tier',
                'golongans.diskon_persen',
                DB::raw('COUNT(pelanggans.id) as total')
            )
            ->leftJoin('pelanggans', 'golongans.id', '=', 'pelanggans.golongan_id')
            ->groupBy('golongans.id', 'golongans.nama_tier', 'golongans.diskon_persen')
            ->orderBy('golongans.diskon_persen', 'desc')
            ->get();

        return view('admin.pelanggan.index', compact(
            'pelanggans', 
            'golongans', 
            'stats', 
            'top_pelanggan',
            'membership_distribution'
        ));
    }

    public function create()
    {
        $golongans = Golongan::all();
        return view('admin.pelanggan.create', compact('golongans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_pelanggan' => 'required|unique:pelanggans',
            'nama' => 'required|string|max:255',
            'golongan_id' => 'required|exists:golongans,id',
            'no_telp' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'alamat' => 'nullable|string',
        ]);

        Pelanggan::create($request->all());

        return redirect()->route('admin.pelanggan.index')
            ->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function edit(Pelanggan $pelanggan)
    {
        $golongans = Golongan::all();
        return view('admin.pelanggan.edit', compact('pelanggan', 'golongans'));
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $request->validate([
            'kode_pelanggan' => 'required|unique:pelanggans,kode_pelanggan,' . $pelanggan->id,
            'nama' => 'required|string|max:255',
            'golongan_id' => 'required|exists:golongans,id',
            'no_telp' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'alamat' => 'nullable|string',
        ]);

        $pelanggan->update($request->all());

        return redirect()->route('admin.pelanggan.index')
            ->with('success', 'Pelanggan berhasil diperbarui.');
    }

    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();

        return redirect()->route('admin.pelanggan.index')
            ->with('success', 'Pelanggan berhasil dihapus.');
    }
}