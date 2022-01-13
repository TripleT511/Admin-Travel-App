<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\QuanAn;
use Illuminate\Http\Request;

class QuanAnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $lstQuanAn = QuanAn::where('dia_danh_id', '=', $id)->get();

        return response()->json([
            'data' => $lstQuanAn
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
     * @param  \App\Models\QuanAn  $quanAn
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $QuanAn = QuanAn::whereId($id)->with('monan')->get();

        return response($QuanAn);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuanAn  $quanAn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuanAn $quanAn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuanAn  $quanAn
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuanAn $quanAn)
    {
        //
    }
}
