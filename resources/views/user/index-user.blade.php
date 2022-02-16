@extends('layouts.admin')

@section('title','Danh sách tài khoản')

@section('content')
<div class="row">
        <div class="col col-lg-6 col-md-12">
            <ul class="navbar-nav w-100">
                <li class="nav-item w-100">
                    <form class="nav-link d-lg-flex search">
                        <input type="text" id="txtSearchUser" name="txtSearchUs" class="form-control" placeholder="Tìm kiếm">
                    </form>
                </li>
            </ul>
        </div>
    </div>
<div class="page-header">
    <h3 class="page-title"> Danh sách tài khoản </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('register') }}">Thêm tài khoản</a></li>
            <li class="breadcrumb-item active" aria-current="page">Danh sách tài khoản</li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Bảng tài khoản</h4>
                </p>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Hình ảnh</th>
                                <th>Họ tên</th>
                                <th>Email</th>
                                <th>Phân quyền</th>
                                <th>Bài viết</th>
                                <th>Tỉnh thành</th>
                            </tr>
                        </thead>
                        <tbody id="lstUser">
                            @foreach ($lstTaiKhoan as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>
                                    <img class="rounded-circle" src="@if($item->hinhAnh != null) {{ asset($item->hinhAnh) }}
                                                      @else {{ asset("/images/no-image-available.jpg") }}
                                                      @endif" width="50" height="50" />
                                </td>
                                <td>
                                    <a href="{{ route('show', ['id'=>$item->id]) }}">
                                        {{ $item->hoTen }}
                                    </a>
                                </td>
                                <td>
                                    {{ $item->email }}
                                </td>
                                <td>
                                    @if($item->idPhanQuyen == 0) Admin
                                    @else Người dùng
                                    @endif
                                </td>
                                <td>
                                    {{ $item->baiviets_count }}
                                </td>
                                <td>
                                    {{ $item->tinhthanhs_count }}
                                </td>
                                <td>
                                    <label>
                                        <form method="post" action="{{ route('deleteUser', ['user' => $item]) }}">
                                            @csrf
                                            @method("DELETE")
                                            <button style="outline: none; border: none" class="badge badge-danger"
                                                type="submit">Khoá</button>
                                        </form>
                                    </label>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="pagination d-flex justify-content-center">
                    {{ $lstTaiKhoan->links() }}
            </div>
        </div>
    </div>
</div>
@endsection