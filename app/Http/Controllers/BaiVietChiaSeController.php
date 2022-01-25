<?php

namespace App\Http\Controllers;

use App\Models\BaiVietChiaSe;
use App\Http\Requests\StoreBaiVietChiaSeRequest;
use App\Http\Requests\UpdateBaiVietChiaSeRequest;
use App\Models\DanhGia;
use App\Models\DiaDanh;
use App\Models\HinhAnh;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class BaiVietChiaSeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function fixImage(HinhAnh $hinhAnh)
    {
        if (Storage::disk('public')->exists($hinhAnh->hinhAnh)) {
            $hinhAnh->hinhAnh = $hinhAnh->hinhAnh;
        } else {
            $hinhAnh->hinhAnh = 'images/no-image-available.jpg';
        }
    }
    public function index()
    {
        $lstBaiViet = BaiVietChiaSe::with(['diadanh:id,tenDiaDanh,moTa,kinhDo,viDo,tinh_thanh_id', 'user:id,hoTen'])->with(['hinhanh' => function ($query) {
            $query->where('idLoai', '=', '2');
        }])->with(['likes', 'unlikes', 'views'])->withCount(['likes' => function ($query) {
            $query->where('userLike', '=', 1);
        }])->withCount(['unlikes' => function ($query) {
            $query->where('userUnLike', '=', 1);
        }])->withCount(['views' => function ($query) {
            $query->where('userXem', '=', 1);
        }])->get();

        foreach ($lstBaiViet as $item) {
            $this->fixImage($item->hinhanh);
        }

        return view('baiviet.index-baiviet', ['lstBaiViet' => $lstBaiViet]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lstDiaDanh = DiaDanh::all();
        return view('baiviet.create-baiviet', ['lstDiaDanh' => $lstDiaDanh]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBaiVietChiaSeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBaiVietChiaSeRequest $request)
    {
        $request->validate([
            'noiDung' => 'required',
            'hinhAnh' => 'required'
        ], [
            'noiDung.required' => 'Nội dung không được bỏ trống',
            'hinhAnh.required' => "Hình ảnh không được bỏ trống"
        ]);
        $trangThai = 1;
        if ($request->input('trangThai') != "on") {
            $trangThai = 0;
        }
        $baiViet = new BaiVietChiaSe();
        $baiViet->fill([
            'idDiaDanh' => $request->input('idDiaDanh'),
            'idUser' => $request->user()->id,
            'noiDung' => $request->input('noiDung'),
            'thoiGian' => Carbon::now()->toDateTimeString(),
            'trangThai' => $trangThai
        ]);
        $baiViet->save();

        $danhgia = new DanhGia();
        $danhgia->fill([
            'idBaiViet' => $baiViet->id,
            'idUser' => $request->user()->id,
            'userLike' => 0,
            'userUnLike' => 0,
            'userXem' => 0,
        ]);
        $danhgia->save();

        $hinhAnh = new HinhAnh();

        $hinhAnh->fill([
            'idDiaDanh' => $request->input('idDiaDanh'),
            'idBaiVietChiaSe' => $baiViet->id,
            'idLoai' => 2,
            'hinhAnh' => '',
        ]);
        $hinhAnh->save();
        if ($request->hasFile('hinhAnh')) {

            $hinhAnh->hinhAnh = Storage::disk('public')->put('images', $request->file('hinhAnh'));
        }
        $hinhAnh->save();

        $lstBaiViet = BaiVietChiaSe::with(['diadanh:id,tenDiaDanh,moTa,kinhDo,viDo,tinh_thanh_id', 'hinhanh:id,idDiaDanh,idBaiVietChiaSe,hinhAnh,idLoai', 'user:id,hoTen'])->get();

        return view('baiviet.index-baiviet', ['lstBaiViet' => $lstBaiViet]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BaiVietChiaSe  $baiVietChiaSe
     * @return \Illuminate\Http\Response
     */
    public function show(BaiVietChiaSe $baiVietChiaSe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BaiVietChiaSe  $baiVietChiaSe
     * @return \Illuminate\Http\Response
     */
    public function edit(BaiVietChiaSe $baiViet)
    {
        $hinhAnh = $baiViet::with(['diadanh:id', 'hinhanh:id,idBaiVietChiaSe,hinhAnh'])->where('id', '=', $baiViet->id)->first();
        return view('baiviet.edit-baiviet', ['baiViet' => $hinhAnh]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBaiVietChiaSeRequest  $request
     * @param  \App\Models\BaiVietChiaSe  $baiVietChiaSe
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBaiVietChiaSeRequest $request, BaiVietChiaSe $baiViet)
    {
        $request->validate([
            'noiDung' => 'required',
        ], [
            'noiDung.required' => 'Nội dung không được bỏ trống',
        ]);
        $trangThai = 1;
        if ($request->input('trangThai') != "on") {
            $trangThai = 0;
        }

        $baiViet->fill([
            'idDiaDanh' => $baiViet->idDiaDanh,
            'idUser' => $baiViet->idUser,
            'noiDung' => $request->input('noiDung'),
            'thoiGian' => Carbon::now()->toDateTimeString(),
            'trangThai' => $trangThai
        ]);
        $baiViet->save();

        $hinhAnh = HinhAnh::where('idBaiVietChiaSe', '=', $baiViet->id)->first();
        if ($request->hasFile('hinhAnh')) {
            Storage::disk('public')->delete($hinhAnh->hinhAnh);
            $hinhAnh->hinhAnh = Storage::disk('public')->put('images', $request->file('hinhAnh'));
        }
        $hinhAnh->save();

        $lstBaiViet = BaiVietChiaSe::with(['diadanh:id,tenDiaDanh,moTa,kinhDo,viDo,tinh_thanh_id', 'hinhanh:id,idDiaDanh,idBaiVietChiaSe,hinhAnh,idLoai', 'user:id,hoTen'])->get();

        return view('baiviet.index-baiviet', ['lstBaiViet' => $lstBaiViet]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BaiVietChiaSe  $baiVietChiaSe
     * @return \Illuminate\Http\Response
     */
    public function destroy(BaiVietChiaSe $baiViet)
    {
        $hinhAnh = HinhAnh::where('idBaiVietChiaSe', '=', $baiViet->id);
        $hinhAnh->delete();
        $baiViet->delete();
        return Redirect::route('baiViet.index');
    }
}
