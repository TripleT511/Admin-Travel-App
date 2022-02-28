@extends('layouts.admin')

@section('title','Chi tiết tỉnh thành')

@section('content')
<div class="page-header card">
    <div class="card-body table">
        <dl class="row">
            <dt class="col-sm-2 text-light">
                Tên địa danh
            </dt>
            <dd class="col-sm-10">
                <span>{{ $diaDanhNhuCau->diadanh->tenDiaDanh }}</span>
            </dd>
            <dt class="col-sm-2 text-light">
                Tên nhu cầu
            </dt>
            <dd class="col-sm-10">
                <span>{{ $diaDanhNhuCau->nhucau->tenNhuCau }}</span>
            </dd>
        </dl>
    </div>
</div>

@endsection