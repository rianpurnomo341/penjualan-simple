<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Barang;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BarangController extends Controller
{
    public function index()
    {
        try {
            $barang = Barang::with('kategori', 'satuan')->get();
            return new ApiResource(true, 'Berhasil Menampilkan Data', $barang);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function store(Request $request)
    {
        try {
            $validateData = $request->validate([
                'display' => 'array',
                'nama_barang' => 'required',
                'kategori_id' => 'required',
                'satuan_id' => 'required',
                'diskon' => 'required',
                'harga_before_diskon' => 'required',
                'harga_after_diskon' => 'required',
                'tgl_kadaluarsa' => 'required',
                'deskripsi' => 'required',
            ], [
                'required' => ':attribute tidak boleh kosong!',
            ]);
            
            // Decode the Base64-encoded image data
            $imageData = base64_decode($request->input('display.data'));
            $currentDateTime = Carbon::now()->timestamp; // Get current datetime as integer
            $imageName = $currentDateTime . '_' . $request->input('display.file_name');
            $barangTerakhir = Barang::latest()->first();
            $kode_barang = $barangTerakhir ? 'KD-BR-' . preg_replace('/[^0-9]/', '', $barangTerakhir->kode_barang) + 1 : 'KD-BR-1';

            $imagePath = 'display/' . $imageName;
            Storage::disk('public')->put($imagePath, $imageData);

            // Create a new Barang instance with the provided data
            $barang = new Barang();
            $barang->display = $imagePath;
            $barang->kode_barang = $kode_barang;
            $barang->nama_barang = $request->input('nama_barang');
            $barang->kategori_id = $request->input('kategori_id');
            $barang->satuan_id = $request->input('satuan_id');
            $barang->diskon = $request->input('diskon');
            $barang->harga_before_diskon = $request->input('harga_before_diskon');
            $barang->harga_after_diskon = $request->input('harga_after_diskon');
            $barang->tgl_kadaluarsa = $request->input('tgl_kadaluarsa');
            $barang->deskripsi = $request->input('deskripsi');

            // Save the Barang instance to the database
            $barang->save();
            // Return a response indicating success
            return response()->json(['message' => 'Data Berhasil Disimpan', 'barang' => $barang], 201);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function show(Barang $barang)
    {
        try {
            $barang = Barang::where('id_barang', $barang->id_barang)->with('kategori', 'satuan')->get();
            return new ApiResource(true, 'Berhasil Menampilkan Detail Data', $barang);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function update(Request $request, Barang $barang)
    {
        try {
            $validateData = $request->validate([
                'display' => 'required',
                'nama_barang' => 'required',
                'kategori_id' => 'required',
                'satuan_id' => 'required',
                'diskon' => 'required',
                'harga_before_diskon' => 'required',
                'harga_after_diskon' => 'required',
                'tgl_kadaluarsa' => 'required',
                'deskripsi' => 'required',
            ], [
                'required' => ':attribute tidak boleh kosong!',
            ]);

            $barang = $barang->update($validateData);
            return new ApiResource(true, 'Data Berhasil Disimpan', $validateData);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function destroy(Barang $barang)
    {
        try {
            $barang = $barang->delete();
            return new ApiResource(true, 'Data Berhasil Dihapus', $barang);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }
}
