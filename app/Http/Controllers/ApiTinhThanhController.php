<?php

namespace App\Http\Controllers;

use App\Models\TinhThanh;
use Illuminate\Http\Request;

class ApiTinhThanhController extends Controller
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
        $lstDiaDanh = TinhThanh::with('diadanhs:id,tenDiaDanh')->get();

        return $lstDiaDanh;
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
