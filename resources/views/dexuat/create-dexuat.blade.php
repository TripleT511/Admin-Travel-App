@extends('layouts.admin')

@section('title','Thêm đề xuất')


@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Thêm đề xuất</h4>
            @if($errors->any())
            @foreach ($errors->all() as $err)
            <li class="card-description" style="color: #fc424a;">{{ $err }}</li>
            @endforeach
            @endif
            <hr>
            <form class="forms-sample" action="{{ route('deXuat.store') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="exampleInputName1">Tên địa danh</label>
                    <input type="text" class="form-control text-light" name="tenDiaDanh" placeholder="Tên địa danh">
                </div>
                <div class="form-group">
                    <label for="exampleTextarea1">Mô tả</label>
                    <input type="text" class="form-control text-light" name="moTa" placeholder="Mô tả">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword4">Vĩ độ</label>
                    <input type="text" class="form-control text-light" name="viDo" placeholder="Vĩ độ">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword4">Kinh độ</label>
                    <input type="text" class="form-control text-light" name="kinhDo" placeholder="Kinh độ">
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
                <div class="form-group">
                    <label for="exampleInputPassword4">Tỉnh thành</label>
                    <select class="form-control text-light" name="idTinhThanh">
                        @foreach ($lstTinhThanh as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->tenTinhThanh}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <input type="submit" class="btn btn-primary mr-2" value="Submit">
                <button class="btn btn-dark">Cancel</button>
            </form>
        </div>
    </div>
</div>
@endsection