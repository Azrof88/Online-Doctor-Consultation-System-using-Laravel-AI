@extends('layouts.admin')

@section('content')
<div class="card">
  <div class="card-header">
    <i class="bi bi-stethoscope"></i> New Doctor
  </div>
  <div class="card-body">
    <form action="{{ route('admin.doctors.store') }}" method="POST">
      @csrf

      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input
          type="text"
          id="name"
          name="name"
          value="{{ old('name') }}"
          class="form-control @error('name') is-invalid @enderror"
          required>
        @error('name')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input
          type="email"
          id="email"
          name="email"
          value="{{ old('email') }}"
          class="form-control @error('email') is-invalid @enderror"
          required>
        @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="mobile" class="form-label">Mobile</label>
        <input
          type="text"
          id="mobile"
          name="mobile"
          value="{{ old('mobile') }}"
          class="form-control @error('mobile') is-invalid @enderror"
          required>
        @error('mobile')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="specialization" class="form-label">Specialization</label>
        <input
          type="text"
          id="specialization"
          name="specialization"
          value="{{ old('specialization') }}"
          class="form-control @error('specialization') is-invalid @enderror"
          required>
        @error('specialization')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit" class="btn btn-primary">
        Create Doctor
      </button>
    </form>
  </div>
</div>
@endsection
