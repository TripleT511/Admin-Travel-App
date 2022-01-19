@extends('layouts.login')

@section('title','Login')


@section('content')
<div class="card-body px-5 py-5">
  <h3 class="card-title text-left mb-3">Login</h3>
  <form method="post" action="{{ route('login') }}">
    @csrf
    <div class="form-group">
      <label>Email</label>
      <input type="text" name="email" class="form-control p_input text-light">
    </div>
    <div class="form-group">
      <label>Password *</label>
      <input type="text" name="password" class="form-control p_input text-light">
    </div>
    <div class="form-group d-flex align-items-center justify-content-between">
      <div class="form-check">
        <label class="form-check-label">
          <input type="checkbox" class="form-check-input"> Remember me </label>
      </div>
      <a href="#" class="forgot-pass">Forgot password</a>
    </div>
    <div class="text-center">
      <input type="submit" class="btn btn-primary btn-block enter-btn" value="Login">
    </div>
  </form>
</div>
@endsection
