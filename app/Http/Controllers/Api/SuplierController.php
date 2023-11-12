<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Suplier;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class SuplierController extends Controller
{
    public function index()
    {
        try {
            $suplier = Suplier::with('id_barang')->get();
            return new ApiResource(true, 'Berhasil Menampilkan Data', $suplier);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function store(Request $request)
    {
        try {
            $validateData = $request->validate([
                'kode_suplier' => 'required',
                'nama_suplier' => 'required',
                'alamat' => 'required',
                'no_tlp' => 'required',
                'keterangan' => 'required',
            ], [
                'required' =>  ':attribute tidak boleh kosong!',
            ]);
    
            $suplier = Suplier::create($validateData);
            return new ApiResource(true, 'Data Berhasil Disimpan', $suplier);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function update(Request $request, Suplier $suplier)
    {
        try {
            $validateData = $request->validate([
                'kode_suplier' => 'required',
                'nama_suplier' => 'required',
                'alamat' => 'required',
                'no_tlp' => 'required',
                'keterangan' => 'required',
            ], [
                'required' =>  ':attribute tidak boleh kosong!',
            ]);

            $suplier = $suplier->update($validateData);
            return new ApiResource(true, 'Data Berhasil Disimpan', $validateData);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function destroy(Suplier $suplier)
    {
        try {
            $suplier = $suplier->delete();
            return new ApiResource(true, 'Data Berhasil Dihapus', $suplier);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }
}
