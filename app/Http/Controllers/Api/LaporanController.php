<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Laporan;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        try {
            if($request->bulan) {
                $Laporan = Laporan::with('pembelian','penjualan')
                            ->whereMonth('created_at' ,$request->bulan)
                            ->get();
            }
            else if($request->tahun) {
                $Laporan = Laporan::with('pembelian','penjualan')
                            ->whereYear('created_at' ,$request->tahun)
                            ->get();
            }
            else if($request->tahun && $request->bulan) {
                $Laporan = Laporan::with('pembelian','penjualan')
                            ->whereYear('created_at' ,$request->tahun)
                            ->whereMonth('created_at' ,$request->bulan)
                            ->get();
            } else {
                $Laporan = Laporan::with('pembelian','penjualan')->get();
            }

            return new ApiResource(true, 'Berhasil Menampilkan Data', $Laporan);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    
}
