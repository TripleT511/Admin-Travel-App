@extends('layouts.admin')

@section('title','Thêm nhu cầu')


@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Thêm nhu cầu</h4>
             @if($errors->any()) 
                    @foreach ($errors->all() as $err)
                        <li class="card-description" style="color: #fc424a;">{{ $err }}</li>
                    @endforeach
                @endif
            <hr>
            <form class="forms-sample" action="{{ route('nhuCau.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="exampleInputName1">Tên nhu cầu</label>
                     <input type="text" class="form-control text-light"  name="tenNhuCau" placeholder="Tên nhu cầu">
                </div>
                <input type="submit" class="btn btn-primary mr-2" value="Submit">
                <button class="btn btn-dark">Cancel</button>
            </form>
        </div>
    </div>
</div>
@endsection