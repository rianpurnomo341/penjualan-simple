<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\LaporanController;
use App\Http\Controllers\Api\PembelianController;
use App\Http\Controllers\Api\PenjualanController;
use App\Http\Controllers\Api\SatuanController;
use App\Http\Controllers\Api\SuplierController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/admin/registerStore', [AuthController::class, 'registerStore']);
Route::post('/admin/loginAuthenticate', [AuthController::class, 'loginAuthenticate']);
Route::get('/admin/logout', [AuthController::class, 'logout']);

Route::get('storage/{dir}/{dirdok}/{file}', function ($dir, $dirdok, $file) {
    $path = storage_path('app'
    . DIRECTORY_SEPARATOR . $dir
    . DIRECTORY_SEPARATOR . $dirdok
    . DIRECTORY_SEPARATOR . $file);
    return response()->file($path);
});

Route::get('storage/{dir}/{file}', function ($dir, $file) {
    $path = storage_path('app'
    . DIRECTORY_SEPARATOR . $dir
    . DIRECTORY_SEPARATOR . $file);
    return response()->file($path);
});

Route::get('/admin/pembelian/pagination', [PembelianController::class, 'getAllDataPembelian']);
Route::get('/admin/penjualan/pagination', [PenjualanController::class, 'getAllDataPenjualan']);
Route::get('/admin/penjualan/draft', [PenjualanController::class, 'getDraftPenjualan']);
Route::delete('/admin/penjualan/draft/{id}', [PenjualanController::class, 'deleteDraftPenjualan']);
Route::get('/admin/laporan/pagination', [LaporanController::class, 'getAllLaporan']);

Route::get('test/image', [LaporanController::class, 'generateImage']);
Route::get('test/pdf', [LaporanController::class, 'generatePdf']);
Route::get('test/pdfB3', [LaporanController::class, 'generatePdfB3']);

// Route::group(['middleware' => 'auth:api', 'prefix' => 'auth'], function () {
    Route::apiResource('/admin//dashboard', DashboardController::class);
    Route::apiResource('/admin/kategori', KategoriController::class);
    Route::apiResource('/admin/satuan', SatuanController::class);
    Route::apiResource('/admin/suplier', SuplierController::class);
    Route::apiResource('/admin/barang', BarangController::class);
    Route::apiResource('/admin/pembelian', PembelianController::class);
    Route::apiResource('/admin/penjualan', PenjualanController::class);
    Route::apiResource('/admin/laporan', LaporanController::class);
// });
