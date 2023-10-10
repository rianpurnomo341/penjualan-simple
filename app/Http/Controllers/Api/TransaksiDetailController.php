<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\TransaksiDetail;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class TransaksiDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $transaksiDetail = TransaksiDetail::all();
            return new ApiResource(true, 'Berhasil Menampilkan Data', $transaksiDetail);
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
                'transaksiDetail' => 'required',
                'keterangan' => 'required',
            ], [
                'required' =>  ':attribute tidak boleh kosong!',
            ]);
    
            $transaksiDetail = TransaksiDetail::create($validateData);
            return new ApiResource(true, 'Data Berhasil Disimpan', $transaksiDetail);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TransaksiDetail $transaksiDetail)
    {
        try {
            $transaksiDetail = transaksiDetail::where('id_transaksiDetail', $transaksiDetail->id_transaksiDetail)->with('id_user_karyawan', 'id_instansi')->get();
            return new ApiResource(true, 'Berhasil Menampilkan Detail Data', $transaksiDetail);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransaksiDetail $transaksiDetail)
    {
        try {
            $validateData = $request->validate([
                'transaksiDetail' => 'required',
                'keterangan' => 'required',
            ], [
                'required' =>  ':attribute tidak boleh kosong!',
            ]);

            $transaksiDetail = $transaksiDetail->update($validateData);
            return new ApiResource(true, 'Data Berhasil Disimpan', $transaksiDetail);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransaksiDetail $transaksiDetail)
    {
        try {
            $transaksiDetail = $transaksiDetail->delete();
            return new ApiResource(true, 'Data Berhasil Dihapus', $transaksiDetail);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }
}
