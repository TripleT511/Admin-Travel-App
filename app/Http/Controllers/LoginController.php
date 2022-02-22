<?php

namespace App\Http\Controllers;

use App\Models\DiaDanh;
use App\Models\HinhAnh;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

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

    protected function fixImage2(HinhAnh $hinhAnh)
    {
        if (Storage::disk('public')->exists($hinhAnh->hinhAnh)) {
            $hinhAnh->hinhAnh = $hinhAnh->hinhAnh;
        } else {
            $hinhAnh->hinhAnh = 'images/no-image-available.jpg';
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

        $token = strtoupper(Str::random(60));
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);
        $user = User::where('email', $request->email)->first();
        Mail::send('check-email', ['token' => $token, 'user' => $user], function ($message) use ($request) {
            $message->subject('Đặt lại mật khẩu');
            $message->to($request->email);
        });

        return redirect()->back()->with('message', 'Đã gửi email xác nhận');
    }

    public function showFormReset($token)
    {
        $passwordreset = DB::table('password_resets')->where('token', $token)->first();
        return view('reset-password', ['token' => $token, 'email' => $passwordreset->email]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'email|required|exists:password_resets',
            'password' => 'required|string|min:6',
            'confirm-password' => 'required|same:password',
            'token' => 'required|exists:password_resets',
        ], [
            'email.required' => "Bắt buộc nhập email",
            'email.email' => "Không đúng định dạng email",
            'email.exists' => "Email không tồn tại trong hệ thống",
            'password.required' => "Bắt buộc nhập mật khẩu",
            'password.string' => "Mật khẩu phải là chuỗi ký tự",
            'password.min' => "Mật khẩu phải có ít nhất 6 ký tự",
            'confirm-password.required' => "Bắt buộc nhập lại mật khẩu",
            'confirm-password.same' => "Mật khẩu nhập lại không khớp",
            'token.required' => "Bắt buộc nhập token",
            'token.exists' => "Token không tồn tại",
        ]);

        $passwordReset = DB::table('password_resets')->where('token', $request->token)->first();

        $user = User::where('email', $passwordReset->email)->firstOrFail();
        $user->password = Hash::make($request->password);
        $user->update();
        $passwordReset = DB::table('password_resets')->where('token', $request->token)->delete();

        return redirect()->route('show-login')->with('message', 'Vui lòng đăng nhập');
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
            'email.unique' => 'Email đã tồn tại',
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

        $user->save();

        if ($request->hasFile('hinhAnh')) {
            $user->hinhAnh = Storage::disk('public')->put('images', $request->file('hinhAnh'));
        }
        $user->save();

        return redirect()->route('show-register');
    }

    public function index()
    {
        $lstTaiKhoan = User::withCount('baiviets')->withCount('tinhthanhs')->paginate(5);
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

    public function show($id)
    {
        $user = User::findOrFail($id);
        $this->fixImage($user);
        return view('user.show-user', ['taiKhoan' => $user]);
    }

    public function timKiem(Request $request)
    {
        $output = "";
        $lstTaiKhoan = User::withCount('baiviets')->withCount('tinhthanhs')->paginate(5);

        if ($request->input('txtSearch') != "") {
            $lstTaiKhoan = User::withCount('baiviets')->withCount('tinhthanhs')->where('hoTen', 'LIKE', '%' . $request->input('txtSearch') . '%')->orWhere('email', 'LIKE', '%' . $request->input('txtSearch') . '%')->orWhere('soDienThoai', '=', $request->input('txtSearch'))->paginate(5);
        }
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

            $output .= '<tr>
                                <td>' . $item->id . '</td>
                                <td>
                                    <img class="rounded-circle" src="' . ($item->hinhAnh != null ? asset($item->hinhAnh) : asset("/images/no-image-available.jpg"))
                . '" width="50" height="50" />
                                </td>
                                <td>
                                    <a href="' . route("show", ["id" => $item->id]) . '">
                                       ' . $item->hoTen . '
                                    </a>
                                </td>
                                <td>
                                ' . $item->email . '
                                </td>
                                <td>' . ($item->idPhanQuyen == 0 ? 'Admin' : 'Người dùng')
                . '</td>
                                <td>
                                ' . $item->baiviets_count . '
                                </td>
                                <td>
                                ' . $item->tinhthanhs_count . '
                                </td>
                                <td>
                                    <label>
                                        <form method="post" action="' . route('deleteUser', ['user' => $item]) . '">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                                            <button style="outline: none; border: none" class="badge badge-danger"
                                                type="submit">Khoá</button>
                                        </form>
                                    </label>
                                </td>

                            </tr>';
        }
        return response()->json($output);
    }

    public function timKiemDiaDanh(Request $request)
    {
        $output = "";
        $lstDiaDanh = DiaDanh::with('tinhthanh')->with(['hinhanhs' => function ($query) {
            $query->where('idLoai', '=', 1)->orderBy('created_at');
        }])->with(['hinhanh' => function ($query) {
            $query->where('idLoai', '=', 1)->orderBy('created_at');
        }])->withCount('shares')->orderBy('id')->paginate(5);

        if ($request->input('txtSearch') != "") {
            $lstDiaDanh = DiaDanh::with('tinhthanh')->with(['hinhanhs' => function ($query) {
                $query->where('idLoai', '=', 1)->orderBy('created_at');
            }])->with(['hinhanh' => function ($query) {
                $query->where('idLoai', '=', 1)->orderBy('created_at');
            }])->withCount('shares')->where('tenDiaDanh', 'LIKE', '%' . $request->input('txtSearch') . '%')->orWhere('moTa', 'LIKE', '%' . $request->input('txtSearch') . '%')->orderBy('id')->paginate(5);
        }

        foreach ($lstDiaDanh as $item) {
            $this->fixImage2($item->hinhanh);
            foreach ($item->hinhanhs as $item2) {
                $this->fixImage2($item2);
            }

            $tinh = $item->tinhthanh->tenTinhThanh;

            $output .= '<tr>
                                <td>' . $item->id . '</td>
                                <td>
                                    <a href="' . route("show", ["id" => $item->id]) . '">
                                       ' . $item->tenDiaDanh . '
                                    </a>
                                </td>
                                <td class="text-wrap cell-5">
                                ' . $item->moTa . '
                                </td>
                                <td>
                                ' . $item->kinhDo . '
                                </td>
                                <td>
                                ' . $item->viDo . '
                                </td>
                                <td>
                                    <img width="150" src="' . ($item->hinhanh != null ? asset($item->hinhanh->hinhAnh) : asset("/images/no-image-available.jpg"))
                . '"  />
                                </td>
                                <td>
                                ' . $tinh . '
                                </td>
                                <td>
                                ' . $item->shares_count . '
                                </td>
                                <td>
                                    <label class="badge badge-primary">
                                            <a class="d-block text-light" href="' . route('diaDanh.edit', ['diaDanh' => $item]) . '"> Sửa</a>
                                    </label>
                                    <label>
                                        <form method="post" action="' . route('diaDanh.destroy', ['diaDanh' => $item]) . '">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                                            <button style="outline: none; border: none" class="badge badge-danger"
                                                type="submit">Xoá</button>
                                        </form>
                                    </label>
                                </td>

                            </tr>';
        }
        return response()->json($output);
    }

    public function delete(User $user)
    {

        $user->delete();

        return Redirect::route('lstUser');
    }
}
