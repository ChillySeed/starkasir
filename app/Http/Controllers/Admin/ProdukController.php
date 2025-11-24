<?php
// app/Http/Controllers/Admin/ProdukController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_produk', 'like', "%{$search}%")
                  ->orWhere('kode_produk', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            if ($request->status == 'active') {
                $query->where('is_active', true);
            } elseif ($request->status == 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Filter by stock status
        if ($request->has('stock_status') && $request->stock_status) {
            switch ($request->stock_status) {
                case 'in_stock':
                    $query->where('stok_sekarang', '>', 0);
                    break;
                case 'low_stock':
                    $query->where('stok_sekarang', '>', 0)
                          ->where('stok_sekarang', '<', 10);
                    break;
                case 'out_of_stock':
                    $query->where('stok_sekarang', '<=', 0);
                    break;
                case 'high_stock':
                    $query->where('stok_sekarang', '>=', 50);
                    break;
            }
        }

        // Filter by unit
        if ($request->has('satuan') && $request->satuan) {
            $query->where('satuan', $request->satuan);
        }

        // Sort options
        $sortOptions = [
            'nama_asc' => ['nama_produk', 'asc'],
            'nama_desc' => ['nama_produk', 'desc'],
            'harga_asc' => ['harga_dasar', 'asc'],
            'harga_desc' => ['harga_dasar', 'desc'],
            'stok_asc' => ['stok_sekarang', 'asc'],
            'stok_desc' => ['stok_sekarang', 'desc'],
            'terbaru' => ['created_at', 'desc'],
            'terlama' => ['created_at', 'asc'],
        ];

        $sort = $request->get('sort', 'nama_asc');
        if (array_key_exists($sort, $sortOptions)) {
            $query->orderBy($sortOptions[$sort][0], $sortOptions[$sort][1]);
        } else {
            $query->orderBy('nama_produk', 'asc');
        }

        $produks = $query->paginate(20)->withQueryString();

        // Get data for alerts (across all products, not just current page)
        $allProduks = Produk::all();
        $lowStockProducts = $allProduks->where('stok_sekarang', '<', 10)->where('stok_sekarang', '>', 0);
        $outOfStockProducts = $allProduks->where('stok_sekarang', '<=', 0);
        $inactiveProducts = $allProduks->where('is_active', false);

        $availableUnits = Produk::distinct()->pluck('satuan')->filter();

        return view('admin.produk.index', compact(
            'produks', 
            'lowStockProducts',
            'outOfStockProducts',
            'inactiveProducts',
            'availableUnits'
        ));
    }


    public function create()
    {
        return view('admin.produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_produk' => 'required|unique:produks',
            'nama_produk' => 'required|string|max:255',
            'satuan' => 'required|in:pcs,botol,kemasan,kg,gram',
            'harga_dasar' => 'required|numeric|min:0',
            'stok_awal' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        $data = $request->except('gambar');
        $data['stok_sekarang'] = $request->stok_awal;
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $imageName = time() . '_' . Str::slug($request->nama_produk) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/produks', $imageName);
            $data['gambar'] = $imageName;
        }

        Produk::create($data);

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Produk $produk)
    {
        $produk->load(['levelHargaQuantities', 'levelHargaGolongans.golongan']);
        return view('admin.produk.show', compact('produk'));
    }

    public function edit(Produk $produk)
    {
        return view('admin.produk.edit', compact('produk'));
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'kode_produk' => 'required|unique:produks,kode_produk,' . $produk->id,
            'nama_produk' => 'required|string|max:255',
            'satuan' => 'required|in:pcs,botol,kemasan,kg,gram',
            'harga_dasar' => 'required|numeric|min:0',
            'stok_awal' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        $data = $request->except('gambar');
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('gambar')) {
            // Delete old image
            if ($produk->gambar) {
                Storage::delete('public/produks/' . $produk->gambar);
            }
            
            $image = $request->file('gambar');
            $imageName = time() . '_' . Str::slug($request->nama_produk) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/produks', $imageName);
            $data['gambar'] = $imageName;
        }

        $produk->update($data);

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        if ($produk->gambar) {
            Storage::delete('public/produks/' . $produk->gambar);
        }
        
        $produk->delete();

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    public function updateStok(Request $request, Produk $produk)
    {
        $request->validate([
            'stok_sekarang' => 'required|integer|min:0',
        ]);

        $produk->update([
            'stok_sekarang' => $request->stok_sekarang,
        ]);

        return redirect()->back()->with('success', 'Stok produk berhasil diperbarui.');
    }
}