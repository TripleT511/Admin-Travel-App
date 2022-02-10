@extends('layouts.admin')

@section('title','Chi tiết tài khoản')

@section('content')

<div class="detail ">
    <h1>{{$taiKhoan->hoTen}}</h1> <br>

    <img src="@if($taiKhoan->hinhAnh != null) {{ asset($taiKhoan->hinhAnh) }}
                                                      @else '/images/no-image-available.jpg'
                                                      @endif" width="250"/> <br>

    <h4> 
    <i class="mdi mdi-gmail"></i>  <span class="">{{$taiKhoan->email}}</span><br> 
       
    </h4>
    <h4>
    <i class="mdi mdi-phone"></i>  <span class="">{{$taiKhoan->soDienThoai}}</span><br> 
    </h4>
    <h4>

  
</div>

@endsection