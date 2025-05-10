@extends('layouts.app') {{-- or whatever your layout is --}}
@section('content')
<div class="container">
  <h1>Appointment #{{ $appointment->id }}</h1>

  <dl class="row">
    <dt class="col-sm-3">Doctor</dt>
    <dd class="col-sm-9">{{ $appointment->doctor->user->name }}</dd>

    <dt class="col-sm-3">Date & Time</dt>
    <dd class="col-sm-9">{{ $appointment->scheduled_datetime->format('Y-m-d h:i A') }}</dd>

    <dt class="col-sm-3">Mode</dt>
    <dd class="col-sm-9">{{ ucfirst($appointment->mode) }}</dd>

    <dt class="col-sm-3">Status</dt>
    <dd class="col-sm-9">{{ ucfirst($appointment->status) }}</dd>
  </dl>

  @if($appointment->status === 'pending')
    <form method="POST" action="{{ route('patient.appointments.pay', $appointment) }}">
      @csrf
      <button class="btn btn-primary">Pay / Confirm</button>
    </form>
  @elseif($appointment->mode==='online' && $appointment->status==='confirmed')
    <a href="{{ $appointment->zoomMeeting->join_url }}" class="btn btn-success">Join Zoom</a>
  @endif

  <a href="{{ route('patient.appointments.index') }}" class="btn btn-link">← Back to list</a>
</div>
@endsection
