<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Barang;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        try {
            $barang = Barang::with('kategori', 'satuan')->get();
            return new ApiResource(true, 'Berhasil Menampilkan Data', $barang);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function store(Request $request)
    {
        return Barang::latest()->first() ?  'KD-BR-' . preg_replace('/[^0-9]/','',Barang::latest()->first()->kode_barang) + 1  : 'KD-BR-1';
        try {
            $validateData = $request->validate([
                'display' => 'required',
                'kode_barang' => 'required|unique:barang',
                'nama_barang' => 'required',
                'kategori_id' => 'required',
                'satuan_id' => 'required',
                'diskon' => 'required',
                'harga_before_diskon' => 'required',
                'harga_after_diskon' => 'required',
                'tgl_kadaluarsa' => 'required',
                'deskripsi' => 'required',
            ], [
                'required' =>  ':attribute tidak boleh kosong!',
            ]);

            $validateData['kode_barang'] = Barang::latest()->first() ?  'KD-BR-' . preg_replace('/[^0-9]/','',Barang::latest()->first()->kode_barang) + 1  : 'KD-BR-1';
            $barang = Barang::create($validateData);
            return new ApiResource(true, 'Data Berhasil Disimpan', $barang);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function show(Barang $barang)
    {
        try {
            $barang = Barang::where('id_barang', $barang->id_barang)->with('kategori', 'satuan')->get();
            return new ApiResource(true, 'Berhasil Menampilkan Detail Data', $barang);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function update(Request $request, Barang $barang)
    {
        try {
            $validateData = $request->validate([
                'display' => 'required',
                'kode_barang' => 'required',
                'nama_barang' => 'required',
                'kategori_id' => 'required',
                'satuan_id' => 'required',
                'diskon' => 'required',
                'harga_before_diskon' => 'required',
                'harga_after_diskon' => 'required',
                'tgl_kadaluarsa' => 'required',
                'deskripsi' => 'required',
            ], [
                'required' =>  ':attribute tidak boleh kosong!',
            ]);

            $barang = $barang->update($validateData);
            return new ApiResource(true, 'Data Berhasil Disimpan', $validateData);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

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
