<?php
// app/Http/Controllers/Admin/PelangganController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Golongan;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::with('golongan')->orderBy('nama')->get();
        return view('admin.pelanggan.index', compact('pelanggans'));
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