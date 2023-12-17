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
            $suplier = Suplier::all();
            return new ApiResource(true, 'Berhasil Menampilkan Data', $suplier);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function store(Request $request)
    {
        try {
            $validateData = $request->validate([
                'nama_suplier' => 'required',
                'alamat' => 'required',
                'no_tlp' => 'required',
                'ket_suplier' => 'required',
            ], [
                'required' =>  ':attribute tidak boleh kosong!',
            ]);
    
            $validateData['kode_suplier'] = Suplier::latest()->first() ?  'KD-SP-' . preg_replace('/[^0-9]/','',Suplier::latest()->first()->kode_suplier) + 1  : 'KD-SP-1';
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
                'nama_suplier' => 'required',
                'alamat' => 'required',
                'no_tlp' => 'required',
                'ket_suplier' => 'required',
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
