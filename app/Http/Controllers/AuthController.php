<?php

namespace App\Http\Controllers;

use App\Models\TinhThanh;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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

                ], 422);
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                'status_code' => 200,
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error in login',
                'error' => $error,
            ], 500);
        }
    }
    public function getAllUser()
    {
        $user = User::all();

        foreach ($user as $item) {
            $countTinhThanh = 0;
            $userTinhThanh = User::whereId($item->id)->with('tinhthanhs.diadanh')->first();
            foreach ($userTinhThanh->tinhthanhs->groupBy('diadanh.tinh_thanh_id') as $items) {
                if (count($userTinhThanh->tinhthanhs->groupBy('diadanh.tinh_thanh_id')) != 0) {
                    $countTinhThanh++;
                }
            }
            $item->tinhthanhs_count = $countTinhThanh;
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

            ], [
                'hoTen.required' => 'H??? T??n kh??ng ???????c b??? tr???ng',
                'email.required' => 'Email kh??ng ???????c b??? tr???ng',
                'password.required' => 'M???t kh???u kh??ng ???????c b??? tr???ng',
                'soDienThoai.required' => 'S??? ??i???n tho???i kh??ng ???????c b??? tr???ng',
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
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error in Registration',
                'error' => $error,
            ], 500);
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
                ], 422);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json([
                'status_code' => 200,
                'message' => 'Password successfully changed!',
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error in changing password',
                'error' => $error,
            ], 500);
        }
    }

    public function updateInfor(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'hoTen' => 'required|string|max:255',
                'soDienThoai' => 'required|string',
            ], [
                'hoTen.required' => 'H??? T??n kh??ng ???????c b??? tr???ng',
                'soDienThoai.required' => 'S??? ??i???n tho???i kh??ng ???????c b??? tr???ng',
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
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $user = request()->user()->currentAccessToken()->delete();

        return response()->json([
            'status_code' => 200,
            'message' => "Logout Successfull",
        ], 200);
    }

    public function getListToken(Request $request)
    {
        return $request->user()->tokens;
    }

    public function getUser(Request $request)
    {

        $user = User::withCount('baiviets')->withCount('tinhthanhs')->where('id', '=', $request->user()->id)->first();
        $countTinhThanh = 0;
        $userTinhThanh = User::whereId($request->user()->id)->with('tinhthanhs.diadanh')->first();
        foreach ($userTinhThanh->tinhthanhs->groupBy('diadanh.tinh_thanh_id') as $item) {
            if (count($userTinhThanh->tinhthanhs->groupBy('diadanh.tinh_thanh_id')) != 0) {
                $countTinhThanh++;
            }
        }
        $this->fixImage($user);
        $user->tinhthanhs_count = $countTinhThanh;
        return response($user, 200);
    }

    public function deleteTokenById(Request $request, $tokenId)
    {
        return $request->user()->tokens()->where('id', $tokenId)->delete();
    }

    public function deleteAllToken(Request $request)
    {
        return $request->user()->tokens()->delete();
    }

    public function forgot(Request $request)
    {


        try {
            $validator = Validator::make($request->all(), [
                'email' => 'email|required|exists:users',
            ], [
                'email.required' => "B???t bu???c nh???p email",
                'email.email' => "Kh??ng ????ng ?????nh d???ng email",
                'email.exists' => "Email kh??ng t???n t???i trong h??? th???ng",
            ]);

            if ($validator->fails()) {
                return response([
                    'error' => $validator->errors()->all()
                ], 422);
            }

            $token = strtoupper(Str::random(6));
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);
            $user = User::where('email', $request->email)->first();
            Mail::send('check-email-app', ['token' => $token, 'user' => $user], function ($message) use ($request) {
                $message->subject('?????t l???i m???t kh???u');
                $message->to($request->email);
            });

            return response()->json([
                'message' => '???? g???i email, vui l??ng ki???m tra email ????? ?????t l???i m???t kh???u.',
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'message' => 'C?? l???i x???y ra',
                'error' => $error,
            ], 500);
        }
    }

    public function checkToken(Request $request)
    {
        $request->validate([
            'token' => 'required|exists:password_resets',
        ], [
            'token.required' => "B???t bu???c nh???p token",
            'token.exists' => "Token kh??ng t???n t???i",
        ]);

        $token = DB::table('password_resets')->where('token', $request->token)->first();

        if ($token) {
            return response()->json([
                'message' => 'Token h???p l???',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Token kh??ng h???p l???',
            ], 422);
        }
    }

    public function reset(Request $request, $token)
    {
        try {

            $validator = Validator::make($request->all(), [
                'password' => 'required|string|min:6',
                'confirm-password' => 'required|same:password',
            ], [
                'password.required' => "B???t bu???c nh???p m???t kh???u",
                'password.string' => "M???t kh???u ph???i l?? chu???i k?? t???",
                'password.min' => "M???t kh???u ph???i c?? ??t nh???t 6 k?? t???",
                'confirm-password.required' => "B???t bu???c nh???p l???i m???t kh???u",
                'confirm-password.same' => "M???t kh???u nh???p l???i kh??ng kh???p",
                'token.required' => "B???t bu???c nh???p token",
            ]);

            if ($validator->fails()) {
                return response([
                    'error' => $validator->errors()->all()
                ], 422);
            }

            $passwordReset = DB::table('password_resets')->where('token', $token)->first();

            $user = User::where('email', $passwordReset->email)->firstOrFail();
            $user->password = Hash::make($request->password);
            $user->update();
            $passwordReset = DB::table('password_resets')->where('email', $passwordReset->email)->get();

            foreach ($passwordReset as $item) {
                DB::table('password_resets')->where('email', $item->email)->delete();
            }

            return response()->json([
                'message' => '?????t l???i m???t kh???u th??nh c??ng.',
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'message' => 'C?? l???i x???y ra, ki???m tra l???i token c???a b???n.',
                'error' => $error,
            ], 500);
        }
    }

    public function getAllToken()
    {
        $lstToken = DB::table('password_resets')->get();
        return response()->json([
            'data' => $lstToken,
        ], 200);
    }
}
