<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Barang;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $barang = Barang::with('kategori', 'satuan')->get();
            return new ApiResource(true, 'Berhasil Menampilkan Data', $barang);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validateData = $request->validate([
                "display" => 'required',
                "kode_barang" => 'required',
                "nama_barang" => 'required',
                "kategori_id" => 'required',
                "satuan_id" => 'required',
                "diskon" => 'required',
                "harga_before_diskon" => 'required',
                "harga_after_diskon" => 'required',
                "tgl_kadaluarsa" => 'required',
                "deskripsi" => 'required',
            ], [
                'required' =>  ':attribute tidak boleh kosong!',
            ]);
    
            $barang = Barang::create($validateData);
            return new ApiResource(true, 'Data Berhasil Disimpan', $barang);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        try {
            $barang = Barang::where('id_barang', $barang->id_barang)->with('kategori', 'satuan')->get();
            return new ApiResource(true, 'Berhasil Menampilkan Detail Data', $barang);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        try {
            $validateData = $request->validate([
                "display" => 'required',
                "kode_barang" => 'required',
                "nama_barang" => 'required',
                "kategori_id" => 'required',
                "satuan_id" => 'required',
                "diskon" => 'required',
                "harga_before_diskon" => 'required',
                "harga_after_diskon" => 'required',
                "tgl_kadaluarsa" => 'required',
                "deskripsi" => 'required',
            ], [
                'required' =>  ':attribute tidak boleh kosong!',
            ]);

            $barang = $barang->update($validateData);
            return new ApiResource(true, 'Data Berhasil Disimpan', $validateData);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        try {
            $barang = $barang->delete();
            return new ApiResource(true, 'Data Berhasil Dihapus', $barang);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }
}
