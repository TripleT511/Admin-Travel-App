<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LuuTru;
use Illuminate\Http\Request;

class LuuTruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $lstLuuTru = LuuTru::where('dia_danh_id', '=', $id)->get();

        return response()->json([
            'data' => $lstLuuTru
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
     * @param  \App\Models\LuuTru  $luuTru
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $LuuTru = LuuTru::whereId($id)->get();

        return response($LuuTru);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LuuTru  $luuTru
     * @return \Illuminate\Http\Response
     */
    public function destroy(LuuTru $luuTru)
    {
        //
    }
}
