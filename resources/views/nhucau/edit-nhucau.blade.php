@extends('layouts.admin')

@section('title','Chỉnh sửa nhu cầu')


@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Chỉnh sửa nhu cầu</h4>
            <form class="forms-sample" action="{{ route('nhuCau.update', ['nhuCau'=>$nhuCau]) }}" method="post">
                @csrf
                @method("PATCH")
                <div class="form-group">
                    <label for="exampleInputName1">Tên nhu cầu</label>
                     <input type="text" class="form-control text-light" value="{{ $nhuCau->tenNhuCau }}"  name="tenNhuCau" placeholder="Tên nhu cầu">
                </div>
                <input type="submit" class="btn btn-primary mr-2" value="Submit">
                <button type="text" class="btn btn-dark">Cancel</button>
            </form>
        </div>
    </div>
</div>
@endsection