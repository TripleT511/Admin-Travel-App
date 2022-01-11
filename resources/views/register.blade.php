@extends('layouts.admin')

@section('title','Thêm tài khoản')

@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Thêm tài khoản</h4>
                @if($errors->any()) 
                    @foreach ($errors->all() as $err)
                        <li class="card-description" style="color: #fc424a;">{{ $err }}</li>
                    @endforeach
                @endif
            <hr>
            <form class="forms-sample" action="{{ route('register') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <label>Username</label>
                  <input type="text" name="hoTen" class="form-control text-light"  >
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="email" name="email" class="form-control text-light" >
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input type="password" name="password" class="form-control text-light">
                </div>
                <div class="form-group">
                  <label>Số điện thoại</label>
                  <input type="text" name="soDienThoai" class="form-control text-light">
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
                    <label for="exampleInputPassword4">Loại tài khoản</label>
                    <select class="form-control text-light" name="idPhanQuyen">
                            <option value="0">
                              Admin
                            </option>
                            <option value="1">
                              User
                            </option>
                    </select>
                </div>
                <input type="submit" class="btn btn-primary mr-2" value="Submit">
                <button class="btn btn-dark">Cancel</button>
            </form>
        </div>
    </div>
</div>
@endsection
