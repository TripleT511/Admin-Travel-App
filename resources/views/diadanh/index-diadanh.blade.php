@extends('layouts.admin')

@section('title','Danh sách địa danh')

@section('content')
<div class="row">
    <div class="col col-lg-6 col-md-12">
        <div class="nav-link d-lg-flex search align-items-center">
            <input type="text" id="txtSearch" name="txtSearch" class="form-control m-1 text-light" placeholder="Tìm kiếm">
            <select class="form-control text-light m-1" id="idTinhThanh">
                <option value="0">--Chọn tên tỉnh thành--</option>
                @foreach ($lstTinhThanh as $item)
                    <option value="{{ $item->id }}">
                        {{ $item->tenTinhThanh}}
                    </option>
                @endforeach
            </select>
            <button class="btn btn-primary" id="search">Tìm kiếm</button>
        </div>
    </div>
</div>
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
                                <th>Kinh độ</th>
                                <th>Vĩ độ</th>
                                <th>Hình ảnh</th>
                                <th>Tỉnh thành</th>
                                <th>Lượt chia sẻ</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody  id="lstDiaDanh">
                           @foreach ($lstDiaDanh as $item)
                                <tr>
                                     <td>{{ $item->id }}</td>
                                     <td>
                                         <a href="{{ route('diaDanh.show', ['diaDanh'=>$item]) }}">
                                             {{ $item->tenDiaDanh }}
                                         </a>
                                     </td>
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
            <div class="pagination d-flex justify-content-center">
                    {{ $lstDiaDanh->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
        $(document).ready(function() {

            // //Search DiaDanh
            $('#search').on('click', function() {
                var val = $('#txtSearch').val();
                $.ajax({
                    type: "get",
                    url: "/diadanh/search",
                    data: {
                        txtSearch: val,
                        idTinhThanh: $("#idTinhThanh").val()
                    },
                    dataType: "json",
                    success: function (response) {
                        $("#lstDiaDanh").html(response);
                    }
                });
            });
        });
    </script>

@endsection