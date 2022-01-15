<?php

namespace App\Http\Controllers;

use App\Models\DiaDanh;
use App\Http\Requests\StoreDiaDanhRequest;
use App\Http\Requests\UpdateDiaDanhRequest;
use App\Models\BaiVietChiaSe;
use App\Models\HinhAnh;
use App\Models\TinhThanh;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class DiaDanhController extends Controller
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
        $lstDiaDanh = DiaDanh::with('tinhthanh:id,tenTinhThanh')->with(['hinhanh' => function ($query) {
            $query->where('idLoai', '=', 1)->orderBy('created_at');
        }])->withCount('shares')->get();
        foreach ($lstDiaDanh as $item) {
            $this->fixImage($item->hinhanh);
        }
        return view('diadanh.index-diadanh', ['lstDiaDanh' => $lstDiaDanh]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lstTinhThanh = TinhThanh::all();
        return view('diadanh.create-diadanh', ['lstTinhThanh' => $lstTinhThanh]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDiaDanhRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDiaDanhRequest $request)
    {
        $request->validate([
            'tenDiaDanh' => 'required|unique:dia_danhs',
            'moTa' => 'required',
            'kinhDo' => 'required',
            'viDo' => 'required',
            'hinhAnh' => 'required',
        ], [
            'tenDiaDanh.required' => "Tên địa danh không được bỏ trống",
            'tenDiaDanh.unique' => "Tên địa danh bị trùng",
            'moTa.required' => 'Mô tả không được bỏ trống',
            'kinhDo.required' => 'Kinh độ không được bỏ trống',
            'viDo.required' => 'Vĩ độ không được bỏ trống',
            'hinhAnh.required' => 'Bắt buộc chọn hình ảnh'
        ]);
        $trangThai = 1;
        if ($request->input('trangThai') != "on") {
            $trangThai = 0;
        }
        $diadanh = new DiaDanh();
        $diadanh->fill([
            'tenDiaDanh' => $request->input('tenDiaDanh'),
            'moTa' => $request->input('moTa'),
            'kinhDo' => $request->input('kinhDo'),
            'viDo' => $request->input('viDo'),
            'tinh_thanh_id' => $request->input('idTinhThanh'),
            'trangThai' => $trangThai
        ]);
        $diadanh->save();

        $hinhAnh = new HinhAnh();

        $hinhAnh->fill([
            'idDiaDanh' => $diadanh->id,
            'idLoai' => 1,
            'hinhAnh' => '',
        ]);
        $hinhAnh->save();
        if ($request->hasFile('hinhAnh')) {
            $hinhAnh->hinhAnh = Storage::disk('public')->put('images', $request->file('hinhAnh'));
        }
        $hinhAnh->save();

        return Redirect::route('diaDanh.show', ['diaDanh' => $diadanh]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DiaDanh  $diaDanh
     * @return \Illuminate\Http\Response
     */
    public function show(DiaDanh $diaDanh)
    {
        return view('diadanh.show-diadanh', ['diaDanh' => $diaDanh]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DiaDanh  $diaDanh
     * @return \Illuminate\Http\Response
     */
    public function edit(DiaDanh $diaDanh)
    {
        $lstTinhThanh = TinhThanh::all();
        $hinhAnh = HinhAnh::where([['idDiaDanh', '=', $diaDanh->id], ['idLoai', '=', '1']])->orderBy('created_at', 'desc')->first();
        return view('diadanh.edit-diadanh', ['diaDanh' => $diaDanh, 'lstTinhThanh' => $lstTinhThanh, 'hinhAnh' => $hinhAnh]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDiaDanhRequest  $request
     * @param  \App\Models\DiaDanh  $diaDanh
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDiaDanhRequest $request, DiaDanh $diaDanh)
    {
        $request->validate([
            'tenDiaDanh' => 'required',
            'moTa' => 'required',
            'kinhDo' => 'required',
            'viDo' => 'required',
        ], [
            'tenDiaDanh.required' => "Tên địa danh không được bỏ trống",
            'tenDiaDanh.unique' => "Tên địa danh bị trùng",
            'moTa.required' => 'Mô tả không được bỏ trống',
            'kinhDo.required' => 'Kinh độ không được bỏ trống',
            'viDo.required' => 'Vĩ độ không được bỏ trống',
        ]);
        $trangThai = 1;
        if ($request->input('trangThai') != "on") {
            $trangThai = 0;
        }
        $diaDanh->fill([
            'tenDiaDanh' => $request->input('tenDiaDanh'),
            'moTa' => $request->input('moTa'),
            'kinhDo' => $request->input('kinhDo'),
            'viDo' => $request->input('viDo'),
            'tinh_thanh_id' => $request->input('idTinhThanh'),
            'trangThai' => $trangThai
        ]);
        $diaDanh->save();
        if ($request->hasFile('hinhAnh')) {
            $hinhAnh = HinhAnh::where('idDiaDanh', '=', $diaDanh->id)->orderBy('created_at', 'desc')->first();
            $hinhAnh->hinhAnh = Storage::disk('public')->put('images', $request->file('hinhAnh'));
            $hinhAnh->save();
        }

        return Redirect::route('diaDanh.show', ['diaDanh' => $diaDanh]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DiaDanh  $diaDanh
     * @return \Illuminate\Http\Response
     */
    public function destroy(DiaDanh $diaDanh)
    {
        $hinhAnh = HinhAnh::where('idDiaDanh', '=', $diaDanh->id);
        $baiViet = BaiVietChiaSe::where('idDiaDanh', '=', $diaDanh->id);
        $baiViet->delete();
        $hinhAnh->delete();
        $diaDanh->delete();
        return Redirect::route('diaDanh.index');
    }
}
