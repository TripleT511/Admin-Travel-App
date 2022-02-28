<?php

namespace App\Http\Controllers;

use App\Models\DiaDanhNhuCau;
use App\Http\Requests\StoreDiaDanhNhuCauRequest;
use App\Http\Requests\UpdateDiaDanhNhuCauRequest;
use App\Models\DiaDanh;
use App\Models\NhuCau;
use App\Models\TinhThanh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DiaDanhNhuCauController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lstDiaDanhNhuCau = DiaDanhNhuCau::with(['diadanh', 'nhucau'])->paginate(5);

        return view('diadanhnhucau.index-diadanhnhucau', ['lstDiaDanhNhuCau' => $lstDiaDanhNhuCau]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lstNhuCau = NhuCau::all();
        $lstDiaDanh = DiaDanh::all();
        return view('diadanhnhucau.create-diadanhnhucau', ['lstNhuCau' => $lstNhuCau, 'lstDiaDanh' => $lstDiaDanh]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDiaDanhNhuCauRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDiaDanhNhuCauRequest $request)
    {


        $dd = DiaDanhNhuCau::where([['idDiaDanh', $request->input('idDiaDanh')], ['idNhuCau', $request->input('idNhuCau')]])->count();

        if ($dd != 0) {
            return redirect()->back()->with('error', 'Nhu cầu của địa danh này đã tồn tại');
        }

        $diadanhnhucau = new DiaDanhNhuCau();
        $diadanhnhucau->fill([
            'idDiaDanh' => $request->input('idDiaDanh'),
            'idNhuCau' => $request->input('idNhuCau'),

        ]);
        $diadanhnhucau->save();
        return Redirect::route('diaDanhNhuCau.show', ['diaDanhNhuCau' => $diadanhnhucau::with(['diadanh', 'nhucau'])->first()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DiaDanhNhuCau  $diaDanhNhuCau
     * @return \Illuminate\Http\Response
     */
    public function show(DiaDanhNhuCau $diaDanhNhuCau)
    {
        return view('diadanhnhucau.show-diadanhnhucau', ['diaDanhNhuCau' => $diaDanhNhuCau]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DiaDanhNhuCau  $diaDanhNhuCau
     * @return \Illuminate\Http\Response
     */
    public function edit(DiaDanhNhuCau $diaDanhNhuCau)
    {
        $lstNhuCau = NhuCau::all();
        $lstDiaDanh = DiaDanh::all();
        return view('diadanhnhucau.edit-diadanhnhucau', ['diaDanhNhuCau' => $diaDanhNhuCau, 'lstNhuCau' => $lstNhuCau, 'lstDiaDanh' => $lstDiaDanh]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDiaDanhNhuCauRequest  $request
     * @param  \App\Models\DiaDanhNhuCau  $diaDanhNhuCau
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDiaDanhNhuCauRequest $request, DiaDanhNhuCau $diaDanhNhuCau)
    {

        $dd = DiaDanhNhuCau::where([['idDiaDanh', $request->input('idDiaDanh')], ['idNhuCau', $request->input('idNhuCau')]])->count();

        if ($dd != 0) {
            return redirect()->back()->with('error', 'Nhu cầu của địa danh này đã tồn tại');
        }

        $diaDanhNhuCau->fill([
            'idDiaDanh' => $request->input('idDiaDanh'),
            'idNhuCau' => $request->input('idNhuCau'),

        ]);
        $diaDanhNhuCau->save();
        return Redirect::route('diaDanhNhuCau.show', ['diaDanhNhuCau' => $diaDanhNhuCau]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DiaDanhNhuCau  $diaDanhNhuCau
     * @return \Illuminate\Http\Response
     */
    public function destroy(DiaDanhNhuCau $diaDanhNhuCau)
    {
        $diaDanhNhuCau->delete();
        return Redirect::route('diaDanhNhuCau.index');
    }

    public function timKiem(Request $request)
    {
        $output = "";
        $loai = $request->input('loai') == null ? 1 : $request->input('loai');
        $ten = $request->input('noiDung');
        $lstDiaDanhNhuCau = DiaDanhNhuCau::with(['diadanh', 'nhucau'])->paginate(5);
        if ($loai == 1) {
            $lstDiaDanhNhuCau = DiaDanhNhuCau::with(['diadanh', 'nhucau'])->whereHas('diadanh', function ($query) use ($ten) {
                $query->where('tenDiaDanh', 'LIKE', '%' . $ten . '%');
            })->paginate(5);
        } else {
            $lstDiaDanhNhuCau = DiaDanhNhuCau::with(['diadanh', 'nhucau'])->whereHas('nhucau', function ($query) use ($ten) {
                $query->where('tenNhuCau', 'LIKE', '%' . $ten . '%');
            })->paginate(5);
        }
        foreach ($lstDiaDanhNhuCau as $item) {
            $output .= '<tr>
                            <td>' . $item->id . '</td>                                
                            <td>
                                    ' . $item->diadanh->tenDiaDanh . '
                            </td>             
                              <td>
                                    ' . $item->nhucau->tenNhuCau . '
                            </td>              
                            <td>
                                <label class="badge badge-primary">
                                        <a class="d-block text-light" href="' . route('diaDanhNhuCau.edit', ['diaDanhNhuCau' => $item]) . '"> Sửa</a>
                                </label>
                                <label>
                                    <form method="post" action="' . route('diaDanhNhuCau.destroy', ['diaDanhNhuCau' => $item]) . '">
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
