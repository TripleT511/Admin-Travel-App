<?php

namespace App\Http\Controllers;

use App\Models\DiaDanhNhuCau;
use App\Http\Requests\StoreDiaDanhNhuCauRequest;
use App\Http\Requests\UpdateDiaDanhNhuCauRequest;
use App\Models\DiaDanh;
use App\Models\NhuCau;
use Illuminate\Support\Facades\Redirect;

class DiaDanhNhuCauController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lstDiaDanhNhuCau = DiaDanhNhuCau::with(['diadanh', 'nhucau'])->paginate(5);
        return view('diadanhnhucau.index-diadanhnhucau', ['lstDiaDanhNhuCau' => $lstDiaDanhNhuCau]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lstNhuCau = NhuCau::all();
        $lstDiaDanh = DiaDanh::all();
        return view('diadanhnhucau.create-diadanhnhucau', ['lstNhuCau' => $lstNhuCau, 'lstDiaDanh' => $lstDiaDanh]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDiaDanhNhuCauRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDiaDanhNhuCauRequest $request)
    {
        $lstDiaDanh = DiaDanh::all();
        $lstNhuCau = NhuCau::all();

        $diadanhnhucau = new DiaDanhNhuCau();
        $diadanhnhucau->fill([
            'idDiaDanh' => $request->input('idDiaDanh'),
            'idNhuCau' => $request->input('idNhuCau'),

        ]);
        $diadanhnhucau->save();
        return Redirect::route('diaDanhNhuCau.show', ['diaDanhNhuCau' => $diadanhnhucau, 'lstDiaDanh' => $lstDiaDanh, 'lstNhuCau' => $lstNhuCau]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DiaDanhNhuCau  $diaDanhNhuCau
     * @return \Illuminate\Http\Response
     */
    public function show(DiaDanhNhuCau $diaDanhNhuCau)
    {
        return view('diadanhnhucau.show-diadanhnhucau', ['diaDanhNhuCau' => $diaDanhNhuCau]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DiaDanhNhuCau  $diaDanhNhuCau
     * @return \Illuminate\Http\Response
     */
    public function edit(DiaDanhNhuCau $diaDanhNhuCau)
    {
        $lstNhuCau = NhuCau::all();
        $lstDiaDanh = DiaDanh::all();
        return view('diadanhnhucau.edit-diadanhnhucau', ['diaDanhNhuCau' => $diaDanhNhuCau, 'lstNhuCau' => $lstNhuCau, 'lstDiaDanh' => $lstDiaDanh]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDiaDanhNhuCauRequest  $request
     * @param  \App\Models\DiaDanhNhuCau  $diaDanhNhuCau
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDiaDanhNhuCauRequest $request, DiaDanhNhuCau $diaDanhNhuCau)
    {

        $diaDanhNhuCau->fill([
            'idDiaDanh' => $request->input('idDiaDanh'),
            'idNhuCau' => $request->input('idNhuCau'),

        ]);
        $diaDanhNhuCau->save();
        return Redirect::route('diaDanhNhuCau.show', ['diaDanhNhuCau' => $diaDanhNhuCau]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DiaDanhNhuCau  $diaDanhNhuCau
     * @return \Illuminate\Http\Response
     */
    public function destroy(DiaDanhNhuCau $diaDanhNhuCau)
    {
        $diaDanhNhuCau->delete();
        return Redirect::route('diaDanhNhuCau.index');
    }
}
