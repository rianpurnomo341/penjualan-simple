<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Satuan;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $satuan = Satuan::withcount('barang')->with('barang')->get();
            return new ApiResource(true, 'Berhasil Menampilkan Data', $satuan);
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
                'nama_satuan' => 'required',
                'ket_satuan' => 'required',
            ], [
                'required' =>  ':attribute tidak boleh kosong!',
            ]);
    
            $satuan = Satuan::create($validateData);
            return new ApiResource(true, 'Data Berhasil Disimpan', $satuan);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Satuan $satuan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Satuan $satuan)
    {
        try {
            $validateData = $request->validate([
                'nama_satuan' => 'required',
                'ket_satuan' => 'required',
            ], [
                'required' =>  ':attribute tidak boleh kosong!',
            ]);

            $satuan = $satuan->update($validateData);
            return new ApiResource(true, 'Data Berhasil Disimpan', $validateData);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Satuan $satuan)
    {
        try {
            $satuan = $satuan->delete();
            return new ApiResource(true, 'Data Berhasil Dihapus', $satuan);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }
}
