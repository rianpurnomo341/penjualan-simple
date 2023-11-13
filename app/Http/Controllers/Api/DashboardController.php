<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\DetailPembelian;
use App\Models\DetailPenjualan;
use App\Models\Laporan;
use Carbon\Carbon;
use Illuminate\Database\QueryException;

class DashboardController extends Controller
{
    public function index()
    {
        
        try {
            $pembelian = DetailPembelian::whereYear('created_at', Carbon::now()->format('Y'))->get();
            $penjualan = DetailPenjualan::whereYear('created_at', Carbon::now()->format('Y'))->get();
            $totalPengeluaranBulanIni = Laporan::where('nama_operasi', 'Pembelian')->whereMonth('tgl_laporan', Carbon::now()->month)->get()->sum('credit');
            $totalPendapatanBulanIni = Laporan::where('nama_operasi', 'Penjualan')->whereMonth('tgl_laporan', Carbon::now()->month)->get()->sum('debit');
            $profit = Laporan::sum('debit')-Laporan::sum('credit');
            $barangTerlaris = DetailPenjualan::orderBy('qty', 'DESC')->get();
            $penjualanLastWeek = DetailPenjualan::query()->whereBetween('created_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();

            $response = [
                'pembelian' => $pembelian,
                'penjualan' => $penjualan,
                'totalPengeluaranBulanIni' => $totalPengeluaranBulanIni,
                'totalPendapatanBulanIni' => $totalPendapatanBulanIni,
                'profit' => $profit,
                'barangTerlaris' => $barangTerlaris,
                'penjualanLastWeek' => $penjualanLastWeek,
            ];
            
            return new ApiResource(true, 'Berhasil Menampilkan Data', $response);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

}
