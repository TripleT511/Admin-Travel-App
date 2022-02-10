<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BaiVietChiaSe;
use App\Models\DanhGia;
use App\Models\DiaDanh;
use App\Models\HinhAnh;
use App\Models\TinhThanh;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BaiVietChiaSeController extends Controller
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

    protected function fixImageUser(User $hinhAnh)
    {
        if (Storage::disk('public')->exists($hinhAnh->hinhAnh)) {
            $hinhAnh->hinhAnh = $hinhAnh->hinhAnh;
        } else {
            $hinhAnh->hinhAnh = 'images/user-default.jpg';
        }
    }
    public function index()
    {
        $baiViet = BaiVietChiaSe::with(['diadanh:id,tenDiaDanh,moTa,kinhDo,viDo,tinh_thanh_id', 'hinhanh:id,idDiaDanh,hinhAnh,idBaiVietChiaSe,idLoai', 'user'])->with(['user' => function ($query) {
            $query->withCount('baiviets')->withCount('tinhthanhs');
        }])->withCount(['islike' => function ($query) {
            $query->where([
                ['idUser', '=', auth()->user()->id,],
                ['userLike', '=', 1]
            ]);
        }])->withCount(['isdislike' => function ($query) {
            $query->where([
                ['idUser', '=', auth()->user()->id,],
                ['userUnLike', '=', 1]
            ]);
        }])->withCount(['likes' => function ($query) {
            $query->where('userLike', '=', 1);
        }])->withCount(['unlikes' => function ($query) {
            $query->where('userUnLike', '=', 1);
        }])->withCount(['views' => function ($query) {
            $query->where('userXem', '=', 1);
        }])->orderBy('created_at', 'desc')->get();



        foreach ($baiViet as $item) {
            $this->fixImage($item->hinhanh);

            $countTinhThanh = 0;
            $userTinhThanh = User::whereId($item->user->id)->with('tinhthanhs.diadanh')->first();
            foreach ($userTinhThanh->tinhthanhs->groupBy('diadanh.tinh_thanh_id') as $items) {

                $countTinhThanh++;
            }
            $item->user->tinhthanhs_count = $countTinhThanh;
            $this->fixImageUser($item->user);

            $item->thoiGian = date('d-m-Y', strtotime($item->thoiGian));
        }
        return response()->json([
            'data' => $baiViet
        ], 200);
    }

    public function baivietuser(Request $request, $id)
    {

        $baiViet = BaiVietChiaSe::with(['diadanh:id,tenDiaDanh,moTa,kinhDo,viDo,tinh_thanh_id', 'hinhanh:id,idDiaDanh,hinhAnh,idBaiVietChiaSe,idLoai', 'user'])->withCount(['likes' => function ($query) {
            $query->where('userLike', '=', 1);
        }])->withCount(['islike' => function ($query) {
            $query->where([
                ['idUser', '=', auth()->user()->id,],
                ['userLike', '=', 1]
            ]);
        }])->withCount(['isdislike' => function ($query) {
            $query->where([
                ['idUser', '=', auth()->user()->id,],
                ['userUnLike', '=', 1]
            ]);
        }])->withCount(['unlikes' => function ($query) {
            $query->where('userUnLike', '=', 1);
        }])->withCount(['views' => function ($query) {
            $query->where('userXem', '=', 1);
        }])->where('idUser', '=', $id)->orderBy('created_at', 'desc')->get();
        foreach ($baiViet as $item) {
            $this->fixImage($item->hinhanh);
            $this->fixImageUser($item->user);
            $item->thoiGian = date('d-m-Y', strtotime($item->thoiGian));
        }
        return response()->json([
            'data' => $baiViet
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
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'noiDung' => 'required',
                    'hinhAnh' => 'required',
                    'idUser' => 'required',
                    'idDiaDanh' => 'required',
                ],
                [
                    'noiDung.required' => 'Nội dung không được bỏ trống',
                    'hinhAnh.required' => "Bắt buộc chọn hình ảnh"
                ]
            );

            if ($validator->fails()) {
                return response([
                    'error' => $validator->errors()->all()
                ], 422);
            }

            $diaDanh = null;
            $tinhThanh = null;

            if ($request->has('tenTinhThanh')) {
                if (TinhThanh::where('tenTinhThanh', $request->tenTinhThanh)->count() > 0) {
                    $tinhThanh = TinhThanh::where('tenTinhThanh', $request->tenTinhThanh)->first();
                } else {
                    $tinhThanh = TinhThanh::create([
                        'tenTinhThanh' => $request->tenTinhThanh,
                    ]);
                }
            }

            if ($request->has('tenDiaDanh')) {
                if (DiaDanh::where('tenDiaDanh', $request->tenDiaDanh)->count() > 0) {
                    $diaDanh = DiaDanh::where('tenDiaDanh', $request->tenDiaDanh)->first();
                } else {
                    $diaDanh = DiaDanh::create([
                        'tenDiaDanh' => $request->tenDiaDanh,
                        'moTa' => "",
                        'kinhDo' => $request->kinhDo,
                        'viDo' => $request->viDo,
                        'tinh_thanh_id' => $tinhThanh->id,
                    ]);

                    $hinhAnh = new HinhAnh();

                    $hinhAnh->fill([
                        'idDiaDanh' => $diaDanh->id,
                        'idLoai' => 1,
                        'hinhAnh' => 'images/no-image-available.jpg',
                    ]);

                    $hinhAnh->save();
                }
            }

            $baiViet = new BaiVietChiaSe();
            $baiViet->fill([
                'idDiaDanh' => $request->has('tenDiaDanh') ? $diaDanh->id : $request->input('idDiaDanh'),
                'idUser' => $request->input('idUser'),
                'noiDung' => $request->input('noiDung'),
                'thoiGian' => Carbon::now()->toDateTimeString(),

            ]);
            $baiViet->save();

            $danhgia = new DanhGia();
            $danhgia->fill([
                'idBaiViet' => $baiViet->id,
                'idUser' => $request->user()->id,
                'userLike' => 0,
                'userUnLike' => 0,
                'userXem' => 0,
            ]);
            $danhgia->save();

            $hinhAnh = new HinhAnh();

            $hinhAnh->fill([
                'idDiaDanh' => $request->has('tenDiaDanh') ? $diaDanh->id : $request->input('idDiaDanh'),
                'idBaiVietChiaSe' => $baiViet->id,
                'idLoai' => 2,
                'hinhAnh' => '',
            ]);
            $hinhAnh->save();
            if ($request->hasFile('hinhAnh')) {
                $hinhAnh->hinhAnh = Storage::disk('public')->put('images', $request->file('hinhAnh'));
            }
            $hinhAnh->save();

            return response()->json([
                'status_code' => 200,
                'message' => 'Create Post Successfull',
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error in Create Post',
                'error' => $error,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BaiVietChiaSe  $baiVietChiaSe
     * @return \Illuminate\Http\Response
     */
    public function getBaiVietById($id)
    {
        try {
            $baiViet = BaiVietChiaSe::with(['diadanh:id,tenDiaDanh,moTa,kinhDo,viDo,tinh_thanh_id', 'hinhanh:id,idDiaDanh,hinhAnh,idBaiVietChiaSe,idLoai', 'user'])->with(['user' => function ($query) {
                $query->withCount('baiviets')->withCount('tinhthanhs');
            }])->withCount(['likes' => function ($query) {
                $query->where('userLike', '=', 1);
            }])->withCount(['islike' => function ($query) {
                $query->where([
                    ['idUser', '=', auth()->user()->id,],
                    ['userLike', '=', 1]
                ]);
            }])->withCount(['isdislike' => function ($query) {
                $query->where([
                    ['idUser', '=', auth()->user()->id,],
                    ['userUnLike', '=', 1]
                ]);
            }])->withCount(['unlikes' => function ($query) {
                $query->where('userUnLike', '=', 1);
            }])->withCount(['views' => function ($query) {
                $query->where('userXem', '=', 1);
            }])->where('id', '=', $id)->first();

            return response()->json(
                $baiViet,
                200
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    'message' => 'Có lỗi xảy ra',
                    'error' => $e,
                ],
                500
            );
        }
    }
    public function show()
    {
        $baiViet = BaiVietChiaSe::with(['diadanh:id,tenDiaDanh,moTa,kinhDo,viDo,tinh_thanh_id', 'hinhanh:id,idDiaDanh,hinhAnh,idBaiVietChiaSe,idLoai', 'user'])->with(['user' => function ($query) {
            $query->withCount('baiviets')->withCount('tinhthanhs');
        }])->withCount(['likes' => function ($query) {
            $query->where('userLike', '=', 1);
        }])->withCount(['islike' => function ($query) {
            $query->where([
                ['idUser', '=', auth()->user()->id,],
                ['userLike', '=', 1]
            ]);
        }])->withCount(['isdislike' => function ($query) {
            $query->where([
                ['idUser', '=', auth()->user()->id,],
                ['userUnLike', '=', 1]
            ]);
        }])->withCount(['unlikes' => function ($query) {
            $query->where('userUnLike', '=', 1);
        }])->withCount(['views' => function ($query) {
            $query->where('userXem', '=', 1);
        }])->orderBy('likes_count', 'desc')->take(5)->get();
        foreach ($baiViet as $item) {
            $this->fixImage($item->hinhanh);

            $countTinhThanh = 0;
            $userTinhThanh = User::whereId($item->user->id)->with('tinhthanhs.diadanh')->first();
            foreach ($userTinhThanh->tinhthanhs->groupBy('diadanh.tinh_thanh_id') as $items) {
                $countTinhThanh++;
            }
            $item->user->tinhthanhs_count = $countTinhThanh;

            $this->fixImageUser($item->user);
            $item->thoiGian = date('d-m-Y', strtotime($item->thoiGian));
        }
        return response()->json([
            'data' => $baiViet
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BaiVietChiaSe  $baiVietChiaSe
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, BaiVietChiaSe $baiVietChiaSe)
    public function update(Request $request, $id)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'noiDung' => 'required',
                ],
                [
                    'noiDung.required' => 'Nội dung không được bỏ trống',
                ]
            );

            if ($validator->fails()) {
                return response([
                    'error' => $validator->errors()->all()
                ], 422);
            }

            $baiViet = BaiVietChiaSe::find($id);
            $baiViet->fill([
                'idDiaDanh' => $baiViet->idDiaDanh,
                'idUser' => $baiViet->idUser,
                'noiDung' => $request->input('noiDung'),
                'thoiGian' => Carbon::now()->toDateTimeString(),

            ]);
            $baiViet->update();
            if ($request->hasFile('hinhAnh')) {
                $hinhAnh = HinhAnh::where('idBaiVietChiaSe', '=', $id)->first();
                Storage::disk('public')->delete($hinhAnh->hinhAnh);

                $hinhAnh->fill([
                    'idDiaDanh' => $baiViet->idDiaDanh,
                    'idBaiVietChiaSe' => $id,
                    'idLoai' => 2,
                    'hinhAnh' => '',
                ]);
                $hinhAnh->update();
                $hinhAnh->hinhAnh = Storage::disk('public')->put('images', $request->file('hinhAnh'));
                $hinhAnh->update();
            }


            return response()->json([
                'status_code' => 200,
                'message' => 'Update Post Successfull',
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error in Update Post',
                'error' => $error,
            ], 500);
        }
    }

    public function like(Request $request, $id)
    {

        $danhgia = DanhGia::where([
            ['idBaiViet', '=', $id],
            ['idUser', '=', $request->user()->id],
        ])->get();
        $isLike = count($danhgia);

        if ($isLike == 0) {
            $danhgia = new DanhGia();
            $danhgia->fill([
                'idBaiViet' => $id,
                'idUser' => $request->user()->id,
                'userLike' => 1,
                'userUnLike' => 0,
                'userXem' => 0,
            ]);
            $danhgia->save();

            return response()->json([
                'message' => 'Đã thêm like',
            ], 200);
        } else {
            if ($danhgia[0]->userLike == 0) {

                $danhgia[0]->userLike = 1;
                $danhgia[0]->userUnLike = 0;
                $danhgia[0]->update();

                return response()->json([
                    'message' => 'Đã like',
                ], 200);
            } else {

                $danhgia[0]->userLike = 0;
                $danhgia[0]->userUnLike = 0;
                $danhgia[0]->update();

                return response()->json([
                    'message' => 'Xoá like',
                ], 200);
            }
        }
    }

    public function unlike(Request $request, $id)
    {
        $danhgia = DanhGia::where([
            ['idBaiViet', '=', $id],
            ['idUser', '=', $request->user()->id],
        ])->get();
        $isUnLike = count($danhgia);

        if ($isUnLike == 0) {
            $danhgia = new DanhGia();
            $danhgia->fill([
                'idBaiViet' => $id,
                'idUser' => $request->user()->id,
                'userLike' => 0,
                'userUnLike' => 1,
                'userXem' => 0,
            ]);
            $danhgia->save();

            return response()->json([
                'message' => 'Đã thêm Unlike',
            ], 200);
        } else {
            if ($danhgia[0]->userUnLike == 0) {

                $danhgia[0]->userLike = 0;
                $danhgia[0]->userUnLike = 1;
                $danhgia[0]->update();

                return response()->json([
                    'message' => 'Đã Unlike',
                ], 200);
            } else {

                $danhgia[0]->userLike = 0;
                $danhgia[0]->userUnLike = 0;
                $danhgia[0]->update();

                return response()->json([
                    'message' => 'Xoá Unlike',
                ], 200);
            }
        }
    }

    public function view(Request $request, $id)
    {
        $danhgia = DanhGia::where([
            ['idBaiViet', '=', $id],
            ['idUser', '=', $request->user()->id],
        ])->get();
        $isView = count($danhgia);

        if ($isView == 0) {
            $danhgia = new DanhGia();
            $danhgia->fill([
                'idBaiViet' => $id,
                'idUser' => $request->user()->id,
                'userLike' => 0,
                'userUnLike' => 0,
                'userXem' => 1,
            ]);
            $danhgia->save();

            return response()->json([
                'message' => 'Đã tăng view',
            ], 200);
        } else {
            if ($danhgia[0]->userXem == 1) return response()->json([
                'message' => 'Đã View rồi',
            ], 200);
            else {
                $danhgia[0]->userXem = 1;
                $danhgia[0]->update();

                return response()->json([
                    'message' => 'Đã View',
                ], 200);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BaiVietChiaSe  $baiVietChiaSe
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $hinhAnh = HinhAnh::where('idBaiVietChiaSe', '=', $id);
            $deleteHinh = $hinhAnh->first();
            Storage::disk('public')->delete($deleteHinh->hinhAnh);
            $baiViet = BaiVietChiaSe::find($id);
            $baiViet->delete();
            $hinhAnh->delete();
            return response()->json([
                'message' => 'Xoá thành công',
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'message' => 'Có lỗi xảy ra',
                'error' => $error,
            ], 500);
        }
    }
}
