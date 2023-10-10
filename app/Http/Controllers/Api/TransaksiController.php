<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Transaksi;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $transaksi = Transaksi::all();
            return new ApiResource(true, 'Berhasil Menampilkan Data', $transaksi);
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
                'tgl_transaksi' => 'required',
                'total_harga_jual' => 'required',
                'total_harga_beli' => 'required',
                'provit' => 'required',
            ], [
                'required' =>  ':attribute tidak boleh kosong!',
            ]);
    
            $transaksi = Transaksi::create($validateData);
            return new ApiResource(true, 'Data Berhasil Disimpan', $transaksi);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaksi $transaksi)
    {
        try {
            $transaksi = Transaksi::where('id_transaksi', $transaksi->id_transaksi)->with('id_user_karyawan', 'id_instansi')->get();
            return new ApiResource(true, 'Berhasil Menampilkan Detail Data', $transaksi);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        try {
            $validateData = $request->validate([
                'tgl_transaksi' => 'required',
                'total_harga_jual' => 'required',
                'total_harga_beli' => 'required',
                'provit' => 'required',
            ], [
                'required' =>  ':attribute tidak boleh kosong!',
            ]);

            $transaksi = $transaksi->update($validateData);
            return new ApiResource(true, 'Data Berhasil Disimpan', $transaksi);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        try {
            $transaksi = $transaksi->delete();
            return new ApiResource(true, 'Data Berhasil Dihapus', $transaksi);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }
}
