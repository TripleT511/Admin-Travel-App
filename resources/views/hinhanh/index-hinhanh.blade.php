@extends('layouts.admin')

@section('title','Danh sách hình ảnh')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Danh sách hình ảnh </h3>
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('hinhAnh.create') }}">Thêm hình ảnh</a></li>
        <li class="breadcrumb-item active" aria-current="page">Danh sách hình ảnh</li>
    </ol>
    </nav>
</div>
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Bảng hình ảnh</h4>
                </p>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Tên địa danh</th>
                                <th>Id bài viết</th>
                                <th>Hình ảnh</th>
                                <th>Loại hình ảnh</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lstHinhAnh as $item)
                                <tr>
                                     <td>{{ $item->id }}</td>
                                     <td>{{ $item->diadanh->tenDiaDanh }}</td>
                                     <td>{{ $item->idBaiVietChiaSe }}</td>
                                     <td>
                                         <img class="img-fluid" src="storage/{{ $item->hinhAnh }}" width="200" alt="">
                                     </td>
                                     <td>
                                        @if($item->idLoai == 1) Địa Danh 
                                        @elseif($item->idLoad == 2) Bài viết
                                        @endif
                                    </td>
                                     <td>
                                        <label class="badge badge-primary">
                                            <a class="d-block text-light" href="{{ route('hinhAnh.edit', ['hinhAnh'=>$item]) }}"> Sửa</a>
                                        </label>
                                        <label class="badge badge-success">
                                            <a class="d-block text-light" href="{{ route('hinhAnh.show', ['hinhAnh'=>$item]) }}"> Show</a>
                                        </label>
                                        <label >
                                            <form method="post" action="{{ route('hinhAnh.destroy', ['hinhAnh'=>$item]) }}">
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