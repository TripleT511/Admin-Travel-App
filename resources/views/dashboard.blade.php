@extends('layouts.admin')

@section('title','Corona Admin')


@section('content')
<div class="row justify-content-center">
    <div class="col-sm-4 grid-margin">
        <div class="card">
            <div class="card-body">
            <h5>Tổng số tài khoản</h5>
            <div class="row">
                <div class="col-8 col-sm-12 col-xl-8 my-auto">
                <div class="d-flex d-sm-block d-md-flex align-items-center">
                    <h2 class="mb-0">{{ $lstTaiKhoan }}</h2>
                    <p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p>
                </div>
                <h6 class="text-muted font-weight-normal">11.38% Since last month</h6>
                </div>
                <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                <i class="icon-lg mdi mdi-account-multiple text-primary ml-auto"></i>
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4 grid-margin">
        <div class="card">
            <div class="card-body">
            <h5>Tổng địa danh</h5>
            <div class="row">
                <div class="col-8 col-sm-12 col-xl-8 my-auto">
                <div class="d-flex d-sm-block d-md-flex align-items-center">
                    <h2 class="mb-0">{{ $lstDiaDanh }}</h2>
                    <p class="text-success ml-2 mb-0 font-weight-medium">+8.3%</p>
                </div>
                <h6 class="text-muted font-weight-normal"> 9.61% Since last month</h6>
                </div>
                <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                <i class="icon-lg mdi mdi-map text-danger ml-auto"></i>
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4 grid-margin">
        <div class="card">
            <div class="card-body">
            <h5>Tổng số tỉnh thành</h5>
            <div class="row">
                <div class="col-8 col-sm-12 col-xl-8 my-auto">
                <div class="d-flex d-sm-block d-md-flex align-items-center">
                    <h2 class="mb-0">{{ $lstTinhThanh }}</h2>
                    <p class="text-danger ml-2 mb-0 font-weight-medium">-2.1% </p>
                </div>
                <h6 class="text-muted font-weight-normal">2.27% Since last month</h6>
                </div>
                <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                <i class="icon-lg mdi mdi-wallet-travel text-success ml-auto"></i>
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4 grid-margin">
        <div class="card">
            <div class="card-body">
            <h5>Tổng số bài viết</h5>
            <div class="row">
                <div class="col-8 col-sm-12 col-xl-8 my-auto">
                <div class="d-flex d-sm-block d-md-flex align-items-center">
                    <h2 class="mb-0">{{ $lstBaiViet }}</h2>
                    <p class="text-danger ml-2 mb-0 font-weight-medium">-2.1% </p>
                </div>
                <h6 class="text-muted font-weight-normal">2.27% Since last month</h6>
                </div>
                <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                <i class="icon-lg mdi mdi-newspaper text-warning ml-auto"></i>
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4 grid-margin">
        <div class="card">
            <div class="card-body">
            <h5>Tổng số đề xuất</h5>
            <div class="row">
                <div class="col-8 col-sm-12 col-xl-8 my-auto">
                <div class="d-flex d-sm-block d-md-flex align-items-center">
                    <h2 class="mb-0">{{ $lstDeXuat }}</h2>
                    <p class="text-danger ml-2 mb-0 font-weight-medium">-2.1% </p>
                </div>
                <h6 class="text-muted font-weight-normal">2.27% Since last month</h6>
                </div>
                <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                <i class="icon-lg mdi mdi-message-text text-primary ml-auto"></i>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<canvas id="myChart" width="400" height="150"></canvas>

@endsection