<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Barang;
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
            $penjualan = Penjualan::with('detail_penjualan')
                ->with('user_admin')
                ->where(function ($query) {
                    $query->where('draft', false)
                          ->orWhereNull('draft');
                })
                ->where('deleted_at', null)
                ->orderBy('tanggal_penjualan', 'desc')
                ->get();

            return new ApiResource(true, 'Berhasil Menampilkan Data', $penjualan);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function getAllDataPenjualan(Request $request)
    {
        try {
            $limit = max(1, intval($request->limit));
            $pageNumber = max(0, intval($request->pageNumber));

            $offset = $pageNumber * $limit;

            $getPenjualan = Penjualan::with('detail_penjualan')
            ->with('user_admin')
            ->where(function ($query) {
                $query->where('draft', false)
                      ->orWhereNull('draft');
            })
            ->whereNull('deleted_at');

            if ($request->filter) {
                $filter = $request->filter;
                if ($filter['global_search']) {
                    $value = '%'.$filter['global_search'].'%';
                    $getPenjualan = $getPenjualan
                    ->where('kode_penjualan', 'LIKE', $value)
                    ->orWhere('tanggal_penjualan', 'LIKE', $value)
                    ->orWhere('total_penjualan', 'LIKE', $value)
                    ->orWhere('jml_bayar_penjualan', 'LIKE', $value)
                    ->orWhere('jml_kembalian_penjualan', 'LIKE', $value)
                    // ->orWhere('users.name', 'LIKE', $value)
                    ;
                } else if ($filter['kode_penjualan']) {
                    $getPenjualan = $getPenjualan->where('kode_penjualan', $filter['kode_penjualan']);
                } else if ($filter['tanggal_penjualan']) {
                    $getPenjualan = $getPenjualan->where('tanggal_penjualan', $filter['tanggal_penjualan']);
                } else if ($filter['total_penjualan']) {
                    $getPenjualan = $getPenjualan->where('total_penjualan', $filter['total_penjualan']);
                } else if ($filter['jml_bayar_penjualan']) {
                    $getPenjualan = $getPenjualan->where('jml_bayar_penjualan', $filter['jml_bayar_penjualan']);
                } else if ($filter['jml_kembalian_penjualan']) {
                    $getPenjualan = $getPenjualan->where('jml_kembalian_penjualan', $filter['jml_kembalian_penjualan']);
                }
                
            }

            // Fetch total data count
            $totalDataCount = $getPenjualan->count();

            // Calculate total number of pages
            $totalPages = ceil($totalDataCount / $limit);

            $dataPenjualan = $getPenjualan
                ->orderBy('created_at', 'asc')
                ->skip($offset)
                ->take($limit)
                ->get();

            $startIndex = $offset + 1;
            $endIndex = min($offset + $limit, $totalDataCount);

            // Prepare response data including page information
            $responseData = [];
            if ($dataPenjualan && $dataPenjualan->isNotEmpty()) {
                $responseData = [
                    'totalDataCount' => $totalDataCount,
                    'totalPages' => $totalPages,
                    'startIndex' => $startIndex,
                    'endIndex' => $endIndex,
                    'data' => $dataPenjualan,
                ];
            } else {
                $responseData = [
                    'totalDataCount' => 0,
                    'totalPages' => 0,
                    'startIndex' => 0,
                    'endIndex' => 0,
                    'data' => $dataPenjualan,
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
            $getOutOfStock = array();
            $notFoundItem = array();

            foreach ($request->item as $key => $value) {

                $getBarang = Barang::where("id_barang", $value['barang_id'])->where('deleted_at', null)->first();
                
                if ($getBarang && ($getBarang->qty == 0 || $getBarang->qty < $value['qty'])) {
                    
                    array_push($getOutOfStock, $getBarang);
                } else if (!$getBarang) {

                    array_push($notFoundItem, $value);
                }
 
            }

            if (count($notFoundItem) > 0) {
                
                return new ApiResource(false, 'barang yang anda maksud tidak ditemukan!', $notFoundItem);
                
            }

            if (count($getOutOfStock) > 0) {
                
                return new ApiResource(false, 'Qty Barang ada yang kurang!', $getOutOfStock);

            }
            

            $waktu_sekarang = Carbon::now()->format('H:i:s');
            $tgl_sekarang = Carbon::now()->format('Y-m-d');

            $validateDataPenjualan = $request->validate([
                'total_penjualan' => 'required',
                'jml_bayar_penjualan' => 'required',
                'jml_kembalian_penjualan' => 'required',
                'user_admin' => 'required',
                'draft' => 'nullable',
            ], [
                'required' => ':attribute tidak boleh kosong!',
            ]);
            
            $validateDataPenjualan['tanggal_penjualan'] = $tgl_sekarang;
            $validateDataPenjualan['kode_penjualan'] = Penjualan::latest()->first() ? 'PNJL-' . intval(preg_replace('/[^0-9]/', '', Penjualan::latest()->first()->kode_penjualan)) + 1 : 'PNJL-1';
            $penjualan = Penjualan::create($validateDataPenjualan);

            $detailPenjualan = $this->storeDetailpenjualan($request, $penjualan->id_penjualan, $request->draft);

            $laporan = false;
            $id_admin = $request->user_admin;
            if (!$request->draft) {
                $laporan = $this->storeLaporan($request, $penjualan->id_penjualan, $waktu_sekarang, $tgl_sekarang, $id_admin);
            }

            $response = [
                'kode_penjualan' => $validateDataPenjualan['kode_penjualan'],
                'jml_kembalian_penjualan' => $request->jml_kembalian_penjualan,
                'penjualan' => $penjualan == true ? true : false,
                'detail_penjualan' => $detailPenjualan,
                'laporan' => $laporan,
            ];

            return new ApiResource(true, 'Data Berhasil Disimpan', $response);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function show(Penjualan $penjualan)
    {
        try {
            $penjualan = Penjualan::where('id_penjualan', $penjualan->id_penjualan)
            ->whereNull('deleted_at')
            ->with('user_admin')
            ->with('detail_penjualan')->get();
            return new ApiResource(true, 'Berhasil Menampilkan Data', $penjualan);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }
    public function getDraftPenjualan(Request $request)
    {
        try {

            $getPenjualan = Penjualan::with('detail_penjualan')
            ->where('draft', true)
            ->where('deleted_at', null);

            if ($request->filter) {
                $filter = $request->filter;
                if ($filter['global_search']) {
                    $value = '%'.$filter['global_search'].'%';
                    $getPenjualan = $getPenjualan
                    ->where('kode_penjualan', 'LIKE', $value)
                    ->orWhere('tanggal_penjualan', 'LIKE', $value)
                    ->orWhere('total_penjualan', 'LIKE', $value)
                    ->orWhere('jml_bayar_penjualan', 'LIKE', $value)
                    ->orWhere('jml_kembalian_penjualan', 'LIKE', $value)
                    // ->orWhere('users.name', 'LIKE', $value)
                    ;
                } else if ($filter['kode_penjualan']) {
                    $getPenjualan = $getPenjualan->where('kode_penjualan', $filter['kode_penjualan']);
                } else if ($filter['tanggal_penjualan']) {
                    $getPenjualan = $getPenjualan->where('tanggal_penjualan', $filter['tanggal_penjualan']);
                } else if ($filter['total_penjualan']) {
                    $getPenjualan = $getPenjualan->where('total_penjualan', $filter['total_penjualan']);
                } else if ($filter['jml_bayar_penjualan']) {
                    $getPenjualan = $getPenjualan->where('jml_bayar_penjualan', $filter['jml_bayar_penjualan']);
                } else if ($filter['jml_kembalian_penjualan']) {
                    $getPenjualan = $getPenjualan->where('jml_kembalian_penjualan', $filter['jml_kembalian_penjualan']);
                }
                
            }

            $getPenjualan = $getPenjualan->latest()
            ->limit(5)
            ->get();
            


            return new ApiResource(true, 'Berhasil Menampilkan Data', $getPenjualan);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function storeDetailpenjualan(Request $request, $id_penjualan, $is_draft = false)
    {
        try {
            foreach ($request->item as $key => $value) {
                $dataDetailPenjualan = [
                    'barang_id' => $value['barang_id'],
                    'penjualan_id' => $id_penjualan,
                    'qty' => $value['qty'],
                    'harga_penjualan' => $value['harga_penjualan'],
                    'total_harga' => $value['total_harga'],
                ];

                if (!$is_draft) {
                    $barang = Barang::where('id_barang', $value['barang_id'])
                    ->where('deleted_at', null)
                    ->first();

                    if ($barang) {
                        Barang::where('id_barang', $value['barang_id'])->update([
                            'qty' => $barang->qty - $value['qty']
                        ]);
                    }
                }
                DetailPenjualan::create($dataDetailPenjualan);
            }
            return true;
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function storeLaporan(Request $request, $id_penjualan, $waktu_sekarang, $tgl_sekarang, $admin)
    {
        try {
            $dataLaporan = [
                'user_admin' => $admin,
                'pembelian_id' => null,
                'penjualan_id' => $id_penjualan,
                'kode_laporan' => Laporan::latest()->first() ? 'LB-OUT-' . preg_replace('/[^0-9]/', '', Laporan::latest()->first()->kode_laporan) + 1 : 'LB-OUT-1',
                'nama_operasi' => 'Penjualan',
                'tgl_laporan' => $tgl_sekarang,
                'waktu' => $waktu_sekarang,
                'credit' => 0,
                'debit' => $request->total_penjualan,
                'saldo' => Laporan::latest()->first() ? Laporan::latest()->first()->saldo + $request->total_penjualan : 0 + $request->total_penjualan,
            ];
            $laporan = Laporan::create($dataLaporan);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }

        return $laporan == true ? true : false;
    }

    public function deleteDraftPenjualan(Request $request, $id_penjualan)
    {
        // Find the penjualan record
        $penjualan = Penjualan::find($id_penjualan);

        if (!$penjualan || !$penjualan->draft) {
            // Handle case where the record doesn't exist
            return response()->json(['message' => 'Draft tidak ditemukan'], 404);
        }

        // Delete the related barangs
        $penjualan->detail_penjualan()->delete();

        // Now, delete the penjualan record itself
        $result = $penjualan->delete();

        // Return a success response or whatever is appropriate for your use case
        return new ApiResource(true, 'Draft Penjualan berhasil dihapus', $result);
    }

    public function destroy(Penjualan $penjualan)
    {
        try {
            $penjualanId = $penjualan->id_penjualan;
            // flow retur barang
        } catch (QueryException $e) {
             
        }
    }
}
