@extends('layouts.admin')

@section('title','Danh sách địa danh')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Danh sách nhu cầu </h3>
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('nhuCau.create') }}">Thêm Nhu Cầu</a></li>
        <li class="breadcrumb-item active" aria-current="page">Danh sách nhu cầu</li>
    </ol>
    </nav>
</div>
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Bảng nhu cầu</h4>
                </p>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Tên Nhu Cầu</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach ($lstNhuCau as $item)
                                <tr>
                                     <td>{{ $item->id }}</td>
                                     <td>{{ $item->tenNhuCau }}</td>
                                     <td>
                                        <label class="badge badge-primary">
                                            <a class="d-block text-light" href="{{ route('nhuCau.edit', ['nhuCau'=>$item]) }}"> Sửa</a>
                                        </label>
                                        <label class="badge badge-success">
                                            <a class="d-block text-light" href="{{ route('nhuCau.show', ['nhuCau'=>$item]) }}"> Show</a>
                                        </label>
                                        <label >
                                            <form method="post" action="{{ route('nhuCau.destroy', ['nhuCau'=>$item]) }}">
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