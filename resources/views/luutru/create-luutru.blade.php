@extends('layouts.admin')

@section('title','Thêm lưu trú')


@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Thêm lưu trú</h4>
            @if($errors->any())
            @foreach ($errors->all() as $err)
            <li class="card-description" style="color: #fc424a;">{{ $err }}</li>
            @endforeach
            @endif
            <br>
            <form class="forms-sample" action="{{ route('luuTru.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="exampleInputPassword4">Địa Danh</label>
                    <select class="form-control text-light" name="dia_danh_id">
                        @foreach($lstDiaDanh as $dd)
                        <option value="{{$dd->id}}">{{$dd->tenDiaDanh}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleTextarea1">Tên lưu trú</label>
                    <input type="text" class="form-control text-light" name="tenLuuTru" placeholder="Tên lưu trú">
                </div>
                <div class="form-group">
                    <label for="exampleTextarea1">Mô tả</label>
                    <input type="text" class="form-control text-light" name="moTa" placeholder="Mô tả">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword4">Địa chỉ</label>
                    <input type="text" class="form-control text-light" name="diaChi" placeholder="Địa chỉ">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword4">Số điện thoại</label>
                    <input type="text" class="form-control text-light" name="sdt" placeholder="Số điện thoại">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword4">Thời gian hoạt động</label>
                    <input type="text" class="form-control text-light" name="thoiGianHoatDong">
                </div>
                <div class="form-group">
                    <label>Hình ảnh</label>
                    <input type="file" name="hinhAnh" class="file-upload-default">
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" placeholder="Upload Image">
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button">Upload hình ảnh</button>
                        </span>
                    </div>
                </div>
                <input type="submit" class="btn btn-primary mr-2" value="Submit">
                <button type="text" class="btn btn-dark">Cancel</button>
            </form>
        </div>
    </div>
</div>
@endsection