<?php

use App\Http\Controllers\Api\BaiVietChiaSeController;
use App\Http\Controllers\Api\DeXuatController;
use App\Http\Controllers\Api\DiaDanhController;
use App\Http\Controllers\Api\HinhAnhController;
use App\Http\Controllers\Api\LuuTruController;
use App\Http\Controllers\Api\TinhThanhController;
use App\Http\Controllers\Api\NhuCauController;
use App\Http\Controllers\Api\QuanAnController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

    Route::get('/user', [AuthController::class, 'getUser']);

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/user/change-password', [AuthController::class, 'updatePassword']);

    Route::post('/user/update-infor', [AuthController::class, 'updateInfor']);

    Route::post('/user/avatar', [AuthController::class, 'updateAvatar']);

    // Lấy danh sách các token của user hiện tại
    Route::get('/user/sessions', [AuthController::class, 'getListToken']);

    //Xoá 1 token của user theo id
    Route::delete('/user/sessions/{tokenId}', [AuthController::class, 'deleteTokenById']);

    //Xoá toàn bộ token
    Route::delete('/user/sessions', [AuthController::class, 'deleteAllToken']);

    // Tỉnh thành //
    Route::get('/tinhthanh', [TinhThanhController::class, 'index']);

    Route::get('/tinhthanh/{id}', [TinhThanhController::class, 'show']);
    // Tỉnh thành //

    Route::get('/nhucau', [NhuCauController::class, 'index']);

    Route::get('/nhucau/{id}', [NhuCauController::class, 'show']);

    // Danh sách địa danh
    Route::get('/diadanh', [DiaDanhController::class, 'index']);

    // Danh sách địa danh nổi bật
    Route::get('/diadanh/noibat', [DiaDanhController::class, 'noibat']);

    // Chi tiết địa danh
    Route::get('/diadanh/{id}', [DiaDanhController::class, 'show']);

    Route::get('/hinhanh/{id}', [HinhAnhController::class, 'show']);

    Route::get('/baiviet', [BaiVietChiaSeController::class, 'index']);

    Route::post('/baiviet/create', [BaiVietChiaSeController::class, 'store']);

    // Cập nhật Bài viết //
    Route::put('/baiviet/{id}/update', [BaiVietChiaSeController::class, 'update']);

    // Xoá Bài viết //
    Route::delete('/baiviet/{id}/delete', [BaiVietChiaSeController::class, 'destroy']);

    // Like bài viết //
    Route::patch('/baiviet/{id}/like', [BaiVietChiaSeController::class, 'like']);

    // Like bài viết //
    Route::patch('/baiviet/{id}/unlike', [BaiVietChiaSeController::class, 'unlike']);

    // View bài viết //
    Route::patch('/baiviet/{id}/view', [BaiVietChiaSeController::class, 'view']);

    // Bài viết //
    Route::get('/baiviet', [BaiVietChiaSeController::class, 'index']);

    // Bài viết của user
    Route::get('user/{id}/baiviet', [BaiVietChiaSeController::class, 'baivietuser']);

    // Bài viết nổi bật
    Route::get('/baiviet/noibat', [BaiVietChiaSeController::class, 'show']);

    // Bài viết theo id
    Route::get('baiviet/{id}', [BaiVietChiaSeController::class, 'getBaiVietById']);


    //Luu trú theo id địa danh
    Route::get('diadanh/{id}/luutru', [LuuTruController::class, 'index']);

    //Chi tiết lưu trú
    Route::get('luutru/{id}', [LuuTruController::class, 'show']);

    //Quán ăn theo id địa danh
    Route::get('diadanh/{id}/quanan', [QuanAnController::class, 'index']);

    //Chi tiết quán ăn
    Route::get('quanan/{id}', [QuanAnController::class, 'show']);

    //Đề xuất địa danh
    Route::post('dexuat', [DeXuatController::class, 'store']);
});


// Đăng nhập
Route::post('/login', [AuthController::class, 'login']);

// Đăng ký
Route::post('/register', [AuthController::class, 'register']);

// Lấy danh sách tất cả user
Route::get('/users', [AuthController::class, 'getAllUser']);

// Gửi email xác nhận
Route::post('/forgot', [AuthController::class, 'forgot']);

// Reset mật khẩu
Route::post('/check-token', [AuthController::class, 'checkToken']);

// Reset mật khẩu
Route::post('/reset/{token}', [AuthController::class, 'reset']);

// Danh sách token
Route::get('/list-token', [AuthController::class, 'getAllToken']);
