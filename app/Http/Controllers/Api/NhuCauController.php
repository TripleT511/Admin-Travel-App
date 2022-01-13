<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NhuCau;
use Illuminate\Http\Request;

class NhuCauController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
    public function show(NhuCau $nhuCau)
    {
        //
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
