<?php

namespace App\Http\Controllers;

use App\Models\MonAn;
use App\Http\Requests\StoreMonAnRequest;
use App\Http\Requests\UpdateMonAnRequest;
use App\Models\QuanAn;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class MonAnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function fixImage(MonAn $hinhAnh)
    {
        if (Storage::disk('public')->exists($hinhAnh->hinhAnh)) {
            $hinhAnh->hinhAnh = $hinhAnh->hinhAnh;
        } else {
            $hinhAnh->hinhAnh = 'images/no-image-available.jpg';
        }
    }
    public function index()
    {
        $lstMonAn = MonAn::with('quanan')->where('trangThai', '==', 1)->get();

        return view('monan.index-monan', ['lstMonAn' => $lstMonAn]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lstQuanAn = QuanAn::all();
        $lstMonAn = MonAn::all();
        return view('monan.create-monan', ['lstQuanAn' => $lstQuanAn, 'lstMonAn' => $lstMonAn]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMonAnRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMonAnRequest $request)
    {
        $request->validate([
            'tenMon' => 'required',
            'hinhAnh' => 'required',
        ], [
            'tenMon.required' => "Tên món ăn không được bỏ trống",
            'hinhAnh.required' => 'Bắt buộc chọn hình ảnh'
        ]);

        $trangThai = 1;
        if ($request->input('trangThai') != "on") {
            $trangThai = 0;
        }
        $monAn = new MonAn();
        $monAn->fill([
            'quan_an_id' => $request->input('quan_an_id'),
            'tenMon' => $request->input('tenMon'),
            'hinhAnh' => '',
            'trangThai' => 1
        ]);
        $monAn->save();

        if ($request->hasFile('hinhAnh')) {
            $monAn->hinhAnh = Storage::disk('public')->put('images', $request->file('hinhAnh'));
        }
        $monAn->save();

        return Redirect::route('monAn.index', ['monAn' => $monAn]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MonAn  $monAn
     * @return \Illuminate\Http\Response
     */
    public function show(MonAn $monAn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MonAn  $monAn
     * @return \Illuminate\Http\Response
     */
    public function edit(MonAn $monAn)
    {
        $lstQuanAn = QuanAn::all();
        $lstMonAn = MonAn::all();
        return view('monan.edit-monan', ['monAn' => $monAn, 'lstMonAn' => $lstMonAn, 'lstQuanAn' => $lstQuanAn]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMonAnRequest  $request
     * @param  \App\Models\MonAn  $monAn
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMonAnRequest $request, MonAn $monAn)
    {
        $request->validate([
            'tenMon' => 'required',
        ], [
            'tenMon.required' => "Tên món ăn không được bỏ trống",
        ]);

        if ($request->hasFile('hinhAnh')) {
            $monAn->hinhAnh = Storage::disk('public')->put('images', $request->file('hinhAnh'));
        }
        $monAn->save();

        $trangThai = 1;
        if ($request->input('trangThai') != "on") {
            $trangThai = 0;
        }
        $monAn->fill([
            'quan_an_id' => $request->input('quan_an_id'),
            'tenMon' => $request->input('tenMon'),
            'trangThai' => $trangThai
        ]);
        $monAn->save();
        return Redirect::route('monAn.index', ['monAn' => $monAn]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MonAn  $monAn
     * @return \Illuminate\Http\Response
     */
    public function destroy(MonAn $monAn)
    {
        $monAn->delete();
        return Redirect::route('monAn.index');
    }
}
