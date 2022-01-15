<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BaiVietChiaSe;
use App\Models\DanhGia;
use App\Models\HinhAnh;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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

    protected function fixImageUser(User $hinhAnh)
    {
        if (Storage::disk('public')->exists($hinhAnh->hinhAnh)) {
            $hinhAnh->hinhAnh = $hinhAnh->hinhAnh;
        } else {
            $hinhAnh->hinhAnh = 'images/user-default.jpg';
        }
    }
    public function index()
    {
        $baiViet = BaiVietChiaSe::with(['diadanh:id,tenDiaDanh,moTa,kinhDo,viDo,tinh_thanh_id,trangThai', 'hinhanh:id,idDiaDanh,hinhAnh,idBaiVietChiaSe,idLoai', 'user'])->withCount(['likes' => function ($query) {
            $query->where('userLike', '=', 1);
        }])->withCount(['unlikes' => function ($query) {
            $query->where('userUnLike', '=', 1);
        }])->withCount(['views' => function ($query) {
            $query->where('userXem', '=', 1);
        }])->orderBy('created_at', 'desc')->get();
        foreach ($baiViet as $item) {
            $this->fixImage($item->hinhanh);
            $this->fixImageUser($item->user);
            $item->thoiGian = date('d-m-Y', strtotime($item->thoiGian));
        }
        return response()->json([
            'data' => $baiViet
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'noiDung' => 'required',
                    'hinhAnh' => 'required',
                    'idUser' => 'required',
                    'idDiaDanh' => 'required',
                ],
                [
                    'noiDung.required' => 'Nội dung không được bỏ trống',
                    'hinhAnh.required' => "Bắt buộc chọn hình ảnh"
                ]
            );

            if ($validator->fails()) {
                return response([
                    'error' => $validator->errors()->all()
                ], 422);
            }

            $baiViet = new BaiVietChiaSe();
            $baiViet->fill([
                'idDiaDanh' => $request->input('idDiaDanh'),
                'idUser' => $request->input('idUser'),
                'noiDung' => $request->input('noiDung'),
                'thoiGian' => Carbon::now()->toDateTimeString(),
                'trangThai' => 1
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

            return response()->json([
                'status_code' => 200,
                'message' => 'Create Post Successfull',
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error in Create Post',
                'error' => $error,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BaiVietChiaSe  $baiVietChiaSe
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $baiViet = BaiVietChiaSe::with(['diadanh:id,tenDiaDanh,moTa,kinhDo,viDo,tinh_thanh_id,trangThai', 'hinhanh:id,idDiaDanh,hinhAnh,idBaiVietChiaSe,idLoai', 'user'])->withCount(['likes' => function ($query) {
            $query->where('userLike', '=', 1);
        }])->withCount(['unlikes' => function ($query) {
            $query->where('userUnLike', '=', 1);
        }])->withCount(['views' => function ($query) {
            $query->where('userXem', '=', 1);
        }])->orderBy('likes_count', 'desc')->take(5)->get();
        foreach ($baiViet as $item) {
            $this->fixImage($item->hinhanh);
            $this->fixImageUser($item->user);
            $item->thoiGian = date('d-m-Y', strtotime($item->thoiGian));
        }
        return response()->json([
            'data' => $baiViet
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BaiVietChiaSe  $baiVietChiaSe
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, BaiVietChiaSe $baiVietChiaSe)
    public function update(Request $request, $id)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'noiDung' => 'required',
                    'hinhAnh' => 'required',
                    'idUser' => 'required',
                    'idDiaDanh' => 'required',
                ],
                [
                    'noiDung.required' => 'Nội dung không được bỏ trống',
                    'hinhAnh.required' => "Bắt buộc chọn hình ảnh"
                ]
            );

            if ($validator->fails()) {
                return response([
                    'error' => $validator->errors()->all()
                ], 422);
            }

            $baiViet = BaiVietChiaSe::find($id);
            $baiViet->fill([
                'idDiaDanh' => $baiViet->idDiaDanh,
                'idUser' => $baiViet->idUser,
                'noiDung' => $request->input('noiDung'),
                'thoiGian' => Carbon::now()->toDateTimeString(),
                'trangThai' => 1
            ]);
            $baiViet->update();

            $hinhAnh = HinhAnh::where('idBaiVietChiaSe', '=', $id)->first();

            $hinhAnh->fill([
                'idDiaDanh' => $request->input('idDiaDanh'),
                'idBaiVietChiaSe' => $baiViet->id,
                'idLoai' => 2,
                'hinhAnh' => '',
            ]);
            $hinhAnh->update();
            $hinhAnh->hinhAnh = Storage::disk('public')->put('images', $request->file('hinhAnh'));
            $hinhAnh->update();

            return response()->json([
                'status_code' => 200,
                'message' => 'Update Post Successfull',
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error in Update Post',
                'error' => $error,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BaiVietChiaSe  $baiVietChiaSe
     * @return \Illuminate\Http\Response
     */
    public function destroy(BaiVietChiaSe $baiVietChiaSe)
    {
        //
    }
}
