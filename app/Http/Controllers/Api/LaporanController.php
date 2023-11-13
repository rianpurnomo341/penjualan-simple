<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Laporan;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        try {
            $Laporan = Laporan::with('pembelian','penjualan')->get();
            return new ApiResource(true, 'Berhasil Menampilkan Data', $Laporan);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }
}
