@extends('layouts.admin')

@section('title','Danh sách tài khoản')

@section('content')
<div class="row">
    <div class="col col-lg-6 col-md-12">
        <div class="nav-link d-lg-flex search align-items-center">
            <input type="text" id="txtSearchUser"  class="form-control m-1 text-light" placeholder="Tìm kiếm">
            <button class="btn btn-primary" id="txtSearch">Tìm kiếm</button>
            <select id="txtloc" class="form-control text-light m-1">
                <option value="0">--Chọn--</option>
                <option value="1">Tài khoản còn hoạt động</option>
                <option value="2">Tài khoản đã bị khoá</option>
            </select>
            <button class="btn btn-primary" id="loc">Lọc</button>
        </div>
    </div>
</div>
@if(session('error')) 
    <div class="alert alert-danger w-25">
        {{ session('error') }}
    </div>
@endif
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

@section('js')
<script>
        $(document).ready(function() {

            //Search User
            $('#txtSearch').on('click', function() {
                var val = $('#txtSearchUser').val();
                $.ajax({
                    type: "get",
                    url: "/user/search",
                    data: {
                        txtSearch: val
                    },
                    dataType: "json",
                    success: function (response) {
                        $("#lstUser").html(response);
                        
                    }
                });
            });

            $('#loc').on('click', function() {
                var value = $('#txtloc').val();
                if(value == 0) {
                    alert("Vui lòng chọn tiêu chí");
                } else {
                    $.ajax({
                    type: "get",
                    url: "/user/locUser",
                    data: {
                        loai: value
                    },
                    dataType: "json",
                    success: function (response) {
                        $("#lstUser").html(response);
                        
                    }
                });
                }
            })

           
        });
    </script>

@endsection