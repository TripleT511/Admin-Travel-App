<?php

use App\Http\Controllers\Api\BaiVietChiaSeController;
use App\Http\Controllers\Api\TinhThanhController as ApiTinhThanhController;
use App\Http\Controllers\ApiDiaDanhController;
use App\Http\Controllers\ApiHinhAnhController;
use App\Http\Controllers\ApiNhuCauController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TinhThanhController;

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

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/user/change-password', [AuthController::class, 'updatePassword']);

    Route::post('/user/avatar', [AuthController::class, 'updateAvatar']);

    // Lấy danh sách các token của user hiện tại
    Route::get('/user/sessions', [AuthController::class, 'getListToken']);

    //Xoá 1 token của user theo id
    Route::delete('/user/sessions/{tokenId}', [AuthController::class, 'deleteTokenById']);

    //Xoá toàn bộ token
    Route::delete('/user/sessions', [AuthController::class, 'deleteAllToken']);

    // Tỉnh thành //
    Route::get('/tinhthanh', [ApiTinhThanhController::class, 'index']);

    Route::get('/tinhthanh/{id}', [ApiTinhThanhController::class, 'show']);
    // Tỉnh thành //

    Route::get('/nhucau', [ApiNhuCauController::class, 'index']);

    Route::get('/diadanh', [ApiDiaDanhController::class, 'index']);

    Route::get('/diadanh/{id}', [ApiDiaDanhController::class, 'show']);

    Route::get('/hinhanh/{id}', [ApiHinhAnhController::class, 'show']);

    Route::get('/baiviet', [BaiVietChiaSeController::class, 'index']);

    Route::post('/baiviet/create', [BaiVietChiaSeController::class, 'store']);

    // Bài viết //
    Route::put('/baiviet/update/{id}', [BaiVietChiaSeController::class, 'update']);

    Route::get('/baiviet/noibat', [BaiVietChiaSeController::class, 'show']);
    // Bài viết //
});


// Đăng nhập
Route::post('/login', [AuthController::class, 'login']);

// Đăng ký
Route::post('/register', [AuthController::class, 'register']);

// Lấy danh sách tất cả user
Route::get('/users', [AuthController::class, 'getAllUser']);
