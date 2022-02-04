@extends('layouts.admin')

@section('title','Thêm món ăn')


@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Thêm món ăn</h4>
            @if($errors->any())
            @foreach ($errors->all() as $err)
            <li class="card-description" style="color: #fc424a;">{{ $err }}</li>
            @endforeach
            @endif
            <br>
            <form class="forms-sample" action="{{ route('monAn.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="exampleInputPassword4">Tên quán ăn</label>
                    <select class="form-control text-light" name="quan_an_id">
                        @foreach($lstQuanAn as $qa)
                        <option value="{{$qa->id}}">{{$qa->tenQuan}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleTextarea1">Tên món</label>
                    <input type="text" class="form-control text-light" name="tenMon" placeholder="Tên món">
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