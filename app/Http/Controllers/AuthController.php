<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    protected function fixImage(User $hinhAnh)
    {
        if (Storage::disk('public')->exists($hinhAnh->hinhAnh)) {
            $hinhAnh->hinhAnh = $hinhAnh->hinhAnh;
        } else {
            $hinhAnh->hinhAnh = 'images/user-default.jpg';
        }
    }
    public function login(Request $request)
    {
        try {
            $request->validate([

                'email' => 'email|required',
                'password' => 'required',

            ]);

            $credentials = request(['email', 'password']);

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'status_code' => 422,
                    'message' => 'Unauthorized',

                ]);
            }

            $user =  User::where('email', $request->email)->first();

            if (!Hash::check($request->password, $user->password, [])) {
                return response()->json([
                    'status_code' => 422,
                    'message' => 'Password Match',

                ]);
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                'status_code' => 200,
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error in login',
                'error' => $error,
            ]);
        }
    }
    public function getAllUser()
    {
        $user = User::all();
        echo $user;
        foreach ($user as $item) {
            $this->fixImage($item);
        }
        return response([
            'data' => $user,
        ]);
    }

    public function register(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'idPhanQuyen' => 'required',
                'hoTen' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
                'soDienThoai' => 'required|string',
                'trangThaiHoTen' => 'required',
                'trangThaiEmail' => 'required',
                'trangThaiSDT' => 'required',
                'trangThai' => 'required',
            ], [
                'hoTen.required' => 'Họ Tên không được bỏ trống',
                'email.required' => 'Email không được bỏ trống',
                'password.required' => 'Mật khẩu không được bỏ trống',
                'soDienThoai.required' => 'Số điện thoại không được bỏ trống',
            ]);

            if ($validator->fails()) {
                return response([
                    'error' => $validator->errors()->all()
                ], 422);
            }

            $request['password'] = Hash::make($request['password']);
            $request['remember_token'] = Str::random(10);
            $user = User::create($request->toArray());

            return response()->json([
                'status_code' => 200,
                'message' => 'Registration Successfull',
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error in Registration',
                'error' => $error,
            ]);
        }
    }

    public function updateAvatar(Request $request)
    {
        if ($request->hasFile('hinhAnh')) {
            $request->user()->update(['hinhAnh' => Storage::disk('public')->put('images', $request->file('hinhAnh'))]);

            return response()->json([
                'message' => "Change Avatar successfully"
            ], 200);
        }
        return response()->json([
            'message' => "No change"
        ], 200);
    }

    public function updatePassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'password' => 'required',
                'new_password' => 'required|string|min:6|different:password',
                'confirm_password' => 'required|same:new_password',
            ]);

            if ($validator->fails()) {
                return response([
                    'error' => $validator->errors()->all()
                ], 422);
            }

            $user = request()->user();

            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status_code' => 422,
                    'message' => 'Old password doesn\'t matched',
                ]);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json([
                'status_code' => 200,
                'message' => 'Password successfully changed!',
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error in changing password',
                'error' => $error,
            ]);
        }
    }

    public function updateInfor(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'hoTen' => 'required|string|max:255',
                'soDienThoai' => 'required|string',
            ], [
                'hoTen.required' => 'Họ Tên không được bỏ trống',
                'soDienThoai.required' => 'Số điện thoại không được bỏ trống',
            ]);

            if ($validator->fails()) {
                return response([
                    'error' => $validator->errors()->all()
                ], 422);
            }

            $user = request()->user();
            $user->hoTen = $request->hoTen;
            $user->soDienThoai = $request->soDienThoai;
            $user->trangThaiHoTen = $request->trangThaiHoTen;
            $user->trangThaiEmail = $request->trangThaiEmail;
            $user->trangThaiSDT = $request->trangThaiSDT;

            $user->save();

            return response()->json([
                'status_code' => 200,
                'message' => 'Update successfully',
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error',
                'error' => $error,
            ]);
        }
    }

    public function logout(Request $request)
    {
        $user = request()->user()->currentAccessToken()->delete();

        return response()->json([
            'status_code' => 200,
            'message' => "Logout Successfull",
        ]);
    }

    public function getListToken(Request $request)
    {
        return $request->user()->tokens;
    }

    public function getUser(Request $request)
    {
        $user = User::withCount('baiviets')->where('id', '=', $request->user()->id)->first();
        $this->fixImage($user);
        return response($user);
    }

    public function deleteTokenById(Request $request, $tokenId)
    {
        return $request->user()->tokens()->where('id', $tokenId)->delete();
    }

    public function deleteAllToken(Request $request)
    {
        return $request->user()->tokens()->delete();
    }
}
