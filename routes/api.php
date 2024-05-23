<?php

use App\Http\Controllers\API\DosenController;
use App\Http\Controllers\API\KriteriaController;
use App\Http\Controllers\API\KuesionerController;
use App\Http\Controllers\API\LaporanController;
use App\Http\Controllers\API\MonitoringController;
use App\Http\Controllers\API\PenilaianController;
use App\Http\Controllers\API\PertanyaanController;
use App\Http\Controllers\API\RangkingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Manajemen Kriteria Penilaian
Route::resource('kriteria', KriteriaController::class);

// Manajemen Alternatif (Dosen)
Route::resource('dosen', DosenController::class);

// Manajemen Kuesioner
Route::resource('kuesioner', KuesionerController::class);
Route::resource('pertanyaan', PertanyaanController::class);

// Proses Penilaian
Route::post('/penilaian', [PenilaianController::class, 'store']);

// Perhitungan Rata-rata dan Pengurutan
Route::get('/ranking', [RangkingController::class, 'index']);

// Laporan dan Monitoring
Route::get('/laporan', [LaporanController::class, 'index']);
Route::get('/monitoring', [MonitoringController::class, 'index']);
