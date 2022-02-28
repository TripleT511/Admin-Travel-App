@extends('layouts.admin')

@section('title','Chỉnh sửa địa danh')


@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Chỉnh sửa địa danh nhu cầu</h4>
             @if(session('error')) 
                <li class="text-danger" >{{ session('error') }}</li>
            @endif
            <form class="forms-sample" action="{{ route('diaDanhNhuCau.update', ['diaDanhNhuCau'=>$diaDanhNhuCau->id]) }}" method="post">
                @csrf
                @method("PATCH")
                <div class="form-group">
                    <label for="exampleInputName1">Tên địa danh</label>
                     <select class="form-control text-light" name="idDiaDanh" id="">
                         @foreach($lstDiaDanh as $dd)
                            <option value="{{$dd->id}}" @if($dd->id == $diaDanhNhuCau->diadanh->id) selected @endif>{{$dd->tenDiaDanh}}</option>
                         @endforeach
                     </select>
                </div>
                <div class="form-group">
                        <label for="exampleTextarea1">Nhu cầu</label>
                        <select class="form-control text-light" name="idNhuCau" id="">
                         @foreach($lstNhuCau as $nc)
                            <option value="{{$nc->id}}" @if($nc->id == $diaDanhNhuCau->nhucau->id) selected @endif>{{$nc->tenNhuCau}}</option>
                         @endforeach
                     </select>
                      </div>
                <input type="submit" class="btn btn-primary mr-2" value="Submit">
                <button type="text" class="btn btn-dark">Cancel</button>
            </form>
        </div>
    </div>
</div>
@endsection
