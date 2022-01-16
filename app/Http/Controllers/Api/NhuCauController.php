<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HinhAnh;
use App\Models\NhuCau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NhuCauController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function fixImage(HinhAnh $hinhAnh)
    {
        if (Storage::disk('public')->exists($hinhAnh->hinhAnh)) {
            $hinhAnh->hinhAnh = $hinhAnh->hinhAnh;
        } else {
            $hinhAnh->hinhAnh = 'images/no-image-available.jpg';
        }
    }
    public function index()
    {
        $lstNhuCau = NhuCau::all();
        return response()->json([
            'data' => $lstNhuCau,

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
     * @param  \App\Models\NhuCau  $nhuCau
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lstNhuCau = NhuCau::whereId($id)->with('nhucaudiadanh.diadanh.tinhthanh:id,tenTinhThanh')->with('nhucaudiadanh.diadanh.hinhanh', function ($query) {
            $query->where('idLoai', '=', 1)->select('id', 'idDiaDanh', 'hinhAnh', 'idBaiVietChiaSe', 'idLoai')->orderBy('created_at');
        })->first();
        foreach ($lstNhuCau->nhucaudiadanh as $item) {
            $this->fixImage($item->diadanh->hinhanh);
        }

        return response()->json([
            'data' =>  $lstNhuCau
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NhuCau  $nhuCau
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NhuCau $nhuCau)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NhuCau  $nhuCau
     * @return \Illuminate\Http\Response
     */
    public function destroy(NhuCau $nhuCau)
    {
        //
    }
}
