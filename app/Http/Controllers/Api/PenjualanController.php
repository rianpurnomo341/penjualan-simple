<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Penjualan;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $waktu_sekarang = Carbon::now()->format('H:i:s');
        $tgl_sekarang = Carbon::now()->format('Y-m-d');

        try {
            $validateDataPenjualan = $request->validate([
                "total_pembelian" => 'required',
                "jml_bayar_pembelian" => 'required',
                "jml_kembalian_pembelian" => 'required',
            ], [
                'required' =>  ':attribute tidak boleh kosong!',
            ]);

            $validateDataPenjualan["tanggal_penjualan"] = $tgl_sekarang;            
            $pembelian = Penjualan::create($validateDataPenjualan);
                    
            $detailPenjualan = $this->storeDetailPembelian($request, $pembelian->id_pembelian);            
            $laporan = $this->storeLaporan($request, $waktu_sekarang, $tgl_sekarang);            

            $respons = [
                'jml_kembalian_pembelian' => $request->jml_kembalian_pembelian, 
                'pembelian' => $pembelian == true ? true : false, 
                'detail_pembelian' => $detailPenjualan,
                'laporan' => $laporan,
            ];

            return new ApiResource(true, 'Data Berhasil Disimpan', $respons);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function show(Penjualan $penjualan)
    {
        //
    }

    public function update(Request $request, Penjualan $penjualan)
    {
        //
    }

    public function destroy(Penjualan $penjualan)
    {
        //
    }
}
