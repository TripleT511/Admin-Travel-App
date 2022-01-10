<?php

namespace App\Http\Controllers;

use App\Models\DiaDanh;
use App\Models\HinhAnh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiDiaDanhController extends Controller
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

        $lstDiaDanh = DiaDanh::with('tinhthanh:id,tenTinhThanh')->with(['hinhanh' => function ($query) {
            $query->where('idLoai', '=', 1)->select('id', 'idDiaDanh', 'hinhAnh', 'idBaiVietChiaSe', 'idLoai')->orderBy('created_at');
        }])->get();
        foreach ($lstDiaDanh as $item) {
            $this->fixImage($item->hinhanh);
        }
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
    public function show($id)
    {
        // $diaDanh = DiaDanh::where('trangThai', '=', '1')->whereId($id)->with('tinhthanh:id,tenTinhThanh', 'hinhanh:id,hinhAnh,idBaiVietChiaSe,idLoai')->get();
        $diaDanh = DiaDanh::whereId($id)->with('tinhthanh:id,tenTinhThanh')->with(['hinhanhs' => function ($query) {
            $query->where('idLoai', '=', 1)->select('id', 'idDiaDanh', 'hinhAnh', 'idBaiVietChiaSe', 'idLoai')->orderBy('created_at');
        }])->get();
        foreach ($diaDanh as $item) {
            foreach ($item->hinhanhs as $img) {
                $this->fixImage($img);
            }
        }
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
