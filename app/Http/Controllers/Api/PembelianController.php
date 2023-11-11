<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\DetailPembelian;
use App\Models\Laporan;
use App\Models\Pembelian;
use Carbon\Carbon;
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
            $pembelian = Pembelian::with('suplier','detail_pembelian')->get();
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
        $waktu_sekarang = Carbon::now()->format('H:i:s');
        $tgl_sekarang = Carbon::now()->format('Y-m-d');
        
        try {
            $validateDataPenjualan = $request->validate([

                "suplier_id" => 'required',
                "total_pembelian" => 'required',
                "jml_bayar_pembelian" => 'required',
                "jml_kembalian_pembelian" => 'required',
            ], [
                'required' =>  ':attribute tidak boleh kosong!',
            ]);

            $validateDataPenjualan["tanggal_pembelian"] = $tgl_sekarang;            
            $pembelian = Pembelian::create($validateDataPenjualan);
            
            try {
                foreach ($request->item as $key => $value) {
                    $dataDetailPembelian = [
                        "barang_id" => $value["barang_id"],
                        "pembelian_id" => $pembelian->id_pembelian,
                        "qty" => $value["qty"],
                    ];
                    $detailPembelian = DetailPembelian::create($dataDetailPembelian);
                }                
            } catch (QueryException $e) {
                return new ApiResource(false, $e->getMessage(), []);
            }

            try {
                $dataLaporan = [
                    "kode_laporan" => Laporan::latest()->first() ?  "LB-IN-" . preg_replace('/[^0-9]/','',Laporan::latest()->first()->kode_laporan) + 1  : 'LB-IN-1',
                    "tgl_laporan" => $tgl_sekarang,
                    "waktu" => $waktu_sekarang,
                    "credit" => $request->jml_bayar_pembelian,
                    "debit" => 0,
                    "saldo" => Laporan::latest()->first() ? Laporan::latest()->first()->saldo + $request->jml_bayar_pembelian : $request->jml_bayar_pembelian,
                ];
                $laporan = Laporan::create($dataLaporan);
            } catch (QueryException $e) {
                return new ApiResource(false, $e->getMessage(), []);
            }

            $respons = [
                'jml_kembalian_pembelian' => $request->jml_kembalian_pembelian, 
                'pembelian' => $pembelian, 
                'detail_pembelian' => $detailPembelian,
                'laporan' => $laporan,
            ];

            return new ApiResource(true, 'Data Berhasil Disimpan', $respons);
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
        // 
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
