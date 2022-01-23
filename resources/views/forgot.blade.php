@extends('layouts.login')

@section('title','Quên mật khẩu')


@section('content')
<div class="card-body px-5 py-5">
  <h3 class="card-title text-left mb-3">Quên mật khẩu</h3>
  <form method="post" action="">
    @csrf
    <div class="form-group">
      <label>Email</label>
      <input type="text" name="email" class="form-control p_input text-light" placeholder="Nhập email để đặt lại mật khẩu">
    </div>
    <div class="text-center">
      <input type="submit" class="btn btn-primary btn-block enter-btn" value="Đặt lại mật khẩu">
    </div>
  </form>
</div>
@endsection
