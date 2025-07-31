<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublikasiController;

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

// --- Routes Autentikasi (Tidak Dilindungi Sanctum) ---
// Ini adalah gerbang masuk ke aplikasi, jadi tidak memerlukan token.
Route::post('/register', [AuthController::class, 'register']); // Endpoint untuk pendaftaran user baru
Route::post('/login', [AuthController::class, 'login']);     // Endpoint untuk login user

// --- Routes yang Dilindungi oleh Autentikasi Laravel Sanctum ---
// Endpoint di dalam grup ini hanya bisa diakses oleh user yang sudah login
// dan menyertakan token autentikasi yang valid di header Authorization.
Route::middleware('auth:sanctum')->group(function () {
    
    // --- Routes untuk Publikasi (CRUD) ---
    // Endpoint untuk mengelola data publikasi
    Route::get('/publikasi', [PublikasiController::class, 'index']);      // Mengambil semua publikasi
    Route::post('/publikasi', [PublikasiController::class, 'store']);     // Menambah publikasi baru
    Route::get('/publikasi/{id}', [PublikasiController::class, 'show']);  // Menampilkan detail satu publikasi berdasarkan ID
    Route::put('/publikasi/{id}', [PublikasiController::class, 'update']); // Memperbarui data publikasi berdasarkan ID
    Route::delete('/publikasi/{id}', [PublikasiController::class, 'destroy']); // Menghapus publikasi berdasarkan ID

    // --- Route Logout ---
    // Endpoint untuk logout user dan menghapus token autentikasi yang aktif.
    Route::post('/logout', [AuthController::class, 'logout']);

    // --- Route untuk Mengambil Data User yang Sedang Login ---
    // Ini adalah route bawaan Laravel Sanctum untuk mendapatkan informasi user yang sedang terautentikasi.
    Route::get('/user', function (Request $request) {
        return $request->user();
    });


});