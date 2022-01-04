<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\TinhThanhController;
use App\Http\Controllers\DiaDanhController;
use App\Http\Controllers\DiaDanhNhuCauController;
use App\Http\Controllers\HinhAnhController;
use App\Http\Controllers\NhuCauController;
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
    Route::resource('tinhThanh', TinhThanhController::class);

    Route::resource('diaDanh', DiaDanhController::class);

    Route::resource('nhuCau', NhuCauController::class);

    Route::resource('diaDanhNhuCau', DiaDanhNhuCauController::class);

    Route::resource('hinhAnh', HinhAnhController::class);
});


Route::get('/', function () {
    return view('dashboard');
})->middleware('auth');


Route::get('/login', [LoginController::class, 'showFormlogin'])->name('show-login');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/register', [LoginController::class, 'showFormregister'])->name('show-register');
Route::post('/register', [LoginController::class, 'register'])->name('register');
