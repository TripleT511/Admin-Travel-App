<?php

namespace App\Http\Controllers;

use App\Models\DeXuatDiaDanh;
use App\Http\Requests\StoreDeXuatDiaDanhRequest;
use App\Http\Requests\UpdateDeXuatDiaDanhRequest;
use App\Models\DiaDanh;
use App\Models\HinhAnh;
use App\Models\TinhThanh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class DeXuatDiaDanhController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function fixImage(DeXuatDiaDanh $hinhAnh)
    {
        if (Storage::disk('public')->exists($hinhAnh->hinhAnh)) {
            $hinhAnh->hinhAnh = $hinhAnh->hinhAnh;
        } else {
            $hinhAnh->hinhAnh = 'images/no-image-available.jpg';
        }
    }

    public function index()
    {
        $lstDeXuat = DeXuatDiaDanh::withTrashed()->paginate(5);
        foreach ($lstDeXuat as $item) {
            $this->fixImage($item);
        }


        return view('dexuat.index-dexuat', ['lstDeXuat' => $lstDeXuat]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lstTinhThanh = TinhThanh::all();

        return view('dexuat.create-dexuat', ['lstTinhThanh' => $lstTinhThanh]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDeXuatDiaDanhRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDeXuatDiaDanhRequest $request)
    {
        $request->validate([
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


        // Thêm địa danh
        $deXuat = new DeXuatDiaDanh();
        $deXuat->fill([
            'tenDiaDanh' => $request->input('tenDiaDanh'),
            'moTa' => $request->input('moTa'),
            'kinhDo' => $request->input('kinhDo'),
            'viDo' => $request->input('viDo'),
            'tinh_thanh_id' => $request->input('idTinhThanh'),
            'user_id' => Auth::user()->id,
            'hinhAnh' => '',
            'trangThai' => 0,
        ]);
        $deXuat->save();

        // // Thêm hình ảnh
        if ($request->hasFile('hinhAnh')) {
            $deXuat->hinhAnh = Storage::disk('public')->put('images', $request->file('hinhAnh'));
        }
        $deXuat->save();

        $lstDeXuat = DeXuatDiaDanh::paginate(5);

        foreach ($lstDeXuat as $item) {
            $this->fixImage($item);
        }

        return view('dexuat.index-dexuat', ['lstDeXuat' => $lstDeXuat]);
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeXuatDiaDanh  $deXuatDiaDanh
     * @return \Illuminate\Http\Response
     */
    public function edit(DeXuatDiaDanh $deXuatDiaDanh)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDeXuatDiaDanhRequest  $request
     * @param  \App\Models\DeXuatDiaDanh  $deXuatDiaDanh
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDeXuatDiaDanhRequest $request, DeXuatDiaDanh $deXuat)
    {
        $diadanh = new DiaDanh();
        $diadanh->fill([
            'tenDiaDanh' => $deXuat->tenDiaDanh,
            'moTa' => $deXuat->moTa,
            'kinhDo' => $deXuat->kinhDo,
            'viDo' => $deXuat->viDo,
            'tinh_thanh_id' => $deXuat->tinh_thanh_id,
        ]);
        $diadanh->save();

        $hinhAnh = new HinhAnh();

        $hinhAnh->fill([
            'idDiaDanh' => $diadanh->id,
            'idLoai' => 1,
            'hinhAnh' => $deXuat->hinhAnh,
        ]);

        $hinhAnh->save();

        $deXuat->trangThai = 1;
        $deXuat->update();

        $lstDeXuat = DeXuatDiaDanh::paginate(5);

        foreach ($lstDeXuat as $item) {
            $this->fixImage($item);
        }

        return view('dexuat.index-dexuat', ['lstDeXuat' => $lstDeXuat]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeXuatDiaDanh  $deXuatDiaDanh
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeXuatDiaDanh $deXuat)
    {
        Storage::disk('public')->delete($deXuat->hinhAnh);
        $deXuat->delete();

        return Redirect::route('deXuat.index');
    }

    public function fillbv(Request $request)
    {
        $output = "";
        $lstDiaDanh = DeXuatDiaDanh::with('user')->with('tinhthanh')->orderBy('id')->paginate(5);

        if ($request->input('fill') != "" && $request->input('fill') == 1) {
            $lstDiaDanh = DeXuatDiaDanh::with('tinhthanh')->with('user')->where('trangThai', '=', 0)->orderBy('id')->paginate(5);
        }
        if ($request->input('fill') != "" && $request->input('fill') == 2) {
            $lstDiaDanh = DeXuatDiaDanh::with('tinhthanh')->with('user')->where('trangThai', '=', 1)->orderBy('id')->paginate(5);
        }
        if ($request->input('fill') != "" && $request->input('fill') == 3) {
            $lstDiaDanh = DeXuatDiaDanh::with('tinhthanh')->with('user')->onlyTrashed()->orderBy('id')->paginate(5);
        }
        foreach ($lstDiaDanh as $item) {
            $this->fixImage($item);

            $handle = '';
            if ($item->trangThai == 0 && $item->deleted_at == null) {
                $handle .= '  <label>
                <form method="post" action="' . route('deXuat.update', ['deXuat' => $item]) . '">
                <input type="hidden" name="_method" value="PATCH">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <button style="outline: none; border: none" class="badge badge-primary"
                        type="submit">Duyệt</button>
                </form>
            </label>
                    <label>
                    <label>
                    <form method="post" action="' . route('deXuat.destroy', ['deXuat' => $item]) . '">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <button style="outline: none; border: none" class="badge badge-danger"
                            type="submit">Xoá</button>
                    </form>
                </label>
                        
                    </label>';
            } elseif (
                $item->trangThai == 1  && $item->deleted_at == null
            ) {
                $handle .= ' <label class="badge badge-success">Đã duyệt</label>';
            } else {
                $handle .= '<label class="badge badge-danger">Đã xoá</label>';
            }
            $output .= '<tr>
                                <td>' . $item->id . '</td>
                                <td>
                                    <a href="' . route("show", ["id" => $item->id]) . '">
                                       ' . $item->tenDiaDanh . '
                                    </a>
                                </td>
                                <td>
                                ' . $item->user->hoTen . '
                                </td>
                                <td class="text-wrap cell-5">
                                ' . $item->moTa . '
                                </td>
                                <td>
                                ' . $item->kinhDo . '
                                </td>
                                <td>
                                ' . $item->viDo . '
                                </td>
                                <td>
                                    <img width="150" src="' . asset($item->hinhAnh)
                . '"  />
                                </td>
                                <td>
                                ' .  $item->tinhthanh->tenTinhThanh . '
                                </td>
                                <td>
                                ' . $item->shares_count . '
                                </td>
                                <td>
                                ' . $handle . '
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                            </td>

                            </tr>';
        }
        return response()->json($output);
    }
}
