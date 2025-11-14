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
    public function index()
    {
        $produks = Produk::orderBy('nama_produk')->get();
        return view('admin.produk.index', compact('produks'));
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