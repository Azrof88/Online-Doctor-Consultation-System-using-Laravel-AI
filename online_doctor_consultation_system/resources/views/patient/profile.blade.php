@extends('layouts.app')

@section('content')
<div class="container py-4">
  <h1 class="mb-4">Your Profile</h1>

  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  <form action="{{ route('patient.profile.update') }}" method="POST">
    @csrf

    {{-- Name --}}
    <div class="mb-3">
      <label for="name" class="form-label">Full Name</label>
      <input
        type="text"
        id="name"
        name="name"
        class="form-control @error('name') is-invalid @enderror"
        value="{{ old('name', $user->name) }}"
        required
      >
      @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    {{-- Email --}}
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input
        type="email"
        id="email"
        name="email"
        class="form-control @error('email') is-invalid @enderror"
        value="{{ old('email', $user->email) }}"
        required
      >
      @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    {{-- Mobile --}}
    <div class="mb-3">
      <label for="mobile" class="form-label">Mobile Number</label>
      <input
        type="text"
        id="mobile"
        name="mobile"
        class="form-control @error('mobile') is-invalid @enderror"
        value="{{ old('mobile', $user->mobile) }}"
        required
      >
      @error('mobile')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    {{-- Age --}}
    <div class="mb-3">
      <label for="age" class="form-label">Age</label>
      <input
        type="number"
        id="age"
        name="age"
        class="form-control @error('age') is-invalid @enderror"
        value="{{ old('age', $patient->age) }}"
        required
      >
      @error('age')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    {{-- Gender --}}
    <div class="mb-3">
      <label for="gender" class="form-label">Gender</label>
      <select
        id="gender"
        name="gender"
        class="form-select @error('gender') is-invalid @enderror"
        required
      >
        <option disabled {{ old('gender', $patient->gender) ? '' : 'selected' }}>Choose one</option>
        @foreach(['male','female','other'] as $g)
          <option
            value="{{ $g }}"
            {{ old('gender', $patient->gender) === $g ? 'selected' : '' }}
          >
            {{ ucfirst($g) }}
          </option>
        @endforeach
      </select>
      @error('gender')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    {{-- Contact Number --}}
    <div class="mb-3">
      <label for="contact_number" class="form-label">Contact Number</label>
      <input
        type="text"
        id="contact_number"
        name="contact_number"
        class="form-control @error('contact_number') is-invalid @enderror"
        value="{{ old('contact_number', $patient->contact_number) }}"
        required
      >
      @error('contact_number')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    {{-- Password --}}
    <div class="mb-3">
      <label for="password" class="form-label">New Password <small>(leave blank to keep current)</small></label>
      <input
        type="password"
        id="password"
        name="password"
        class="form-control @error('password') is-invalid @enderror"
      >
      @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    {{-- Password Confirmation --}}
    <div class="mb-3">
      <label for="password_confirmation" class="form-label">Confirm Password</label>
      <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Save Changes</button>
  </form>
</div>
@endsection
