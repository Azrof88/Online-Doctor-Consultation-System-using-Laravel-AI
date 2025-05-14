@extends('layouts.admin')

@section('content')
<div class="card">
  <div class="card-header"><i class="bi bi-people"></i> New Patient</div>
  <div class="card-body">
    <form action="{{ route('admin.patients.store') }}" method="POST">
      @csrf

      {{-- User fields --}}
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input name="name" class="form-control" value="{{ old('name') }}" required>
        @error('name')<div class="text-danger">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        @error('email')<div class="text-danger">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
        @error('password')<div class="text-danger">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" required>
      </div>

      {{-- Patient fields --}}
      <div class="mb-3">
        <label class="form-label">Mobile</label>
        <input name="contact_number" class="form-control" value="{{ old('contact_number') }}" required>
        @error('contact_number')<div class="text-danger">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Age</label>
        <input type="number" name="age" class="form-control" value="{{ old('age') }}" required>
        @error('age')<div class="text-danger">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Gender</label>
        <select name="gender" class="form-select" required>
          <option value="" disabled {{ old('gender') ? '' : 'selected' }}>-- select --</option>
          <option value="male"   {{ old('gender')=='male'   ? 'selected': '' }}>Male</option>
          <option value="female" {{ old('gender')=='female' ? 'selected': '' }}>Female</option>
          <option value="other"  {{ old('gender')=='other'  ? 'selected': '' }}>Other</option>
        </select>
        @error('gender')<div class="text-danger">{{ $message }}</div>@enderror
      </div>

      <button class="btn btn-primary">Create Patient</button>
    </form>
  </div>
</div>
@endsection
