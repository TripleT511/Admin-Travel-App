@extends('layouts.admin')

@section('title','Đề xuất địa danh')

@section('content')
<div class="row">
    <div class="col col-lg-6 col-md-12">
        <div class="nav-link d-lg-flex search align-items-center">
            <select id="fill" class="form-control text-light m-1">
                <option value="0">--Chọn--</option>
                <option value="1">Chờ duyệt</option>
                <option value="2">Đã duyệt</option>
                <option value="3">Đã xoá</option>
            </select>
            <button class="btn btn-primary" id="loc">Lọc</button>
        </div>
    </div>
</div>
<div class="page-header">
    <h3 class="page-title"> Đề xuất địa danh </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
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
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody id="lstDeXuat">
                            @foreach ($lstDeXuat as $item)
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
                                    <img src="{{ asset($item->hinhAnh) }}" width="150" />
                                </td>
                                <td>{{ $item->tinhthanh->tenTinhThanh }}</td>
                                <td>
                                    @if ($item->trangThai == 0 && $item->deleted_at == null) 
                                        <label>
                                            <form method="post"
                                                action="{{ route('deXuat.update', ['deXuat'=>$item]) }}">
                                                @csrf
                                                @method("PATCH")
                                                <button style="outline: none; border: none" class="badge badge-primary"
                                                    type="submit">Duyệt</button>
                                            </form>
                                        </label>
                                        <label>
                                            <form method="post"
                                                action="{{ route('deXuat.destroy', ['deXuat'=>$item]) }}">
                                                @csrf
                                                @method("DELETE")
                                                <button style="outline: none; border: none" class="badge badge-danger"
                                                    type="submit">Xoá</button>
                                            </form>
                                        </label>
                                    @elseif ($item->trangThai == 1  && $item->deleted_at == null)
                                        <label class="badge badge-success">Đã duyệt</label>
                                    @else
                                        <label class="badge badge-danger">Đã xoá</label>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="pagination d-flex justify-content-center">
                    {{ $lstDeXuat->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
        $(document).ready(function() {

            // Lọc
            $('#loc').on('click', function() {
                var val = $('#fill').val();
                if(val == 0) {
                    alert("Vui lòng chọn tiêu chí");
                    return;
                }
                $.ajax({
                    type: "get",
                    url: "/dexuat/fill",
                    data: {
                        fill: val
                    },
                    dataType: "json",
                    success: function (response) {
                        $("#lstDeXuat").html(response);
                      
                    }
                });
            });
        });
    </script>

@endsection 