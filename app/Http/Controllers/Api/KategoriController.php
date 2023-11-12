<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Kategori;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        try {
            $kategori = Kategori::withcount('barang')->with('barang.detail_pembelian')->get();
            return new ApiResource(true, 'Berhasil Menampilkan Data', $kategori);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function store(Request $request)
    {
        try {
            $validateData = $request->validate([
                'nama_kategori' => 'required',
                'ket_kategori' => 'required',
            ], [
                'required' =>  ':attribute tidak boleh kosong!',
            ]);
    
            $kategori = kategori::create($validateData);
            return new ApiResource(true, 'Data Berhasil Disimpan', $kategori);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function update(Request $request, Kategori $kategori)
    {
        try {
            $validateData = $request->validate([
                'nama_kategori' => 'required',
                'ket_kategori' => 'required',
            ], [
                'required' =>  ':attribute tidak boleh kosong!',
            ]);

            $kategori = $kategori->update($validateData);
            return new ApiResource(true, 'Data Berhasil Disimpan', $validateData);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function destroy(Kategori $kategori)
    {
        try {
            $kategori = $kategori->delete();
            return new ApiResource(true, 'Data Berhasil Dihapus', $kategori);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }
}
