<?php

namespace App\Http\Controllers;

use App\Models\DiaDanh;
use Illuminate\Http\Request;

class ApiDiaDanhController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lstDiaDanh = DiaDanh::with('tinhthanh:id,tenTinhThanh', 'hinhanh:id,hinhAnh')->get();

        return response()->json([
            'data' => $lstDiaDanh
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
     * @param  \App\Models\DiaDanh  $diaDanh
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $diaDanh = DiaDanh::where('trangThai', '=', '1')->whereId($id)->with('tinhthanh:id,tenTinhThanh', 'hinhanh:id,hinhAnh')->get();
        return response()->json([
            'diaDanh' => $diaDanh
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DiaDanh  $diaDanh
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DiaDanh $diaDanh)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DiaDanh  $diaDanh
     * @return \Illuminate\Http\Response
     */
    public function destroy(DiaDanh $diaDanh)
    {
        //
    }
}
