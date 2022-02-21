<?php

namespace App\Http\Controllers;

use App\Models\BaiVietChiaSe;
use App\Models\DanhGia;
use App\Models\DeXuatDiaDanh;
use App\Models\DiaDanh;
use App\Models\TinhThanh;
use App\Models\User;
use Carbon\Carbon;
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

    public function ThongKeChart()
    {
        $output = "";

        $countLike = DanhGia::where([
            ['created_at', Carbon::now()->month()],
            ['userLike', '=', 1]
        ])->count();
        $countUnLike = DanhGia::where([
            ['created_at', Carbon::now()->month()],
            ['userUnLike', '=', 1]
        ])->count();
        $countView = DanhGia::where([
            ['created_at', Carbon::now()->month()],
            ['userXem', '=', 1]
        ])->count();

        $output .= "<input type='hidden' id='like' value='" . $countLike . "' />" .
            "<input type='hidden' id='unlike' value='" . $countUnLike . "' />" .
            "<input type='hidden' id='view' value='" . $countView . "' />";

        return response()->json($output);
    }
}
