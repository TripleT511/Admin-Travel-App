<?php

namespace App\Http\Controllers;

use App\Models\TinhThanh;
use App\Http\Requests\StoreTinhThanhRequest;
use App\Http\Requests\UpdateTinhThanhRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;


class TinhThanhController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $lstTinhThanh = TinhThanh::paginate(5);
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
                'tenTinhThanh.required' => "Tên tỉnh thành không được bỏ trống",
                'tenTinhThanh.unique' => "Tỉnh thành đã tồn tại"
            ]
        );

        $tinhThanh = new TinhThanh();
        $tinhThanh->fill([
            'tenTinhThanh' => $request->input('tenTinhThanh'),
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
        return view('tinhthanh.show-tinhthanh', ['tinhThanh' => $tinhThanh]);
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

        $tinhThanh->fill([
            'tenTinhThanh' => $request->input('tenTinhThanh'),
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

    public function timKiemTinhThanh(Request $request)
    {
        $output = "";
        $lstTinhThanh = TinhThanh::paginate(5);
        if ($request->input('txtSearch') != "") {
            $lstTinhThanh = TinhThanh::where('tenTinhThanh', 'LIKE', '%' . $request->input('txtSearch') . '%')->paginate(5);
        }
        foreach ($lstTinhThanh as $item) {
            $output .= '<tr>
                            <td>' . $item->id . '</td>                                
                            
                            <td>
                                    ' . $item->tenTinhThanh . '
                            </td>             
                                            
                            <td>
                                <label class="badge badge-primary">
                                        <a class="d-block text-light" href="' . route('tinhThanh.edit', ['tinhThanh' => $item]) . '"> Sửa</a>
                                </label>
                                <label>
                                    <form method="post" action="' . route('tinhThanh.destroy', ['tinhThanh' => $item]) . '">
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
