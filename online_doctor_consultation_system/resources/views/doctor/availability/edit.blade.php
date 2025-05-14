@extends('layouts.app')
@section('title','Edit Availability')

@section('content')
<div class="container">
  <h1>Edit Availability Schedule</h1>

  <form action="{{ route('doctor.availability.update') }}" method="POST">
    @csrf @method('PATCH')

    <div class="mb-3">
      <label class="form-label">Availability Schedule</label>
      <textarea name="availability_schedule"
                class="form-control @error('availability_schedule') is-invalid @enderror"
                rows="3">{{ old('availability_schedule', $doctor->availability_schedule) }}</textarea>
      @error('availability_schedule')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <button class="btn btn-primary">Save</button>
  </form>
</div>
@endsection
