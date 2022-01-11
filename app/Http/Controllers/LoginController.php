<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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

    public function showFormregister()
    {
        return view('register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'hoTen' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'soDienThoai' => 'required|string',
            'hinhAnh' => 'required',
            // 'trangThaiHoTen' => 'required',
            // 'trangThaiEmail' => 'required',
            // 'trangThaiSDT' => 'required',
            // 'trangThai' => 'required',
        ], [
            'hoTen.required' => 'Họ Tên không được bỏ trống',
            'email.required' => 'Email không được bỏ trống',
            'password.required' => 'Mật khẩu không được bỏ trống',
            'soDienThoai.required' => 'Số điện thoại không được bỏ trống',
            'hinhAnh.required' => 'Bắt buộc chọn Hình ảnh',
            // 'trangThaiHoTen.required' => 'Trạng thái họ tên không được bỏ trống',
            // 'trangThaiEmail.required' => 'Trạng thái email không được bỏ trống',
            // 'trangThaiSDT.required' => 'Trạng thái số điện thoại không được bỏ trống',
            // 'trangThai.required' => 'Trạng thái không được bỏ trống',
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
        $lstTaiKhoan = User::all();
        foreach ($lstTaiKhoan as $item) {
            $this->fixImage($item);
        }
        return view('user.index-user', ['lstTaiKhoan' => $lstTaiKhoan]);
    }
}
