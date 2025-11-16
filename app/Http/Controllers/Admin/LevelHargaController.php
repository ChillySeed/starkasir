<?php
// app/Http/Controllers/Admin/LevelHargaController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Golongan;
use App\Models\LevelHargaQuantity;
use App\Models\LevelHargaGolongan;

class LevelHargaController extends Controller
{
    public function index()
    {
        $produks = Produk::where('is_active', true)
            ->with(['levelHargaQuantities', 'levelHargaGolongans.golongan'])
            ->orderBy('nama_produk')
            ->get();
            
        $golongans = Golongan::all();

        return view('admin.level-harga.index', compact('produks', 'golongans'));
    }

    public function show($id)
    {
        $produk = Produk::with(['levelHargaQuantities', 'levelHargaGolongans.golongan'])->findOrFail($id);
        $golongans = Golongan::all();

        return view('admin.level-harga.detail', compact('produk', 'golongans'));
    }

    // Quantity Price Methods
    public function storeQuantity(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'qty_min' => 'required|integer|min:1',
            'qty_max' => 'nullable|integer|min:1|gt:qty_min',
            'harga_khusus' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        // Check for overlapping ranges
        $existing = LevelHargaQuantity::where('produk_id', $request->produk_id)
            ->where('is_active', true)
            ->where(function($query) use ($request) {
                $query->whereBetween('qty_min', [$request->qty_min, $request->qty_max ?? PHP_INT_MAX])
                      ->orWhereBetween('qty_max', [$request->qty_min, $request->qty_max ?? PHP_INT_MAX])
                      ->orWhere(function($q) use ($request) {
                          $q->where('qty_min', '<=', $request->qty_min)
                            ->where(function($q2) use ($request) {
                                $q2->where('qty_max', '>=', $request->qty_max ?? PHP_INT_MAX)
                                   ->orWhereNull('qty_max');
                            });
                      });
            })
            ->exists();

        if ($existing) {
            return redirect()->back()->with('error', 'Range quantity bertabrakan dengan level harga yang sudah ada.');
        }

        LevelHargaQuantity::create($request->all());

        return redirect()->back()->with('success', 'Level harga quantity berhasil ditambahkan.');
    }

    public function updateQuantity(Request $request, LevelHargaQuantity $levelHargaQuantity)
    {
        $request->validate([
            'qty_min' => 'required|integer|min:1',
            'qty_max' => 'nullable|integer|min:1|gt:qty_min',
            'harga_khusus' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $levelHargaQuantity->update($request->all());

        return redirect()->back()->with('success', 'Level harga quantity berhasil diperbarui.');
    }

    public function destroyQuantity(LevelHargaQuantity $levelHargaQuantity)
    {
        $levelHargaQuantity->delete();

        return redirect()->back()->with('success', 'Level harga quantity berhasil dihapus.');
    }

    // Golongan Price Methods
    public function storeGolongan(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'golongan_id' => 'required|exists:golongans,id',
            'harga_khusus' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        // Check if already exists
        $existing = LevelHargaGolongan::where('produk_id', $request->produk_id)
            ->where('golongan_id', $request->golongan_id)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Level harga untuk golongan ini sudah ada.');
        }

        LevelHargaGolongan::create($request->all());

        return redirect()->back()->with('success', 'Level harga golongan berhasil ditambahkan.');
    }

    public function updateGolongan(Request $request, LevelHargaGolongan $levelHargaGolongan)
    {
        $request->validate([
            'harga_khusus' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $levelHargaGolongan->update($request->all());

        return redirect()->back()->with('success', 'Level harga golongan berhasil diperbarui.');
    }

    public function destroyGolongan(LevelHargaGolongan $levelHargaGolongan)
    {
        $levelHargaGolongan->delete();

        return redirect()->back()->with('success', 'Level harga golongan berhasil dihapus.');
    }
    // Show edit form for quantity level
    public function editQuantity(LevelHargaQuantity $levelHargaQuantity)
    {
        return response()->json($levelHargaQuantity);
    }

    // Show edit form for golongan level  
    public function editGolongan(LevelHargaGolongan $levelHargaGolongan)
    {
        $levelHargaGolongan->load('golongan');
        return response()->json($levelHargaGolongan);
    }
}