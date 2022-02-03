@extends('layouts.admin')

@section('title','Danh sách bài viết')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Danh sách bài viết </h3>
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('baiViet.create') }}">Thêm bài viết</a></li>
        <li class="breadcrumb-item active" aria-current="page">Danh sách bài viết</li>
    </ol>
    </nav>
</div>
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Bảng bài viết</h4>
                </p>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Tên địa danh</th>
                                <th>Tên người đăng</th>
                                <th>Nội dung</th>
                                <th>Hình ảnh</th>
                                <th>Lượt like</th>
                                <th>Lượt Unlike</th>
                                <th>Lượt Xem</th>
                                <th>Thời gian</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lstBaiViet as $item)
                                <tr>
                                     <td>{{ $item->id }}</td>
                                     <td>{{ $item->diadanh->tenDiaDanh }}</td>
                                     <td>{{ $item->user->hoTen }}</td>
                                     <td class="text-wrap">{{ $item->noiDung }}</td>
                                     <td>
                                         <img class="img-fluid" src="{{ asset($item->hinhanh->hinhAnh) }}" width="200" alt="">
                                     </td>
                                     <td>{{ $item->likes_count }}</td>
                                     <td>{{ $item->unlikes_count }}</td>
                                     <td>{{ $item->views_count }}</td>
                                     <td>{{  date('d-m-Y', strtotime($item->thoiGian)) }}</td>
                                     <td>
                                        <label class="badge badge-primary">
                                            <a class="d-block text-light" href="{{ route('baiViet.edit', ['baiViet'=>$item]) }}"> Sửa</a>
                                        </label>
                                        <label >
                                            <form method="post" action="{{ route('baiViet.destroy', ['baiViet'=>$item]) }}">
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
            <div class="pagination d-flex justify-content-center">
                    {{ $lstBaiViet->links() }}
            </div>
        </div>
    </div>
</div>
@endsection