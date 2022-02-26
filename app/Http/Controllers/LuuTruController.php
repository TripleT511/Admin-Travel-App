<?php

namespace App\Http\Controllers;

use App\Models\DiaDanh;
use App\Models\LuuTru;
use App\Models\MonAn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class LuuTruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function fixImage(LuuTru $hinhAnh)
    {
        if (Storage::disk('public')->exists($hinhAnh->hinhAnh)) {
            $hinhAnh->hinhAnh = $hinhAnh->hinhAnh;
        } else {
            $hinhAnh->hinhAnh = 'images/no-image-available.jpg';
        }
    }
    public function index()
    {
        $lstLuuTru = LuuTru::with('diadanh')->paginate(5);
        return view('luutru.index-luutru', ['lstLuuTru' => $lstLuuTru]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lstDiaDanh = DiaDanh::all();
        $lstLuuTru = LuuTru::all();
        return view('luutru.create-luutru', ['lstLuuTru' => $lstLuuTru, 'lstDiaDanh' => $lstDiaDanh]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'tenLuuTru' => 'required',
            'moTa' => 'required',
            'diaChi' => 'required',
            'sdt' => 'required',
            'hinhAnh' => 'required',
        ], [
            'tenLuuTru.required' => "Tên lưu trú không được bỏ trống",
            'moTa.required' => 'Mô tả không được bỏ trống',
            'diaChi.required' => 'Địa không được bỏ trống',
            'sdt.required' => 'SĐT không được bỏ trống',
            'hinhAnh.required' => 'Bắt buộc chọn hình ảnh'
        ]);


        $luuTru = new Luutru();
        $luuTru->fill([
            'dia_danh_id' => $request->input('dia_danh_id'),
            'tenLuuTru' => $request->input('tenLuuTru'),
            'moTa' => $request->input('moTa'),
            'diaChi' => $request->input('diaChi'),
            'sdt' => $request->input('sdt'),
            'thoiGianHoatDong' => $request->input('thoiGianHoatDong'),
            'hinhAnh' => '',

        ]);
        $luuTru->save();

        if ($request->hasFile('hinhAnh')) {
            $luuTru->hinhAnh = Storage::disk('public')->put('images', $request->file('hinhAnh'));
        }
        $luuTru->save();


        return Redirect::route('luuTru.index', ['luuTru' => $luuTru]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LuuTru  $luuTru
     * @return \Illuminate\Http\Response
     */
    public function show(LuuTru $luuTru)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LuuTru  $luuTru
     * @return \Illuminate\Http\Response
     */
    public function edit(LuuTru $luuTru)
    {
        $lstLuuTru = LuuTru::all();
        $lstDiaDanh = DiaDanh::all();
        // echo $luuTru;
        // echo $lstDiaDanh;
        // echo $lstLuuTru
        return view('luutru.edit-luutru', ['luuTru' => $luuTru, 'lstLuuTru' => $lstLuuTru, 'lstDiaDanh' => $lstDiaDanh]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LuuTru  $luuTru
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LuuTru $luuTru)
    {
        $request->validate([
            'tenLuuTru' => 'required',
            'moTa' => 'required',
            'diaChi' => 'required',
            'sdt' => 'required',
        ], [
            'tenLuuTru.required' => "Tên lưu trú không được bỏ trống",
            'moTa.required' => 'Mô tả không được bỏ trống',
            'diaChi.required' => 'Địa không được bỏ trống',
            'sdt.required' => 'SĐT không được bỏ trống',
        ]);

        if ($request->hasFile('hinhAnh')) {
            Storage::disk('public')->delete($luuTru->hinhAnh);
            $luuTru->hinhAnh = Storage::disk('public')->put('images', $request->file('hinhAnh'));
            $luuTru->save();
        }


        $luuTru->fill([
            'dia_danh_id' => $request->input('dia_danh_id'),
            'tenLuuTru' => $request->input('tenLuuTru'),
            'moTa' => $request->input('moTa'),
            'diaChi' => $request->input('diaChi'),
            'sdt' => $request->input('sdt'),
            'thoiGianHoatDong' => $request->input('thoiGianHoatDong'),

        ]);
        $luuTru->save();



        return Redirect::route('luuTru.index', ['luuTru' => $luuTru]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LuuTru  $luuTru
     * @return \Illuminate\Http\Response
     */
    public function destroy(LuuTru $luuTru)
    {
        Storage::disk('public')->delete($luuTru->hinhAnh);
        $luuTru->delete();
        return Redirect::route('luuTru.index');
    }

    public function timKiemLuuTru(Request $request)
    {
        $output = "";
        $lstLuuTru = LuuTru::with('diadanh')->paginate(5);
        if ($request->input('txtSearch') != "") {
            $lstLuuTru = LuuTru::where('tenLuuTru', 'LIKE', '%' . $request->input('txtSearch') . '%')->with('diadanh')->paginate(5);
        }
        foreach ($lstLuuTru as $item) {
            $output .= '<tr>
                    <td>' . $item->id . '</td>                                
                    <td>' . $item->diadanh->tenDiaDanh . '</td>
                    <td>
                            ' . $item->tenLuuTru . '
                    </td>      
                     <td>
                            ' . $item->moTa . '
                    </td>  
                     <td>
                            ' . $item->diaChi . '
                    </td>  
                     <td>
                            ' . $item->sdt . '
                    </td>  
                     <td>
                            ' . $item->thoiGianHoatDong . '
                    </td>         
                    <td>
                    <img width="150" src="' . ($item->hinhAnh != null ? asset($item->hinhAnh) : asset("/images/no-image-available.jpg"))
                . '"  />
                    </td>        
                    <td>
                        <label class="badge badge-primary">
                                <a class="d-block text-light" href="' . route('luuTru.edit', ['luuTru' => $item]) . '"> Sửa</a>
                        </label>
                        <label>
                            <form method="post" action="' . route('luuTru.destroy', ['luuTru' => $item]) . '">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <button style="outline: none; border: none" class="badge badge-danger"
                                    type="submit">Xoá</button>
                            </form>
                        </label>
                    </td>

                </tr>';
        }
        return response()->json($output);
    }
}
