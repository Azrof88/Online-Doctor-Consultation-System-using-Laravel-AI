@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
  <div class="container py-5">
    <h3>Forgot Password</h3>

    @if(session('status'))
      <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.prefill') }}">
      @csrf

      <div class="mb-3">
        <label for="email" class="form-label">Your registered email</label>
        <input
          type="email"
          name="email"
          id="email"
          class="form-control @error('email') is-invalid @enderror"
          value="{{ old('email') }}"
          required
        >
        @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="d-grid">
        <button class="btn btn-primary">Continue to Reset</button>
      </div>
    </form>
  </div>
@endsection
