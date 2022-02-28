@extends('layouts.admin')

@section('title','Chi tiết tỉnh thành')

@section('content')
<div class="page-header card">
    <div class="card-body table">
        <dl class="row">
        <dt class = "col-sm-2 text-light">
            Tên địa danh
        </dt>
        <dd class = "col-sm-10">
            <h2 class="page-title" style="color: #6c7293"> {{ $diaDanh->tenDiaDanh }} </h2>
        </dd>
        <dt class = "col-sm-2 text-light">
            Mô tả:
        </dt>
        <dd class = "col-sm-10">
            <span>{{ $diaDanh->moTa }}</span>
        </dd>
        <dt class = "col-sm-2 text-light">
            Hình ảnh:
        </dt>
        <dd class = "col-sm-10">
            @foreach ($diaDanh->hinhanhs as $item)
                <img src="{{ asset($item->hinhAnh) }}" width="150" height="100" />
            @endforeach
        </dd>
        <dt class = "col-sm-2 text-light">
            Vĩ độ:
        </dt>
        <dd class = "col-sm-10">
            <span>{{ $diaDanh->viDo }}</span>
        </dd>
        <dt class = "col-sm-2 text-light">
            Kinh độ:
        </dt>
        <dd class = "col-sm-10">
            <span>{{ $diaDanh->kinhDo }}</span>
        </dd>
        <dt class = "col-sm-2 text-light">
            Tỉnh thành:
        </dt>
        <dd class = "col-sm-10">
            <span>{{ $diaDanh->tinhthanh->tenTinhThanh }}</span>
        </dd>
        <dt class = "col-sm-2 text-light">
            Nhu cầu:
        </dt>
        <dd class = "col-sm-10">
                @foreach ($nhucau as $item)
                    <li>{{ $item->nhucau->tenNhuCau }}</li>
                @endforeach
        </dd>
        <dt class = "col-sm-2 text-light">
            Lượt chia sẻ:
        </dt>
        <dd class = "col-sm-10">
            <span>{{ $diaDanh->shares_count }}</span>
        </dd>

    </dl>
    </div>
</div>

@endsection