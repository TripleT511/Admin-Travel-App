@extends('layouts.admin')

@section('title','Chỉnh sửa tỉnh thành')


@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Chỉnh sửa tỉnh thành</h4>
            <form class="forms-sample" action="{{ route('tinhThanh.update', ['tinhThanh'=>$tinhThanh]) }}" method="post">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="exampleInputName1">Tên tỉnh thành</label>
                     <input type="text" class="form-control text-light"  name="tenTinhThanh" value="{{ $tinhThanh->tenTinhThanh }}" placeholder="Tên tỉnh thành">
                </div>
                <input type="submit" class="btn btn-primary mr-2" value="Submit">
                <button class="btn btn-dark">Cancel</button>
            </form>
        </div>
    </div>
</div>
@endsection