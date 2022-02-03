<?php

namespace App\Http\Controllers;

use App\Models\NhuCau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class NhuCauController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lstNhuCau = NhuCau::paginate(5);
        return view('nhucau.index-nhucau', ['lstNhuCau' => $lstNhuCau]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('nhucau.create-nhucau');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'tenNhuCau' => 'required|unique:nhu_caus',
            ],
            [
                'tenNhuCau.required' => "Tên nhu cầu không được bỏ trống"
            ]
        );
        $trangThai = 1;
        if ($request->input('trangThai') != "on") {
            $trangThai = 0;
        }
        $nhuCau = new NhuCau();
        $nhuCau->fill([
            'tenNhuCau' => $request->input('tenNhuCau'),
            'trangThai' => $trangThai
        ]);
        $nhuCau->save();
        return Redirect::route('nhuCau.show', ['nhuCau' => $nhuCau]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NhuCau  $nhuCau
     * @return \Illuminate\Http\Response
     */
    public function show(NhuCau $nhuCau)
    {
        return view('nhucau.show-nhucau', ['nhuCau' => $nhuCau]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NhuCau  $nhuCau
     * @return \Illuminate\Http\Response
     */
    public function edit(NhuCau $nhuCau)
    {
        $lstNhuCau = NhuCau::all();
        return view('nhucau.edit-nhucau', ['nhuCau' => $nhuCau, 'lstNhuCau' => $lstNhuCau]);
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
        $request->validate(
            [
                'tenNhuCau' => 'required',
            ],
            [
                'tenNhuCau.required' => "Tên nhu cầu không được bỏ trống"
            ]
        );
        $trangThai = 1;
        if ($request->input('trangThai') != "on") {
            $trangThai = 0;
        }
        $nhuCau->fill([
            'tenNhuCau' => $request->input('tenNhuCau'),
            'trangThai' => $trangThai
        ]);
        $nhuCau->save();
        return Redirect::route('nhuCau.show', ['nhuCau' => $nhuCau]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NhuCau  $nhuCau
     * @return \Illuminate\Http\Response
     */
    public function destroy(NhuCau $nhuCau)
    {
        $nhuCau->delete();
        return Redirect::route('nhuCau.index');
    }
}
