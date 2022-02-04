<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeXuatDiaDanh;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DeXuatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

            $validator = Validator::make($request->all(), [
                'tenDiaDanh' => 'required|unique:dia_danhs',
                'moTa' => 'required',
                'kinhDo' => 'required|numeric',
                'viDo' => 'required|numeric',
                'hinhAnh' => 'required',
            ], [
                'tenDiaDanh.required' => "Tên địa danh không được bỏ trống",
                'tenDiaDanh.unique' => "Tên địa danh bị trùng",
                'moTa.required' => 'Mô tả không được bỏ trống',
                'kinhDo.required' => 'Kinh độ không được bỏ trống',
                'viDo.required' => 'Vĩ độ không được bỏ trống',
                'kinhDo.numeric' => 'Kinh độ phải là số thực',
                'viDo.numeric' => 'Vĩ độ phải là số thực',
                'hinhAnh.required' => 'Bắt buộc chọn hình ảnh',
            ]);

            if ($validator->fails()) {
                return response([
                    'error' => $validator->errors()->all()
                ], 422);
            }

            $deXuat = new DeXuatDiaDanh();

            $deXuat->fill([
                'tenDiaDanh' => $request->tenDiaDanh,
                'moTa' => $request->moTa,
                'kinhDo' => $request->kinhDo,
                'viDo' => $request->viDo,
                'tinh_thanh_id' => $request->tinh_thanh_id,
                'user_id' => request()->user()->id,
                'hinhAnh' => '',
                'trangThai' => 0,
            ]);

            $deXuat->save();

            if ($request->hasFile('hinhAnh')) {
                $deXuat->hinhAnh = Storage::disk('public')->put('images', $request->file('hinhAnh'));
            }
            $deXuat->save();

            return response([
                'message' => 'Đề xuất thành công',
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'message' => 'Có lỗi xảy ra',
                'error' => $error,
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DeXuatDiaDanh  $deXuatDiaDanh
     * @return \Illuminate\Http\Response
     */
    public function show(DeXuatDiaDanh $deXuatDiaDanh)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DeXuatDiaDanh  $deXuatDiaDanh
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeXuatDiaDanh $deXuatDiaDanh)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeXuatDiaDanh  $deXuatDiaDanh
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeXuatDiaDanh $deXuatDiaDanh)
    {
        //
    }
}
