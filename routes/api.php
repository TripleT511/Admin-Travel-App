<?php

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

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/user/change-password', [AuthController::class, 'updatePassword']);

    // Lấy danh sách các token của user hiện tại
    Route::get('/user/sessions', [AuthController::class, 'getListToken']);

    //Xoá 1 token của user theo id
    Route::delete('/user/sessions/{tokenId}', [AuthController::class, 'deleteTokenById']);

    //Xoá toàn bộ token
    Route::delete('/user/sessions', [AuthController::class, 'deleteAllToken']);
});


// Đăng nhập
Route::post('/login', [AuthController::class, 'login']);

// Đăng ký
Route::post('/register', [AuthController::class, 'register']);

// Lấy danh sách tất cả user
Route::get('/users', [AuthController::class, 'getAllUser']);
