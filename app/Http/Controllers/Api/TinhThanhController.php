<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TinhThanh;
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
        $lstTinhThanh = TinhThanh::all();
        return response()->json([
            'data' => $lstTinhThanh,

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TinhThanh  $tinhThanh
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lstTinhThanh = TinhThanh::whereId($id)->with('diadanhs:id,tenDiaDanh,moTa,kinhDo,viDo,tinh_thanh_id,trangThai')->get();
        return response()->json([
            'data' => $lstTinhThanh,

        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TinhThanh  $tinhThanh
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TinhThanh $tinhThanh)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TinhThanh  $tinhThanh
     * @return \Illuminate\Http\Response
     */
    public function destroy(TinhThanh $tinhThanh)
    {
        //
    }
}
