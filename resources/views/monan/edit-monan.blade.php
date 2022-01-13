@extends('layouts.admin')

@section('title','Sửa món ăn')


@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Sửa món ăn</h4>
            <form class="forms-sample" action="{{ route('monAn.update', ['monAn' => $monAn]) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                @method("PATCH")
                <div class="form-group">
                    <label for="exampleInputPassword4">Tên Quán Ăn</label>
                    <select class="form-control text-light " name="quan_an_id">
                        @foreach ($lstQuanAn as $item)
                        <option value="{{ $item->id }}" @if($monAn->quan_an_id == $item->id) selected @endif>
                            {{ $item->tenQuan}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleTextarea1">Tên món</label>
                    <input type="text" value="{{$monAn->tenMon}}" class="form-control text-light" name="tenMon"
                        placeholder="Tên món ăn">
                </div>
                <div class="form-group">
                    <img src="{{ asset($monAn-> hinhAnh) }}" width="200" />
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
                        <input type="checkbox" name="trangThai" class="form-check-input" @if($monAn->trangThai == 1)
                        checked @endif > Trạng thái </label>
                </div>
                <input type="submit" class="btn btn-primary mr-2" value="Submit">
                <button type="text" class="btn btn-dark">Cancel</button>
            </form>
        </div>
    </div>
</div>
@endsection