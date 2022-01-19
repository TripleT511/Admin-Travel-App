@extends('layouts.admin')

@section('title','Danh sách địa danh')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Danh sách địa danh </h3>
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('diaDanh.create') }}">Thêm địa danh</a></li>
        <li class="breadcrumb-item active" aria-current="page">Danh sách địa danh</li>
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
                                <th>Mô tả</th>
                                <th>Kinh độ</th>
                                <th>Vĩ độ</th>
                                <th>Hình ảnh</th>
                                <th>Tỉnh thành</th>
                                <th>Lượt chia sẻ</th>
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
                                     <td class="text-wrap">{{ $item->moTa }}</td>
                                     <td>{{ $item->kinhDo }}</td>
                                     <td>{{ $item->viDo }}</td>
                                     <td>
                                         <img src="@if($item->hinhanh != null) {{ asset($item->hinhanh->hinhAnh) }}
                                                      @else '/images/no-image-available.jpg'
                                                      @endif" width="150"/>
                                     </td>
                                     <td>{{ $item->tinhthanh->tenTinhThanh }}</td>
                                     <td>{{ $item->shares_count }}</td>
                                     <td>
                                        <label class="badge badge-primary">
                                            <a class="d-block text-light" href="{{ route('diaDanh.edit', ['diaDanh'=>$item]) }}"> Sửa</a>
                                        </label>
                                        <label >
                                            <form method="post" action="{{ route('diaDanh.destroy', ['diaDanh'=>$item]) }}">
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