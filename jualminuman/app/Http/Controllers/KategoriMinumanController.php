<?php

namespace App\Http\Controllers;

use App\Models\KategoriMinuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class KategoriMinumanController extends Controller
{
    public function index()
    {
        $kategoriMinuman = KategoriMinuman::all();
        return response()->json($kategoriMinuman);
    }

    public function store(Request $request)
    {        
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|unique:KategoriMinuman|max:50', 
            'deskripsi' => 'nullable',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique' => 'Nama kategori sudah ada.',
            'nama_kategori.max' => 'Nama kategori maksimal 50 karakter.',
        ]);

          if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }


        $kategoriMinuman = KategoriMinuman::create($request->all());

        return response()->json([
            'message' => 'Kategori minuman berhasil ditambahkan',
            'data' => $kategoriMinuman
        ], 201);  //menggunakan kode 201
    }

    public function show($id)
    {
        $kategoriMinuman = KategoriMinuman::find($id);

        if (!$kategoriMinuman) {
            return response()->json(['message' => 'Kategori minuman tidak ditemukan'], 404);
        }
        return response()->json($kategoriMinuman);
    }

    public function update(Request $request, $id)
    {
        $kategoriMinuman = KategoriMinuman::find($id);
         if (!$kategoriMinuman) {
            return response()->json(['message' => 'Kategori minuman tidak ditemukan'], 404);
        }

          $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|max:50|unique:KategoriMinuman,nama_kategori,' . $id, // Validasi unique dengan mengabaikan ID saat ini
            'deskripsi' => 'nullable',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique' => 'Nama kategori sudah ada.',
            'nama_kategori.max' => 'Nama kategori maksimal 50 karakter.',
        ]);


          if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $kategoriMinuman->update($request->all());
        return response()->json([
            'message' => 'Kategori minuman berhasil diperbarui',
            'data' => $kategoriMinuman
        ]);
    }


     public function destroy($id)
    {
        $kategoriMinuman = KategoriMinuman::find($id);
        if (!$kategoriMinuman) {
            return response()->json(['message' => 'Kategori minuman tidak ditemukan'], 404);
        }

        $kategoriMinuman->delete();
         return response()->json(['message' => 'Kategori minuman berhasil dihapus'], 200);
    }
}