<?php

namespace App\Http\Controllers;

use App\Models\TinhThanh;
use App\Http\Requests\StoreTinhThanhRequest;
use App\Http\Requests\UpdateTinhThanhRequest;
use Illuminate\Support\Facades\Redirect;

class TinhThanhController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $lstTinhThanh = TinhThanh::all();
        return view('tinhthanh.index-tinhthanh', ['lstTinhThanh' => $lstTinhThanh]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tinhthanh.create-tinhthanh');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTinhThanhRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTinhThanhRequest $request)
    {
        $request->validate(
            [
                'tenTinhThanh' => 'required|unique:tinh_thanhs',
            ],
            [
                'tenTinhThanh.required' => "Tên tỉnh thành không được bỏ trống"
            ]
        );
        $trangThai = 1;
        if ($request->input('trangThai') != "on") {
            $trangThai = 0;
        }
        $tinhThanh = new TinhThanh();
        $tinhThanh->fill([
            'tenTinhThanh' => $request->input('tenTinhThanh'),
            'trangThai' => $trangThai
        ]);
        $tinhThanh->save();
        return Redirect::route('tinhThanh.show', ['tinhThanh' => $tinhThanh]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TinhThanh  $tinhThanh
     * @return \Illuminate\Http\Response
     */
    public function show(TinhThanh $tinhThanh)
    {
        return view('tinhthanh.show-tinhThanh', ['tinhThanh' => $tinhThanh]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TinhThanh  $tinhThanh
     * @return \Illuminate\Http\Response
     */
    public function edit(TinhThanh $tinhThanh)
    {
        return view('tinhthanh.edit-tinhthanh', ['tinhThanh' => $tinhThanh]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTinhThanhRequest  $request
     * @param  \App\Models\TinhThanh  $tinhThanh
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTinhThanhRequest $request, TinhThanh $tinhThanh)
    {
        $request->validate(
            [
                'tenTinhThanh' => 'required',
            ],
            [
                'tenTinhThanh.required' => "Tên tỉnh thành không được bỏ trống"
            ]
        );
        $trangThai = 1;
        if ($request->input('trangThai') != "on") {
            $trangThai = 0;
        }
        $tinhThanh->fill([
            'tenTinhThanh' => $request->input('tenTinhThanh'),
            'trangThai' => $trangThai
        ]);
        $tinhThanh->save();
        return Redirect::route('tinhThanh.show', ['tinhThanh' => $tinhThanh]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TinhThanh  $tinhThanh
     * @return \Illuminate\Http\Response
     */
    public function destroy(TinhThanh $tinhThanh)
    {
        $tinhThanh->delete();
        return Redirect::route('tinhThanh.index');
    }
}
