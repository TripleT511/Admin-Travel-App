<?php

namespace App\Http\Controllers;

use App\Models\DiaDanh;
use App\Models\HinhAnh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class HinhAnhController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // Phương thức hỗ trợ load hình và thay thế bằng hình mặc định nếu không tìm thấy file
    protected function fixImage(HinhAnh $hinhAnh)
    {
        if (Storage::disk('public')->exists($hinhAnh->hinh_anh)) {
            $hinhAnh->hinh_anh = Storage::url($hinhAnh->hinh_anh);
        } else {
            $hinhAnh->hinh_anh = '/img/no-image-available.jpg';
        }
    }
    public function index()
    {
        $lstHinhAnh = HinhAnh::with('diadanh')->get();
        return view('hinhanh.index-hinhanh', ["lstHinhAnh" => $lstHinhAnh]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lstDiaDanh = DiaDanh::all();
        return view('hinhanh.create-hinhanh', ['lstDiaDanh' => $lstDiaDanh]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $hinhAnh = new HinhAnh();

        $hinhAnh->fill([
            'idDiaDanh' => $request->input('idDiaDanh'),
            'idBaiVietChiaSe' => 1,
            'idLoai' => 1,
            'hinhAnh' => '',
        ]);
        $hinhAnh->save();
        if ($request->hasFile('hinhAnh')) {
            $hinhAnh->hinhAnh = Storage::disk('public')->put('images', $request->file('hinhAnh'));
        }
        $hinhAnh->save();
        $lstDiaDanh = DiaDanh::all();
        return view('hinhanh.create-hinhanh', ['lstDiaDanh' => $lstDiaDanh]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HinhAnh  $hinhAnh
     * @return \Illuminate\Http\Response
     */
    public function show(HinhAnh $hinhAnh)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HinhAnh  $hinhAnh
     * @return \Illuminate\Http\Response
     */
    public function edit(HinhAnh $hinhAnh)
    {
        $lstDiaDanh = DiaDanh::all();
        return view('hinhanh.edit-hinhanh', ['hinhAnh' => $hinhAnh, 'lstDiaDanh' => $lstDiaDanh]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HinhAnh  $hinhAnh
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HinhAnh $hinhAnh)
    {
        if ($request->hasFile('hinhAnh')) {
            $hinhAnh->fill([
                'idDiaDanh' => $request->input('idDiaDanh'),
                'idBaiVietChiaSe' => 1,
                'idLoai' => 1,
                'hinhAnh' => '',
            ]);
            $hinhAnh->save();
            $hinhAnh->hinhAnh = Storage::disk('public')->put('images', $request->file('hinhAnh'));
        } else {
            $hinhAnh->fill([
                'idDiaDanh' => $request->input('idDiaDanh'),
                'idBaiVietChiaSe' => 1,
                'idLoai' => 1,
                'hinhAnh' => $hinhAnh->hinhAnh,
            ]);
        }
        $hinhAnh->save();
        $lstDiaDanh = DiaDanh::all();
        return view('hinhanh.create-hinhanh', ['lstDiaDanh' => $lstDiaDanh]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HinhAnh  $hinhAnh
     * @return \Illuminate\Http\Response
     */
    public function destroy(HinhAnh $hinhAnh)
    {
        Storage::disk('public')->delete($hinhAnh->hinhAnh);
        $hinhAnh->delete();
        return Redirect::route('hinhAnh.index');
    }
}
