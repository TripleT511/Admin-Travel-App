@extends('layouts.admin')

@section('title','Danh sách tài khoản')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Danh sách tài khoản </h3>
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="">Thêm tài khoản</a></li>
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
                                <th>Tên tài khoản</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lstTaiKhoan as $item)
                                <tr>
                                     <td>{{ $item->id }}</td>
                                     <td>
                                         <a href="">{{ $item->hoTen }}</a>
                                     </td>
                                     <td>
                                         <a href="">{{ $item->email }}</a>
                                     </td>
                                     <td>
                                        <label class="badge badge-primary">
                                            <a class="d-block text-light" href=""> Sửa</a>
                                        </label>
                                        <label >
                                            <form method="post" action="">
                                            @csrf
                                            @method("DELETE")
                                            <button style="outline: none; border: none" class="badge badge-danger" type="submit">Xoá</button>
                                            </form>
                                        </label>
                                     </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection