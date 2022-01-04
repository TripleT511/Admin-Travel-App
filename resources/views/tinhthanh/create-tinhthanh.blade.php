@extends('layouts.admin')

@section('title','Thêm tỉnh thành')

@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Thêm tỉnh thành</h4>
             @if($errors->any()) 
                    @foreach ($errors->all() as $err)
                        <li class="card-description" style="color: #fc424a;">{{ $err }}</li>
                    @endforeach
                @endif
            <hr>
            <form class="forms-sample" action="{{ route('tinhThanh.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="exampleInputName1">Tên tỉnh thành</label>
                     <input type="text" class="form-control text-light"  name="tenTinhThanh" placeholder="Tên tỉnh thành">
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