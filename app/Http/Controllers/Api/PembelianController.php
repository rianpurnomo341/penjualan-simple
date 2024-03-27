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

class PembelianController extends Controller
{
    public function index()
    {
        try {
            $pembelian = Pembelian::with('suplier', 'detail_pembelian')
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

            // Fetch total data count
            $totalDataCount = Pembelian::count();

            // Calculate total number of pages
            $totalPages = ceil($totalDataCount / $limit);

            $dataPembelian = Pembelian::with('suplier', 'detail_pembelian')
                ->orderBy('tanggal_pembelian', 'desc')
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
            ], [
                'required' => ':attribute tidak boleh kosong!',
            ]);

            $validateDataPembelian['tanggal_pembelian'] = $tgl_sekarang;
            $validateDataPembelian['kode_pembelian'] = Pembelian::latest()->first() ? 'PMBL-' . preg_replace('/[^0-9]/', '', Pembelian::latest()->first()->kode_laporan) + 1 : 'PMBL-1';
            $pembelian = Pembelian::create($validateDataPembelian);

            $detailPenjualan = $this->storeDetailPembelian($request, $pembelian->id_pembelian);
            $laporan = $this->storeLaporan($request, $pembelian->id_pembelian, $waktu_sekarang, $tgl_sekarang);

            $response = [
                'kode_pembelian' => $pembelian->kode_pembelian,
                'jml_kembalian_pembelian' => $request->jml_kembalian_pembelian,
                'pembelian' => $pembelian == true ? true : false,
                'detail_pembelian' => $detailPenjualan,
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
                ];

                foreach (Barang::all() as $key => $item) {
                    if ($item->id_barang == $value['barang_id']) {
                        Barang::where('id_barang', $value['barang_id'])->update([
                            'qty' => $item->qty + $value['qty']
                        ]);
                    }
                }

                DetailPembelian::create($dataDetailPembelian);
            }

            return true;
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function storeLaporan(Request $request, $id_pembelian, $waktu_sekarang, $tgl_sekarang)
    {
        try {
            $dataLaporan = [
                'pembelian_id' => $id_pembelian,
                'penjualan_id' => null,
                'kode_laporan' => Laporan::latest()->first() ? 'LB-IN-' . preg_replace('/[^0-9]/', '', Laporan::latest()->first()->kode_laporan) + 1 : 'LB-IN-1',
                'nama_operasi' => 'Pembelian',
                'tgl_laporan' => $tgl_sekarang,
                'waktu' => $waktu_sekarang,
                'credit' => $request->jml_bayar_pembelian,
                'debit' => 0,
                'saldo' => Laporan::latest()->first() ? Laporan::latest()->first()->saldo - $request->jml_bayar_pembelian : $request->jml_bayar_pembelian,
            ];
            $laporan = Laporan::create($dataLaporan);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }

        return $laporan == true ? true : false;
    }
}
