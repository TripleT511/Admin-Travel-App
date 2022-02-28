@extends('layouts.admin')

@section('title','Chi tiết tài khoản')

@section('content')

<div class="page-header card">
    <div class="card-body table">
        <dl class="row">
        <dt class="col-sm-2 text-light">
            Ảnh đại diện:
        </dt>
        <dd class="col-sm-10">
            <img src="{{ asset($user->hinhAnh) }}" width="150" height="150" />
        </dd>
        <dt class="col-sm-2 text-light">
            Họ tên
        </dt>
        <dd class="col-sm-10">
            <span>{{ $user->hoTen }}</span>
        </dd>
        <dt class="col-sm-2 text-light">
            Email:
        </dt>
        <dd class="col-sm-10">
            <span>{{ $user->email }}</span>
        </dd>
        <dt class="col-sm-2 text-light">
            Số điện thoại:
        </dt>
        <dd class="col-sm-10">
            <span>{{ $user->soDienThoai }}</span>
        </dd>
        <dt class="col-sm-2 text-light">
            Loại tài khoản:
        </dt>
        <dd class="col-sm-10">
            <span> 
                @if($user->idPhanQuyen == 0) Admin
                @else Người dùng
                @endif
            </span>
        </dd>
        <dt class="col-sm-2 text-light">
            Số bài viết đã đăng:
        </dt>
        <dd class="col-sm-10">
            <span>{{ $user->baiviets_count }}</span>
        </dd>
        <dt class="col-sm-2 text-light">
            Số tỉnh thành đã đi:
        </dt>
        <dd class="col-sm-10">
            <span>{{ $user->tinhthanhs_count }}</span>
        </dd>
    </dl>
    </div>
</div>

@endsection