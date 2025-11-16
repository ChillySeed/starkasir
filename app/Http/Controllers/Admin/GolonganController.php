<?php
// app/Http/Controllers/Admin/GolonganController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Golongan;

class GolonganController extends Controller
{
    public function index()
    {
        $golongans = Golongan::withCount('pelanggans')->orderBy('diskon_persen', 'desc')->get();
        return view('admin.golongan.index', compact('golongans'));
    }

    public function create()
    {
        return view('admin.golongan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tier' => 'required|string|max:255|unique:golongans',
            'diskon_persen' => 'required|numeric|min:0|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        Golongan::create($request->all());

        return redirect()->route('admin.golongan.index')
            ->with('success', 'Golongan berhasil ditambahkan.');
    }

    public function edit(Golongan $golongan)
    {
        return view('admin.golongan.edit', compact('golongan'));
    }

    public function update(Request $request, Golongan $golongan)
    {
        $request->validate([
            'nama_tier' => 'required|string|max:255|unique:golongans,nama_tier,' . $golongan->id,
            'diskon_persen' => 'required|numeric|min:0|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        $golongan->update($request->all());

        return redirect()->route('admin.golongan.index')
            ->with('success', 'Golongan berhasil diperbarui.');
    }

    public function destroy(Golongan $golongan)
    {
        // Check if golongan has pelanggans
        if ($golongan->pelanggans()->count() > 0) {
            return redirect()->route('admin.golongan.index')
                ->with('error', 'Tidak dapat menghapus golongan yang masih memiliki member.');
        }

        $golongan->delete();

        return redirect()->route('admin.golongan.index')
            ->with('success', 'Golongan berhasil dihapus.');
    }
}