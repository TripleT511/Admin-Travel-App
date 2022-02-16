<?php

namespace App\Http\Controllers;

use App\Models\BaiVietChiaSe;
use App\Models\DeXuatDiaDanh;
use App\Models\DiaDanh;
use App\Models\TinhThanh;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $lstTaiKhoan = User::count();
        $lstDiaDanh = DiaDanh::count();
        $lstTinhThanh = TinhThanh::count();
        $lstBaiViet = BaiVietChiaSe::count();
        $lstDeXuat = DeXuatDiaDanh::count();
        return view('dashboard', ['lstTaiKhoan' => $lstTaiKhoan, 'lstDiaDanh' => $lstDiaDanh, 'lstTinhThanh' => $lstTinhThanh, 'lstBaiViet' => $lstBaiViet, 'lstDeXuat' => $lstDeXuat]);
    }
}
