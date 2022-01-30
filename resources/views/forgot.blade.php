@extends('layouts.login')

@section('title','Quên mật khẩu')


@section('content')
<div class="card-body px-5 py-5">
  <h3 class="card-title text-left mb-3">Lấy lại mật khẩu</h3>
    @if(session('message')) 
      <label class="text-success" >{{ session('message') }}</label>
    @else 
      <p>Vui lòng nhập email mà bạn đã đăng ký tài khoản trên hệ thống của chúng tôi</p>
    @endif
  @if($errors->any()) 
          @foreach ($errors->all() as $err)
              <li class="card-description" style="color: #fc424a;">{{ $err }}</li>
          @endforeach
  @endif
  <form method="post" action="{{ route("forgot") }}">
    @csrf
    
    <div class="form-group">
      <label>Email</label>
      <input type="text" name="email" class="form-control p_input text-light" placeholder="Nhập email để đặt lại mật khẩu">
    </div>
    <div class="text-center">
      <input type="submit" class="btn btn-primary btn-block enter-btn" value="Gửi email xác nhận">
    </div>
  </form>
</div>
@endsection
