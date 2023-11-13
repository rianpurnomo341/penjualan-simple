<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\DetailPenjualan;
use App\Models\Laporan;
use App\Models\Penjualan;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    public function index()
    {
        try {
            $penjualan = Penjualan::with('detail_penjualan')->get();
            return new ApiResource(true, 'Berhasil Menampilkan Data', $penjualan);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function store(Request $request)
    {
        $waktu_sekarang = Carbon::now()->format('H:i:s');
        $tgl_sekarang = Carbon::now()->format('Y-m-d');

        try {
            $validateDataPenjualan = $request->validate([
                'total_penjualan' => 'required',
                'jml_bayar_penjualan' => 'required',
                'jml_kembalian_penjualan' => 'required',
            ], [
                'required' =>  ':attribute tidak boleh kosong!',
            ]);

            $validateDataPenjualan['tanggal_penjualan'] = $tgl_sekarang;       
            $penjualan = Penjualan::create($validateDataPenjualan);
                   
            $detailPenjualan = $this->storeDetailpenjualan($request, $penjualan->id_penjualan);
            $laporan = $this->storeLaporan($request, $penjualan->id_penjualan, $waktu_sekarang, $tgl_sekarang);            

            $respons = [
                'jml_kembalian_penjualan' => $request->jml_kembalian_penjualan, 
                'penjualan' => $penjualan == true ? true : false, 
                'detail_penjualan' => $detailPenjualan,
                'laporan' => $laporan,
            ];

            return new ApiResource(true, 'Data Berhasil Disimpan', $respons);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function show(Penjualan $penjualan)
    {
        try {
            $penjualan = Penjualan::where('id_penjualan', $penjualan->id_penjualan)->with('detail_penjualan')->get();
            return new ApiResource(true, 'Berhasil Menampilkan Data', $penjualan);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function storeDetailpenjualan(Request $request, $id_penjualan)
    {
        try {
            foreach ($request->item as $key => $value) {
                $dataDetailPenjualan = [
                    'barang_id' => $value['barang_id'],
                    'penjualan_id' => $id_penjualan,
                    'qty' => $value['qty'],
                ];
                DetailPenjualan::create($dataDetailPenjualan);
            }
            return true;        
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function storeLaporan(Request $request, $id_penjualan, $waktu_sekarang, $tgl_sekarang)
    {
        try {
            $dataLaporan = [
                'pembelian_id' => null,
                'penjualan_id' => $id_penjualan,
                'kode_laporan' => Laporan::latest()->first() ?  'LB-OUT-' . preg_replace('/[^0-9]/','',Laporan::latest()->first()->kode_laporan) + 1  : 'LB-OUT-1',
                'nama_operasi' => 'Penjualan',
                'tgl_laporan' => $tgl_sekarang,
                'waktu' => $waktu_sekarang,
                'credit' => 0,
                'debit' => $request->jml_bayar_penjualan,
                'saldo' => Laporan::latest()->first() ? Laporan::latest()->first()->saldo - $request->jml_bayar_penjualan : 0 - $request->jml_bayar_penjualan,
            ];
            $laporan = Laporan::create($dataLaporan);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }

        return $laporan == true ? true : false;
    }
}
