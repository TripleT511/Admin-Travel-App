<?php

use App\Http\Controllers\BaiVietChiaSeController;
use App\Http\Controllers\DeXuatDiaDanhController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TinhThanhController;
use App\Http\Controllers\DiaDanhController;
use App\Http\Controllers\DiaDanhNhuCauController;
use App\Http\Controllers\LuuTruController;
use App\Http\Controllers\MonAnController;
use App\Http\Controllers\NhuCauController;
use App\Http\Controllers\QuanAnController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('tinhThanh', TinhThanhController::class);

    Route::resource('diaDanh', DiaDanhController::class);

    Route::resource('nhuCau', NhuCauController::class);

    Route::resource('diaDanhNhuCau', DiaDanhNhuCauController::class);

    Route::resource('baiViet', BaiVietChiaSeController::class);

    Route::resource('luuTru', LuuTruController::class);

    Route::resource('quanAn', QuanAnController::class);

    Route::resource('monAn', MonAnController::class);

    Route::resource('deXuat', DeXuatDiaDanhController::class);

    Route::get('/register', [LoginController::class, 'showFormregister'])->name('show-register');

    Route::post('/register', [LoginController::class, 'register'])->name('register');

    Route::get('/user', [LoginController::class, 'index'])->name("lstUser");

    Route::get('/user/show/{id}', [LoginController::class, 'show'])->name("show");
});


Route::get('/login', [LoginController::class, 'showFormlogin'])->name('show-login');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');



Route::get('/forgot', [LoginController::class, 'showFormForgot'])->name('showforgot');
Route::post('/forgot', [LoginController::class, 'forgot'])->name('forgot');

Route::get('/reset-password/{token}', [LoginController::class, 'showFormReset'])->name('showReset');
Route::post('/reset-password', [LoginController::class, 'reset'])->name('reset');
