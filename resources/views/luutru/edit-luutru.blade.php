@extends('layouts.admin')

@section('title','Sửa lưu trú')


@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Sửa lưu trú</h4>
            <form class="forms-sample" action="{{ route('luuTru.update', ['luuTru' => $luuTru]) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                @method("PATCH")
                <div class="form-group">
                    <label for="exampleInputPassword4">Địa danh</label>
                    <select class="form-control text-light " name="dia_danh_id">
                        @foreach ($lstDiaDanh as $item)
                        <option value="{{ $item->id }}" @if($luuTru->dia_danh_id == $item->id) selected @endif>
                            {{ $item->tenDiaDanh}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleTextarea1">Tên lưu trú</label>
                    <input type="text" class="form-control text-light" name="tenLuuTru" value="{{ $luuTru->tenLuuTru }}"
                        placeholder="Tên quán">
                </div>
                <div class="form-group">
                    <label for="exampleTextarea1">Mô tả</label>
                    <input type="text" class="form-control text-light" name="moTa" value="{{ $luuTru->moTa }}"
                        placeholder="Mô tả">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword4">Địa chỉ</label>
                    <input type="text" class="form-control text-light" name="diaChi" value="{{ $luuTru->diaChi}}"
                        placeholder="Địa chỉ">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword4">Số điện thoại</label>
                    <input type="text" class="form-control text-light" name="sdt" value="{{ $luuTru->sdt}}"
                        placeholder="Số điện thoại">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword4">Thời gian hoạt động</label>
                    <input type="text" class="form-control text-light" name="thoiGianHoatDong"
                        value="{{ $luuTru->thoiGianHoatDong}}" placeholder="Thời gian hoạt động">
                </div>
                <div class="form-group">
                    <img src="{{ asset($luuTru->hinhAnh) }}" width="200" />
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
                <input type="submit" class="btn btn-primary mr-2" value="Submit">
                <button type="text" class="btn btn-dark">Cancel</button>
            </form>
        </div>
    </div>
</div>
@endsection