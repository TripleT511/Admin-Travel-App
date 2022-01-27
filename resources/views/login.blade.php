@extends('layouts.login')

@section('title','Login')


@section('content')
<div class="card-body px-5 py-5">
  <h3 class="card-title text-left mb-3">Login</h3>
   @if($errors->any()) 
          @foreach ($errors->all() as $err)
              <li class="card-description" style="color: #fc424a;">{{ $err }}</li>
          @endforeach
      @endif
  <hr>
  <form method="post" action="{{ route('login') }}">
    @csrf
    <div class="form-group">
      <label>Email</label>
      <input type="text" name="email"  class="form-control p_input text-light" autofocus>
      
    </div>
    <div class="form-group">
      <label>Password *</label>
      <input type="text" name="password" class="form-control p_input text-light">
    </div>
    <div class="form-group d-flex align-items-center justify-content-between">
      <div class="form-check">
        <label class="form-check-label">
        <input type="checkbox" name="nhomatkhau" class="form-check-input" > Remember me </label>
      </div>
      <a href="{{ route('showforgot') }}" class="forgot-pass">Forgot password</a>
    </div>
    <div class="text-center">
      <input type="submit" class="btn btn-primary btn-block enter-btn" value="Login">
    </div>
  </form>
</div>
@endsection
