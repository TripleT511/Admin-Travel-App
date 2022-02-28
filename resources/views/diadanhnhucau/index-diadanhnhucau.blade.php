/*@extends('layouts.admin')

@section('title','Thêm địa danh nhu cầu')

@section('content')
<div class="row">
    <div class="col col-lg-6 col-md-12">
        <div class="nav-link d-lg-flex search align-items-center">
            <input type="text" id="txtSearch"  class="form-control m-1 text-light" placeholder="Tìm kiếm...">
            <select id="txtloc" class="form-control text-light m-1">
                <option value="1">Tên địa danh</option>
                <option value="2">Tên nhu cầu</option>
            </select>
            <button class="btn btn-primary" id="loc">Lọc</button>
        </div>
    </div>
</div>
<div class="page-header">
    <h3 class="page-title"> Danh sách địa danh nhu cầu </h3>
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('diaDanhNhuCau.create') }}">Thêm địa danh nhu cầu</a></li>
        <li class="breadcrumb-item active" aria-current="page">Danh sách địa danh nhu cầu</li>
    </ol>
    </nav>
</div>
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Bảng địa danh nhu cầu</h4>
                </p>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Tên địa danh</th>
                                <th>Tên nhu cầu</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="lstDiaDanh">
                           @foreach ($lstDiaDanhNhuCau as $item)
                                <tr>
                                     <td>{{ $item->id }}</td>
                                     <td>
                                         <a href="{{ route('diaDanhNhuCau.show', ['diaDanhNhuCau'=>$item]) }} }}">{{ $item->diadanh->tenDiaDanh }}</a>
                                        </td>
                                     <td>{{ $item->nhucau->tenNhuCau }}</td>

                                     <td>
                                        <label class="badge badge-primary">
                                            <a class="d-block text-light" href="{{ route('diaDanhNhuCau.edit', ['diaDanhNhuCau'=>$item]) }}"> Sửa</a>
                                        </label>
                                        <label >
                                            <form method="post" action="{{ route('diaDanhNhuCau.destroy', ['diaDanhNhuCau'=>$item]) }}">
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
                    {{ $lstDiaDanhNhuCau->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
        $(document).ready(function() {

            $('#loc').on('click', function() {
                var value = $('#txtSearch').val();
                if(value == "") {
                    alert("Vui lòng nhập thông tin");
                    return;
                }
                $.ajax({
                type: "get",
                url: "/diadanhnhucau/search",
                data: {
                    loai: $("#txtloc").val(),
                    noiDung: value
                },
                dataType: "json",
                success: function (response) {
                    $("#lstDiaDanh").html(response);
                    
                }
                });
            })

           
        });
    </script>

@endsection