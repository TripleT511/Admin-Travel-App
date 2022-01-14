<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LuuTru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LuuTruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function fixImage(LuuTru $hinhAnh)
    {
        if (Storage::disk('public')->exists($hinhAnh->hinhAnh)) {
            $hinhAnh->hinhAnh = $hinhAnh->hinhAnh;
        } else {
            $hinhAnh->hinhAnh = 'images/no-image-available.jpg';
        }
    }
    public function index($id)
    {
        $lstLuuTru = LuuTru::where('dia_danh_id', '=', $id)->get();
        foreach ($lstLuuTru as $item) {
            $this->fixImage($item);
        }
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
        foreach ($LuuTru as $item) {
            $this->fixImage($item);
        }
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
