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
                </div>
                </div>
                <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                <i class="icon-lg mdi mdi-account-multiple  ml-auto" style="color: #FBAC00"></i>
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
                    
                </div>
                </div>
                <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                <i class="icon-lg mdi mdi-map text-danger ml-auto" style="color: rgb(255, 45, 85)"></i>
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
                </div>
                </div>
                <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                <i class="icon-lg mdi mdi-map-marker-multiple ml-auto" style="color: #0066ff"></i>
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
                </div>
                </div>
                <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                <i class="icon-lg mdi mdi-newspaper text-success  ml-auto" ></i>
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4 grid-margin">
        <div class="card">
            <div class="card-body">
            <h5>Địa danh nổi bật</h5>
            <div class="row">
                <div class="col-8 col-sm-12 col-xl-8 my-auto">
                <div class="d-flex d-sm-block d-md-flex align-items-center">
                    <h2 class="mb-0">{{ $diaDanh->tenDiaDanh }}</h2>
                </div>
                </div>
                <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                <i class="icon-lg mdi mdi-home-map-marker ml-auto" style="color:#FB00A4"></i>
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
                </div>
                </div>
                <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                <i class="icon-lg mdi mdi-image-filter   ml-auto" style="color: #8f5fe8"></i>
                </div>
            </div>
            </div>
        </div>
    </div>
    
</div>
<div class="row">
    <div id="data">

    </div>
    <div class="col col-lg-4">
        <canvas id="myChart" width="200" height="100"></canvas>
    </div>
    <div class="col col-lg-8">
        <canvas id="myChart2" width="200" height="100"></canvas>
    </div>
</div>


@endsection
@section('js')
<script>
        $(document).ready(function() {
            const data = [];

            //Data thống kê chart
            $.ajax({
                type: "get",
                url: "/dashboard/thongke",
                dataType: "json",
                success: function (response) {
                    $("#data").html(response);
                    const ctx = document.getElementById('myChart').getContext('2d');
                        const myChart = new Chart(ctx, {
                            type: 'doughnut',
                            data: {
                                labels: ['Tổng số lượt like tháng này', 'Tổng số lượt unlike tháng này', 'Tổng số lượt xem tháng này'],
                                datasets: [{
                                    label: [
                                        'Lượt like',
                                        'Lượt unlike',
                                        'Lượt xem'
                                    ],
                                    data: [$('#like').val(), $('#unlike').val(), $('#view').val()],
                                    backgroundColor: [
                                        'rgb(0, 102, 255)',
                                        'rgb(255, 45, 85)',
                                        'rgb(0, 214, 61)'
                                    ],
                                    hoverOffset: 4,
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    const listThang = document.querySelectorAll('#thang');
                    listThang.forEach(item => {
                        data.push(item.value);
                    });
                    const ctx2 = document.getElementById('myChart2').getContext('2d');
                    const myChart2 = new Chart(ctx2, {
                        type: 'bar',
                        data: {
                            labels: [
                                'Tháng 1',
                                'Tháng 2',
                                'Tháng 3',
                                'Tháng 4',
                                'Tháng 5',
                                'Tháng 6',
                                'Tháng 7',
                                'Tháng 8',
                                'Tháng 9',
                                'Tháng 10',
                                'Tháng 11',
                                'Tháng 12',

                            ],
                            datasets: [{
                                label: 'Thống kê lượt tương tác các tháng trong năm',
                                data: data,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(255, 159, 64, 0.2)',
                                    'rgba(255, 205, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(201, 203, 207, 0.2)'
                                ],
                                borderColor: [
                                    'rgb(255, 99, 132)',
                                    'rgb(255, 159, 64)',
                                    'rgb(255, 205, 86)',
                                    'rgb(75, 192, 192)',
                                    'rgb(54, 162, 235)',
                                    'rgb(153, 102, 255)',
                                    'rgb(201, 203, 207)'
                                ],
                                borderWidth: 1,
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }
            });

            
        });
    </script>

@endsection