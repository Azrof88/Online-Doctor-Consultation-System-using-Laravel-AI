@extends('layouts.app')

@section('content')
<div class="container py-4">
  <h3>My Profile</h3>

  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  <form method="POST" action="{{ route('admin.profile.update') }}">
    @csrf

    <div class="mb-3">
      <label class="form-label">Name</label>
      <input type="text"
             name="name"
             class="form-control @error('name') is-invalid @enderror"
             value="{{ old('name',$user->name) }}"
             required>
      @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email"
             name="email"
             class="form-control @error('email') is-invalid @enderror"
             value="{{ old('email',$user->email) }}"
             required>
      @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Mobile</label>
      <input type="text"
             name="mobile"
             class="form-control @error('mobile') is-invalid @enderror"
             value="{{ old('mobile',$user->mobile) }}"
             required>
      @error('mobile') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <hr>

    <h5>Change Password</h5>
    <div class="mb-3">
      <label class="form-label">New Password</label>
      <input type="password"
             name="password"
             class="form-control @error('password') is-invalid @enderror">
      @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
      <label class="form-label">Confirm Password</label>
      <input type="password"
             name="password_confirmation"
             class="form-control">
    </div>

    <div class="d-grid">
      <button class="btn btn-primary">Update Profile</button>
    </div>
  </form>
</div>
@endsection
