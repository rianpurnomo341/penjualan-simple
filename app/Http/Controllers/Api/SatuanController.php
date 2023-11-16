<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Satuan;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SatuanController extends Controller
{
    public function index()
    {
        try {
            $satuan = Satuan::select('satuan.*', DB::raw('SUM(barang.qty) as total_stock'))
            ->leftJoin('barang', 'satuan.id_satuan', '=', 'barang.satuan_id')
            ->groupBy('satuan.id_satuan','satuan.nama_satuan','satuan.ket_satuan','satuan.created_at','satuan.updated_at')
            ->withcount('barang as count_barang')
            ->get();
            return new ApiResource(true, 'Berhasil Menampilkan Data', $satuan);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

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

    public function show(Satuan $satuan)
    {
        //
    }

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
