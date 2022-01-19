@extends('layouts.admin')

@section('title','Chỉnh sửa địa danh')


@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Chỉnh sửa địa danh</h4>
             @if($errors->any()) 
                    @foreach ($errors->all() as $err)
                        <li class="card-description" style="color: #fc424a;">{{ $err }}</li>
                    @endforeach
                @endif
            <hr>
            <form class="forms-sample" action="{{ route('diaDanh.update', ['diaDanh'=>$diaDanh]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method("PATCH")
                <div class="form-group">
                    <label for="exampleInputName1">Tên địa danh</label>
                     <input type="text" class="form-control text-light" value="{{ $diaDanh->tenDiaDanh }}"  name="tenDiaDanh" placeholder="Tên địa danh">
                </div>
                <div class="form-group">
                        <label for="exampleTextarea1">Mô tả</label>
                        <input type="text" class="form-control text-light" name="moTa" value="{{ $diaDanh->moTa }}" placeholder="Mô tả">
                      </div>
                <div class="form-group">
                    <label for="exampleInputPassword4">Kinh độ</label>
                     <input type="text" class="form-control text-light" name="kinhDo" value="{{ $diaDanh->kinhDo }}" placeholder="Kinh độ">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword4">Vĩ độ</label>
                     <input type="text" class="form-control text-light" name="viDo" value="{{ $diaDanh->viDo }}" placeholder="Vĩ độ">
                </div>
                <div class="form-group">
                    @foreach ($hinhAnh as $item)
                     <img src="{{ asset($item->hinhAnh) }}" width="150" />
                    @endforeach
                </div>
                <div class="form-group">
                    <label>Hình ảnh</label>
                    <input type="file" name="hinhAnh[]" class="file-upload-default" multiple>
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image">
                        <span class="input-group-append">
                        <button class="file-upload-browse btn btn-primary" type="button">Upload hình ảnh</button>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword4">Tỉnh thành</label>
                    <select class="form-control text-light " name="idTinhThanh">
                        @foreach ($lstTinhThanh as $item)
                            <option value="{{ $item->id }}" @if($diaDanh->tinh_thanh_id == $item->id) selected @endif>
                             {{ $item->tenTinhThanh}}
                            </option>
                        @endforeach
                    </select>
                </div>
               <div class="form-check form-check-primary">
                    <label class="form-check-label">
                    <input type="checkbox" name="trangThai" class="form-check-input" @if($diaDanh->trangThai == 1) checked @endif > Trạng thái </label>
                </div>
                <input type="submit" class="btn btn-primary mr-2" value="Submit">
                <button type="text" class="btn btn-dark">Cancel</button>
            </form>
        </div>
    </div>
</div>
@endsection