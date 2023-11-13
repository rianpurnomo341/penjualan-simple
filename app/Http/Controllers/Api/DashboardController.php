<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\DetailPenjualan;
use App\Models\Laporan;
use Carbon\Carbon;
use Illuminate\Database\QueryException;

class DashboardController extends Controller
{
    public function index()
    {
        
        try {
            // $pembelian = Laporan::sum('debit')-Laporan::sum('credit');
            // $penjualan = Laporan::sum('debit')-Laporan::sum('credit');
            $totalPengeluaranBulanIni = Laporan::where('nama_operasi', 'Pembelian')->whereMonth('tgl_laporan', Carbon::now()->month)->get()->sum('debit');
            $totalPendapatanBulanIni = Laporan::whereMonth('tgl_laporan', Carbon::now()->month)->get()->sum('credit');
            $profit = Laporan::sum('debit')-Laporan::sum('credit');
            $barangTerlaris = DetailPenjualan::orderBy('qty', 'DESC')->get();
            // $penjualanLastMont = DetailPenjualan::whereMonth('tgl_laporan', Carbon::now()->month)->get();

            $response = [
                'totalPengeluaranBulanIni' => $totalPengeluaranBulanIni,
                'totalPendapatanBulanIni' => $totalPendapatanBulanIni,
                'profit' => $profit,
                'barangTerlaris' => $barangTerlaris,
                // 'penjualanLastMont' => $penjualanLastMont,
            ];
            
            return new ApiResource(true, 'Berhasil Menampilkan Data', $response);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

}
