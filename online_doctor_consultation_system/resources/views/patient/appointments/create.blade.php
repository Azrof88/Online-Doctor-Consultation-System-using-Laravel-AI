@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Book an Appointment</h1>

  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  <form action="{{ route('patient.appointments.store') }}" method="POST">
    @csrf

    <div class="mb-3">
      <label class="form-label">Doctor</label>
      <select name="doctor_id"
              class="form-select @error('doctor_id') is-invalid @enderror" required>
        <option disabled selected>Choose one</option>
        @foreach($doctors as $doc)
          <option value="{{ $doc->id }}"
            {{ old('doctor_id')==$doc->id ? 'selected':'' }}>
            Dr. {{ $doc->user->name }} ({{ $doc->specialization }})
          </option>
        @endforeach
      </select>
      @error('doctor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Date &amp; Time</label>
      <input type="datetime-local" name="scheduled_datetime"
             value="{{ old('scheduled_datetime') }}"
             class="form-control @error('scheduled_datetime') is-invalid @enderror" required>
      @error('scheduled_datetime') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Mode</label>
      <select name="mode"
              class="form-select @error('mode') is-invalid @enderror" required>
        <option disabled selected>Online or Offline</option>
        <option value="online"  {{ old('mode')=='online'  ? 'selected':'' }}>Online</option>
        <option value="offline" {{ old('mode')=='offline' ? 'selected':'' }}>Offline</option>
      </select>
      @error('mode') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <button class="btn btn-primary">Request Appointment</button>
  </form>
</div>
@endsection
