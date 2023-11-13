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
    public function index()
    {
        try {
            $pembelian = Pembelian::with('suplier','detail_pembelian')->get();
            return new ApiResource(true, 'Berhasil Menampilkan Data', $pembelian);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function store(Request $request)
    {
        $waktu_sekarang = Carbon::now()->format('H:i:s');
        $tgl_sekarang = Carbon::now()->format('Y-m-d');

        try {
            $validateDataPembelian = $request->validate([
                "suplier_id" => 'required',
                "total_pembelian" => 'required',
                "jml_bayar_pembelian" => 'required',
                "jml_kembalian_pembelian" => 'required',
            ], [
                'required' =>  ':attribute tidak boleh kosong!',
            ]);

            $validateDataPembelian["tanggal_pembelian"] = $tgl_sekarang;            
            $pembelian = Pembelian::create($validateDataPembelian);
                    
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

    public function destroy(Pembelian $pembelian)
    {
        try {
            $pembelian = $pembelian->delete();
            return new ApiResource(true, 'Data Berhasil Dihapus', $pembelian);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function storeDetailPembelian(Request $request, $id_pembelian)
    {
        try {
            foreach ($request->item as $key => $value) {
                $dataDetailPembelian = [
                    "barang_id" => $value["barang_id"],
                    "pembelian_id" => $id_pembelian,
                    "qty" => $value["qty"],
                ];
                DetailPembelian::create($dataDetailPembelian);
            }
            return true;        
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function storeLaporan(Request $request, $waktu_sekarang, $tgl_sekarang)
    {
        try {
            $dataLaporan = [
                "kode_laporan" => Laporan::latest()->first() ?  "LB-IN-" . preg_replace('/[^0-9]/','',Laporan::latest()->first()->kode_laporan) + 1  : 'LB-IN-1',
                "nama_operasi" => 'Pembelian',
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

        return $laporan == true ? true : false;
    }
}
