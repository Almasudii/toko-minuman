<?php

namespace App\Http\Controllers;

use App\Models\Minuman;
use App\Models\KategoriMinuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MinumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $minuman = Minuman::with('kategori')->latest()->get();
        return response()->json($minuman);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'        => 'required|string|max:255',
            'stok'        => 'required|integer|min:0|max:1000',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'kategori_id' => 'required|exists:kategoriminuman,id',
        ]);

        // Jika stok melebihi 1000, kembalikan error manual
        if ($request->stok > 1000) {
            return response()->json([
                'message' => 'Stok tidak boleh lebih dari 1000'
            ], 400);
        }

        // Upload gambar jika ada
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('gambar_minuman', 'public');
        }

        $minuman = Minuman::create([
            'nama'        => $request->nama,
            'stok'        => $request->stok,
            'gambar'      => $gambarPath,
            'kategori_id' => $request->kategori_id,
        ]);

        return response()->json([
            'message' => 'Minuman berhasil ditambahkan',
            'data'    => $minuman,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $minuman = Minuman::with('kategori')->findOrFail($id);
        return response()->json($minuman);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $minuman = Minuman::findOrFail($id);

        $request->validate([
            'nama'        => 'sometimes|required|string|max:255',
            'stok'        => 'sometimes|required|integer|min:0|max:1000',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'kategori_id' => 'sometimes|required|exists:kategoriminuman,id',
        ]);

        // Jika stok melebihi 1000, kembalikan error manual
        if ($request->has('stok') && $request->stok > 1000) {
            return response()->json([
                'message' => 'Stok tidak boleh lebih dari 1000'
            ], 400);
        }

        // Jika ada gambar baru, hapus gambar lama dan upload baru
        if ($request->hasFile('gambar')) {
            if ($minuman->gambar) {
                Storage::disk('public')->delete($minuman->gambar);
            }
            $gambarPath = $request->file('gambar')->store('gambar_minuman', 'public');
            $minuman->gambar = $gambarPath;
        }

        if ($request->has('nama')) $minuman->nama = $request->nama;
        if ($request->has('stok')) $minuman->stok = $request->stok;
        if ($request->has('kategori_id')) $minuman->kategori_id = $request->kategori_id;

        $minuman->save();

        return response()->json([
            'message' => 'Minuman berhasil diperbarui',
            'data'    => $minuman,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $minuman = Minuman::findOrFail($id);

        // Hapus gambar jika ada
        if ($minuman->gambar) {
            Storage::disk('public')->delete($minuman->gambar);
        }

        $minuman->delete();

        return response()->json(['message' => 'Minuman berhasil dihapus']);
    }
}
