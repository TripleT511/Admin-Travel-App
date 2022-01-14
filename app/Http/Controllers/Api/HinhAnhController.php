<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HinhAnh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HinhAnhController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function fixImage(HinhAnh $hinhAnh)
    {
        if (Storage::disk('public')->exists($hinhAnh->hinh_anh)) {
            $hinhAnh->hinh_anh = Storage::url($hinhAnh->hinh_anh);
        } else {
            $hinhAnh->hinh_anh = '/images/no-image-available.jpg';
        }
    }
    public function index()
    {
        //
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
     * @param  \App\Models\HinhAnh  $hinhAnh
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lstHinhAnh = HinhAnh::where('idDiaDanh', '=', $id)->get();
        return response()->json([
            'hinhAnh' => $lstHinhAnh
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HinhAnh  $hinhAnh
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HinhAnh $hinhAnh)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HinhAnh  $hinhAnh
     * @return \Illuminate\Http\Response
     */
    public function destroy(HinhAnh $hinhAnh)
    {
        //
    }
}
