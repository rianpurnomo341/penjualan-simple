<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Pembelian;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $pembelian = Pembelian::all();
            return new ApiResource(true, 'Berhasil Menampilkan Data', $pembelian);
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
                'tanggal_pembelian' => 'required',
                'total_harga_beli' => 'required',
                'total_harga_jual' => 'required',
            ], [
                'required' =>  ':attribute tidak boleh kosong!',
            ]);
    
            $pembelian = Pembelian::create($validateData);
            return new ApiResource(true, 'Data Berhasil Disimpan', $pembelian);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pembelian $pembelian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pembelian $pembelian)
    {
        try {
            $validateData = $request->validate([
                'tanggal_pembelian' => 'required',
                'total_harga_beli' => 'required',
                'total_harga_jual' => 'required',
            ], [
                'required' =>  ':attribute tidak boleh kosong!',
            ]);

            $pembelian = $pembelian->update($validateData);
            return new ApiResource(true, 'Data Berhasil Disimpan', $pembelian);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembelian $pembelian)
    {
        try {
            $pembelian = $pembelian->delete();
            return new ApiResource(true, 'Data Berhasil Dihapus', $pembelian);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }
}
