<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Barang;
use App\Models\DetailPembelian;
use App\Models\Laporan;
use App\Models\Pembelian;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
require 'BarangController.php';
class PembelianController extends Controller
{
    public $brngController;

    public function __construct()
    {
        $this->brngController = new BarangController();
    }
    public function index()
    {
        try {
            $pembelian = Pembelian::with('suplier', 'detail_pembelian', 'user_admin')
                ->orderBy('tanggal_pembelian', 'desc')
                ->get();
            return new ApiResource(true, 'Berhasil Menampilkan Data', $pembelian);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function getAllDataPembelian(Request $request)
    {
        try {
            $limit = max(1, intval($request->limit));
            $pageNumber = max(0, intval($request->pageNumber));

            $offset = $pageNumber * $limit;

            $getPembelian = Pembelian::with('suplier', 'detail_pembelian', 'user_admin')
            ->whereNull('deleted_at');
            
            if ($request->filter) {
                $filter = $request->filter;
                if ($filter['global_search']) {
                    $value = '%' . $filter['global_search'] . '%';
                    $getPembelian = $getPembelian
                        ->where('kode_pembelian', 'LIKE', $value)
                        ->orWhere('tanggal_pembelian', 'LIKE', $value)
                        ->orWhere('total_pembelian', 'LIKE', $value)
                        ->orWhere('jml_bayar_pembelian', 'LIKE', $value)
                        ->orWhere('jml_kembalian_pembelian', 'LIKE', $value)
                        // ->orWhere('users.name', 'LIKE', $value)
                    ;
                } else if ($filter['kode_pembelian']) {
                    $getPembelian = $getPembelian->where('kode_pembelian', $filter['kode_pembelian']);
                } else if ($filter['tanggal_pembelian']) {
                    $getPembelian = $getPembelian->where('tanggal_pembelian', $filter['tanggal_pembelian']);
                } else if ($filter['total_pembelian']) {
                    $getPembelian = $getPembelian->where('total_pembelian', $filter['total_pembelian']);
                } else if ($filter['jml_bayar_pembelian']) {
                    $getPembelian = $getPembelian->where('jml_bayar_pembelian', $filter['jml_bayar_pembelian']);
                } else if ($filter['jml_kembalian_pembelian']) {
                    $getPembelian = $getPembelian->where('jml_kembalian_pembelian', $filter['jml_kembalian_pembelian']);
                }

            }
            // Fetch total data count
            $totalDataCount = $getPembelian->count();

            // Calculate total number of pages
            $totalPages = ceil($totalDataCount / $limit);

            $dataPembelian = $getPembelian
                ->orderBy('created_at', 'desc')
                ->skip($offset)
                ->take($limit)
                ->get();

            $startIndex = $offset + 1;
            $endIndex = min($offset + $limit, $totalDataCount);

            // Prepare response data including page information
            $responseData = [];
            if ($dataPembelian && $dataPembelian->isNotEmpty()) {
                $responseData = [
                    'totalDataCount' => $totalDataCount,
                    'totalPages' => $totalPages,
                    'startIndex' => $startIndex,
                    'endIndex' => $endIndex,
                    'data' => $dataPembelian,
                ];
            } else {
                $responseData = [
                    'totalDataCount' => 0,
                    'totalPages' => 0,
                    'startIndex' => 0,
                    'endIndex' => 0,
                    'data' => $dataPembelian,
                ];
            }

            // Return the response
            return $responseData;

        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function store(Request $request)
    {
        try {
            $waktu_sekarang = Carbon::now()->format('H:i:s');
            $tgl_sekarang = Carbon::now()->format('Y-m-d');

            $validateDataPembelian = $request->validate([
                'suplier_id' => 'required',
                'total_pembelian' => 'required',
                'jml_bayar_pembelian' => 'required',
                'jml_kembalian_pembelian' => 'required',
                'user_admin' => 'required',
            ], [
                'required' => ':attribute tidak boleh kosong!',
            ]);

            // cek apakah barang ada atau tidak 
            $notFoundItem = array();
            foreach ($request->item as $key => $value) {

                $getBarang = Barang::where('id_barang', $value['barang_id'])->where('deleted_at', null)->first();

                if (!$getBarang) {

                    array_push($notFoundItem, $value);
                }

            }

            if (count($notFoundItem) > 0) {

                return new ApiResource(false, 'barang yang anda maksud belum ada di database!', $notFoundItem);

            }

            $validateDataPembelian['tanggal_pembelian'] = $tgl_sekarang;
            $validateDataPembelian['kode_pembelian'] = Pembelian::latest()->first() ? 'PMBL-' . intval(preg_replace('/[^0-9]/', '', Pembelian::latest()->first()->kode_pembelian)) + 1 : 'PMBL-1';
            $pembelian = Pembelian::create($validateDataPembelian);

            $detail_pembelian = $this->storeDetailPembelian($request, $pembelian->id_pembelian);
            $id_admin = $request->user_admin;
            $laporan = $this->storeLaporan($request, $pembelian->id_pembelian, $waktu_sekarang, $tgl_sekarang, $id_admin);

            $response = [
                'kode_pembelian' => $pembelian->kode_pembelian,
                'jml_kembalian_pembelian' => $request->jml_kembalian_pembelian,
                'pembelian' => $pembelian == true ? true : false,
                'detail_pembelian' => $detail_pembelian,
                'laporan' => $laporan,
            ];

            return new ApiResource(true, 'Data Berhasil Disimpan', $response);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function show(Pembelian $pembelian)
    {
        try {
            $pembelian = Pembelian::where('id_pembelian', $pembelian->id_pembelian)->with('suplier', 'detail_pembelian')->get();
            return new ApiResource(true, 'Berhasil Menampilkan Data', $pembelian);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function storeDetailPembelian(Request $request, $id_pembelian)
    {
        try {
            foreach ($request->item as $key => $value) {
                $dataDetailPembelian = [
                    'barang_id' => $value['barang_id'],
                    'pembelian_id' => $id_pembelian,
                    'qty' => $value['qty'],
                    'harga_pembelian' => $value['harga_pembelian'],
                    'total_harga' => $value['total_harga'],
                ];


                $barang = Barang::where('id_barang', $value['barang_id'])
                    ->where('deleted_at', null)
                    ->first();
                
                DetailPembelian::create($dataDetailPembelian);
                
                $harga_sugested = $this->brngController->generateSugestedPrice($barang);
                
                if ($barang) {
                    Barang::where('id_barang', $value['barang_id'])->update([
                        'qty' => $barang->qty + $value['qty'],
                        'harga_rekomendasi' => $harga_sugested
                    ]);

                }

            }

            return true;
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function storeLaporan(Request $request, $id_pembelian, $waktu_sekarang, $tgl_sekarang, $admin)
    {
        try {

            $dataLaporan = [
                'user_admin' => $admin,
                'pembelian_id' => $id_pembelian,
                'penjualan_id' => null,
                'kode_laporan' => Laporan::latest()->first() ? 'LB-IN-' . preg_replace('/[^0-9]/', '', Laporan::latest()->first()->kode_laporan) + 1 : 'LB-IN-1',
                'nama_operasi' => 'Pembelian',
                'tgl_laporan' => $tgl_sekarang,
                'waktu' => $waktu_sekarang,
                'credit' => $request->total_pembelian,
                'debit' => 0,
                'saldo' => Laporan::latest()->first() ? Laporan::latest()->first()->saldo - $request->total_pembelian : 0 - $request->total_pembelian,
            ];
            $laporan = Laporan::create($dataLaporan);
            
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }

        return $laporan == true ? true : false;
    }
}
