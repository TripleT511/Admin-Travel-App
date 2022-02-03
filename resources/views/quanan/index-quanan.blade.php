@extends('layouts.admin')

@section('title','Danh sách quán ăn')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Danh sách quán ăn </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('quanAn.create') }}">Thêm quán ăn</a></li>
            <li class="breadcrumb-item active" aria-current="page">Danh sách quán ăn</li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Bảng quán ăn</h4>
                </p>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Tên địa danh</th>
                                <th>Tên quán</th>
                                <th>Mô tả</th>
                                <th>Địa chỉ</th>
                                <th>Sdt</th>
                                <th>Thời gian hoạt động</th>
                                <th>Hình ảnh</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lstQuanAn as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->diadanh->tenDiaDanh }}</td>
                                <td>{{ $item->tenQuan }}</td>
                                <td>{{ $item->moTa }}</td>
                                <td>{{ $item->diaChi }}</td>
                                <td>{{ $item->sdt }}</td>
                                <td>{{ $item->thoiGianHoatDong }}</td>
                                <td>
                                    <img src="@if($item->hinhAnh != null) {{ asset($item->hinhAnh) }}
                                                      @else '/images/no-image-available.jpg'
                                                      @endif" width="150" />
                                </td>

                                <td>
                                    <label class="badge badge-primary">
                                        <a class="d-block text-light"
                                            href="{{ route('quanAn.edit', ['quanAn'=>$item]) }}"> Sửa</a>
                                    </label>
                                    <!-- <label class="badge badge-success">
                                        <a class="d-block text-light"
                                            href="{{ route('quanAn.show', ['quanAn'=>$item]) }}"> Show</a>
                                    </label> -->
                                    <label>
                                        <form method="post" action="{{ route('quanAn.destroy', ['quanAn'=>$item]) }}">
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
            <div class="pagination d-flex justify-content-center">
                    {{ $lstQuanAn->links() }}
            </div>
        </div>
    </div>
</div>
@endsection