@extends('layouts.admin')

@section('title','Đề xuất địa danh')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Đề xuất địa danh </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('deXuatDiaDanh.create') }}">Thêm địa danh</a></li>
            <li class="breadcrumb-item active" aria-current="page">Đề xuất địa danh</li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Bảng địa danh
                </h4>
                </p>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Tên địa danh</th>
                                <th>Tên người đăng</th>
                                <th>Mô tả</th>
                                <th>Kinh độ</th>
                                <th>Vĩ độ</th>
                                <th>Hình ảnh</th>
                                <th>Tỉnh thành</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lstDiaDanh as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>
                                    <a href="{{ route('diaDanh.show', ['diaDanh'=>$item]) }}">
                                        {{ $item->tenDiaDanh }}
                                    </a>
                                </td>
                                <td>{{ $item->user->hoTen }}</td>
                                <td class="text-wrap">{{ $item->moTa }}</td>
                                <td>{{ $item->kinhDo }}</td>
                                <td>{{ $item->viDo }}</td>
                                <td>
                                    <img src="@if($item->hinhAnh != null) {{ asset($item->hinhAnh) }}
                                                      @else '/images/no-image-available.jpg'
                                                      @endif" width="150" />
                                </td>
                                <td>{{ $item->tinhthanh->tenTinhThanh }}</td>
                                <td>
                                    <label class="badge badge-primary">
                                        <a class="d-block text-light"
                                            href="{{ route('deXuatDiaDanh.edit', ['deXuatDiaDanh'=>$item]) }}">
                                            Duyệt</a>
                                    </label>
                                    <label>
                                        <form method="post"
                                            action="{{ route('deXuatDiaDanh.destroy', ['deXuatDiaDanh'=>$item]) }}">
                                            @csrf
                                            @method("DELETE")
                                            <button style="outline: none; border: none" class="badge badge-danger"
                                                type="submit">Xoá</button>
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