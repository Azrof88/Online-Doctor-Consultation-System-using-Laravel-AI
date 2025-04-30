@extends('layouts.app')
@section('content')
<div class="container py-5">
  <h3>Reset Password</h3>
  <form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="id" value="{{ $id }}">

    <div class="mb-3">
      <label for="password" class="form-label">New Password</label>
      <input type="password" name="password" id="password"
             class="form-control @error('password') is-invalid @enderror"
             required>
      @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="password_confirmation" class="form-label">Confirm New Password</label>
      <input type="password" name="password_confirmation"
             class="form-control" required>
    </div>

    <button class="btn btn-success">Reset Password</button>
  </form>
</div>
@endsection
