@extends('layouts.admin')

@section('title','Danh sách món ăn')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Danh sách món ăn </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('monAn.create') }}">Thêm món ăn</a></li>
            <li class="breadcrumb-item active" aria-current="page">Danh sách món ăn</li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Bảng món ăn</h4>
                </p>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Tên quán ăn</th>
                                <th>Tên món </th>
                                <th>Hình ảnh</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lstMonAn as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->quanan->tenQuan }}</td>
                                <td>{{ $item->tenMon }}</td>
                                <td>
                                    <img src="@if($item->hinhAnh != null) {{ asset($item->hinhAnh) }}
                                                      @else '/images/no-image-available.jpg'
                                                      @endif" width="150" />
                                </td>

                                <td>
                                    <label class="badge badge-primary">
                                        <a class="d-block text-light"
                                            href="{{ route('monAn.edit', ['monAn'=>$item]) }}"> Sửa</a>
                                    </label>
                                    <!-- <label class="badge badge-success">
                                        <a class="d-block text-light"
                                            href="{{ route('monAn.show', ['monAn'=>$item]) }}"> Show</a>
                                    </label> -->
                                    <label>
                                        <form method="post" action="{{ route('monAn.destroy', ['monAn'=>$item]) }}">
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
                    {{ $lstMonAn->links() }}
            </div>
        </div>
    </div>
</div>
@endsection