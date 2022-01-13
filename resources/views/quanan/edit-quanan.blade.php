@extends('layouts.admin')

@section('title','Chỉnh sửa quán ăn')


@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Chỉnh sửa quán ăn</h4>
            @if($errors->any())
            @foreach ($errors->all() as $err)
            <li class="card-description" style="color: #fc424a;">{{ $err }}</li>
            @endforeach
            @endif
            <hr>
            <form class="forms-sample" action="{{ route('quanAn.update', ['quanAn'=>$quanAn]) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                @method("PATCH")
                <div class="form-group">
                    <label for="exampleInputPassword4">Tên địa danh</label>
                    <select class="form-control text-light " name="dia_danh_id">
                        @foreach($lstDiaDanh as $dd)
                        <option value="{{$dd->id}}" @if($quanAn->dia_danh_id == $dd->id) selected
                            @endif>{{$dd->tenDiaDanh}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleTextarea1">Tên quán</label>
                    <input type="text" class="form-control text-light" name="tenQuan" value="{{ $quanAn->tenQuan }}"
                        placeholder="Tên quán">
                </div>
                <div class="form-group">
                    <label for="exampleTextarea1">Mô tả</label>
                    <input type="text" class="form-control text-light" name="moTa" value="{{ $quanAn->moTa }}"
                        placeholder="Mô tả">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword4">Địa chỉ</label>
                    <input type="text" class="form-control text-light" name="diaChi" value="{{ $quanAn->diaChi}}"
                        placeholder="Địa chỉ">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword4">Số điện thoại</label>
                    <input type="text" class="form-control text-light" name="soDienThoai" value="{{ $quanAn->sdt}}"
                        placeholder="Số điện thoại">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword4">Thời gian hoạt động</label>
                    <input type="text" class="form-control text-light" name="thoiGianHoatDong"
                        value="{{ $quanAn->thoiGianHoatDong}}" placeholder="Thời gian hoạt động">
                </div>
                <div class="form-group">
                    <img src="{{ asset($quanAn->hinhAnh) }}" width="200" />
                </div>
                <div class="form-group">
                    <label>Hình ảnh</label>
                    <input type="file" name="hinhAnh" class="file-upload-default">
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image">
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button">Upload hình ảnh</button>
                        </span>
                    </div>
                </div>
                <div class="form-check form-check-primary">
                    <label class="form-check-label">
                        <input type="checkbox" name="trangThai" class="form-check-input" @if($quanAn->trangThai == 1)
                        checked @endif > Trạng thái </label>
                </div>
                <input type="submit" class="btn btn-primary mr-2" value="Submit">
                <button type="text" class="btn btn-dark">Cancel</button>
            </form>
        </div>
    </div>
</div>
@endsection