<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    protected function fixImage(User $hinhAnh)
    {
        if (Storage::disk('public')->exists($hinhAnh->hinhAnh)) {
            $hinhAnh->hinhAnh = $hinhAnh->hinhAnh;
        } else {
            $hinhAnh->hinhAnh = 'images/user-default.jpg';
        }
    }
    public function showFormlogin()
    {
        return view('login');
    }

    public function showFormForgot()
    {
        return view('forgot');
    }

    public function forgot(Request $request)
    {
        $request->validate([
            'email' => 'email|required|exists:users',
        ], [
            'email.required' => "Bắt buộc nhập email",
            'email.email' => "Không đúng định dạng email",
            'email.exists' => "Email không tồn tại trong hệ thống",
        ]);

        $user = User::where('email', '=', $request->input('email'))->first();
        $token = strtoupper(Str::random(5));

        Mail::send('check-email', compact('user'), function ($message) use ($user) {
            $message->subject('StrawHat - Khôi phục mật khẩu');
            $message->to($user->email, $user->hoTen);
        });

        return redirect()->back()->with('Thông báo', 'Đã gửi email xác nhận');
    }

    public function showFormregister()
    {
        return view('register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => "Bắt buộc nhập email",
            'email.email' => "Không đúng định dạng email",
            'password.required' => "Bắt buộc nhập mật khẩu"
        ]);


        $remember = $request->has('nhomatkhau') ? true : false;

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'idPhanQuyen' => 0], $remember)) {

            $request->session()->regenerate();

            return redirect()->intended('/');
        }


        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function register(Request $request)
    {
        $request->validate([
            'hoTen' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'soDienThoai' => 'required|string',
            'hinhAnh' => 'required',
        ], [
            'hoTen.required' => 'Họ Tên không được bỏ trống',
            'email.required' => 'Email không được bỏ trống',
            'password.required' => 'Mật khẩu không được bỏ trống',
            'soDienThoai.required' => 'Số điện thoại không được bỏ trống',
            'hinhAnh.required' => 'Bắt buộc chọn Hình ảnh',
        ]);
        $user = new User();
        $user->idPhanQuyen = $request->idPhanQuyen;
        $user->hoTen = $request->hoTen;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->soDienThoai = $request->soDienThoai;
        $user->hinhAnh = "";
        $user->trangThaiHoTen = 1;
        $user->trangThaiEmail = 1;
        $user->trangThaiSDT = 1;
        $user->trangThai = 1;
        $user->save();

        if ($request->hasFile('hinhAnh')) {
            $user->hinhAnh = Storage::disk('public')->put('images', $request->file('hinhAnh'));
        }
        $user->save();

        return redirect()->route('show-register');
    }

    public function index()
    {
        $lstTaiKhoan = User::withCount('baiviets')->withCount('tinhthanhs')->get();
        foreach ($lstTaiKhoan as $item) {
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
        return view('user.index-user', ['lstTaiKhoan' => $lstTaiKhoan]);
    }
}
