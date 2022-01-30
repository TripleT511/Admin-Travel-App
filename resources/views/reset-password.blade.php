@extends('layouts.login')

@section('title','Đặt lại mật khẩu')

@section('content')
<div class="card-body px-5 py-5">
  <h3 class="card-title text-left mb-3">Đặt lại mật khẩu</h3>
    @if(session('message')) 
        <label class="text-success" >{{ session('message') }}</label>
    @endif
  @if($errors->any()) 
        @foreach ($errors->all() as $err)
            <li class="card-description" style="color: #fc424a;">{{ $err }}</li>
        @endforeach
  @endif
  <form method="post" action="{{ route("reset") }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <div class="form-group">
      <label>Email</label>
      <input type="text" name="email" value="{{ $email }}" class="form-control p_input text-light">
    </div>
    <div class="form-group">
      <label>Mật khẩu</label>
      <input type="text" name="password" class="form-control p_input text-light" placeholder="Nhập mật khẩu mới">
    </div>
    <div class="form-group">
      <label>Xác nhận mật khẩu</label>
      <input type="text" name="confirm-password" class="form-control p_input text-light" placeholder="Nhập lại mật khẩu mới">
    </div>
    <div class="text-center">
      <input type="submit" class="btn btn-primary btn-block enter-btn" value="Đặt lại mật khẩu">
    </div>
  </form>
</div>
@endsection
