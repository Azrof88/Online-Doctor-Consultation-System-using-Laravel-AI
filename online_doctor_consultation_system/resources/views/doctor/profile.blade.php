@extends('layouts.app')
@section('title','My Profile')

@section('content')
<div class="container">
  <h1>My Profile</h1>

  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  <form action="{{ route('doctor.profile.update') }}" method="POST">
    @csrf

    {{-- 1) User fields --}}
    <div class="mb-3">
      <label class="form-label">Full Name</label>
      <input name="name" class="form-control @error('name') is-invalid @enderror"
             value="{{ old('name',$user->name) }}">
      @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Email</label>
      <input name="email" type="email"
             class="form-control @error('email') is-invalid @enderror"
             value="{{ old('email',$user->email) }}">
      @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Mobile</label>
      <input name="mobile"
             class="form-control @error('mobile') is-invalid @enderror"
             value="{{ old('mobile',$user->mobile) }}">
      @error('mobile') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <hr>

    {{-- 2) Doctor fields --}}
    <div class="mb-3">
      <label class="form-label">Specialization</label>
      <input name="specialization"
             class="form-control @error('specialization') is-invalid @enderror"
             value="{{ old('specialization',$doctor->specialization) }}">
      @error('specialization') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Consultation Fee</label>
      <input name="fee" type="number" step="0.01"
             class="form-control @error('fee') is-invalid @enderror"
             value="{{ old('fee',$doctor->fee) }}">
      @error('fee') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Zoom Profile Link</label>
      <input name="zoom_link" type="url"
             class="form-control @error('zoom_link') is-invalid @enderror"
             value="{{ old('zoom_link',$doctor->zoom_link) }}">
      @error('zoom_link') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Bio</label>
      <textarea name="bio" rows="3"
                class="form-control @error('bio') is-invalid @enderror">{{ old('bio',$doctor->bio) }}</textarea>
      @error('bio') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Availability Schedule</label>
      <textarea name="availability_schedule" rows="2"
                class="form-control @error('availability_schedule') is-invalid @enderror">{{ old('availability_schedule',$doctor->availability_schedule) }}</textarea>
      @error('availability_schedule') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <hr>

    {{-- 3) Optional password change --}}
    <div class="mb-3">
      <label class="form-label">New Password <small class="text-muted">(leave blank to keep)</small></label>
      <input name="password" type="password" class="form-control @error('password') is-invalid @enderror">
      @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
      <label class="form-label">Confirm New Password</label>
      <input name="password_confirmation" type="password" class="form-control">
    </div>

    <button class="btn btn-primary">Save Changes</button>
  </form>
</div>
@endsection
