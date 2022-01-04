   
@extends('layouts.admin')

@section('title','Thêm hình ảnh')

@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Thêm hình ảnh</h4>
             @if($errors->any()) 
                    @foreach ($errors->all() as $err)
                        <li class="card-description" style="color: #fc424a;">{{ $err }}</li>
                    @endforeach
                @endif
            <hr>
            <form class="forms-sample" action="{{ route('hinhAnh.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="exampleInputName1">Tên địa danh</label>
                     <select class="form-control text-light" name="idDiaDanh" >
                         @foreach($lstDiaDanh as $dd)
                            <option value="{{$dd->id}}">{{$dd->tenDiaDanh}}</option>
                         @endforeach
                     </select>
                </div>
                <div class="form-group">
                    <label>Hình ảnh</label>
                    <input type="file" name="hinhAnh" class="file-upload-default">
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image">
                        <span class="input-group-append">
                        <button class="file-upload-browse btn btn-primary" type="button">Upload Hình ảnh</button>
                        </span>
                    </div>
                </div>
               <div class="form-check form-check-primary">
                    <label class="form-check-label">
                    <input type="checkbox" name="trangThai" class="form-check-input" checked> Trạng thái </label>
                </div>
                <input type="submit" class="btn btn-primary mr-2" value="Submit">
                <button class="btn btn-dark">Cancel</button>
            </form>
        </div>
    </div>
</div>
@endsection