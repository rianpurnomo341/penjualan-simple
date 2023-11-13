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