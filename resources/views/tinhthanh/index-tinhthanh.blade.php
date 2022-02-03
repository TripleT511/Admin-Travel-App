@extends('layouts.admin')

@section('title','Danh sách tỉnh thành')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Danh sách tỉnh thành </h3>
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('tinhThanh.create') }}">Thêm tỉnh thành</a></li>
        <li class="breadcrumb-item active" aria-current="page">Danh sách tỉnh thành</li>
    </ol>
    </nav>
</div>
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Bảng tỉnh thành</h4>
                </p>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Tên tỉnh thành</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lstTinhThanh as $item)
                                <tr>
                                     <td>{{ $item->id }}</td>
                                     <td>
                                         <a href="{{ route('tinhThanh.show', ['tinhThanh'=>$item]) }}">{{ $item->tenTinhThanh }}</a>
                                     </td>
                                     <td>
                                        <label class="badge badge-primary">
                                            <a class="d-block text-light" href="{{ route('tinhThanh.edit', ['tinhThanh'=>$item]) }}"> Sửa</a>
                                        </label>
                                        <label >
                                            <form method="post" action="{{ route('tinhThanh.destroy', ['tinhThanh'=>$item]) }}">
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
                    {{ $lstTinhThanh->links() }}
            </div>
        </div>
    </div>
</div>
@endsection