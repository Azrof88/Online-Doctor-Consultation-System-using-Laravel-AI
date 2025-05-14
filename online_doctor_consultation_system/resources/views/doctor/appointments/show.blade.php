@extends('layouts.app')
@section('title',"Appointment #{$appointment->id}")

@section('content')
<div class="container">
  <h1>Appointment #{{ $appointment->id }}</h1>

  <dl class="row">
    <dt class="col-sm-3">Patient</dt>
    <dd class="col-sm-9">{{ $appointment->patient->user->name }}</dd>

    <dt class="col-sm-3">Date &amp; Time</dt>
    <dd class="col-sm-9">
      {{ \Carbon\Carbon::parse($appointment->scheduled_datetime)
           ->format('Y-m-d h:i A') }}
    </dd>

    <dt class="col-sm-3">Mode</dt>
    <dd class="col-sm-9">{{ ucfirst($appointment->mode) }}</dd>

    <dt class="col-sm-3">Status</dt>
    <dd class="col-sm-9">{{ ucfirst($appointment->status) }}</dd>
  </dl>

  @if($appointment->status === 'pending')
    <form action="{{ route('doctor.appointments.update', $appointment) }}"
          method="POST" class="d-inline">
      @csrf @method('PATCH')
      <button name="status" value="confirmed" class="btn btn-success">
        Confirm
      </button>
    </form>
    <form action="{{ route('doctor.appointments.update', $appointment) }}"
          method="POST" class="d-inline">
      @csrf @method('PATCH')
      <button name="status" value="cancelled" class="btn btn-danger">
        Cancel
      </button>
    </form>
  @elseif($appointment->mode==='online'
           && $appointment->status==='confirmed'
           && $appointment->zoomMeeting?->start_url)
    <a href="{{ $appointment->zoomMeeting->start_url }}"
       target="_blank" rel="noopener"
       class="btn btn-primary">
      Start Zoom
    </a>
  @endif

  <a href="{{ route('doctor.appointments.index') }}"
     class="btn btn-link">← Back</a>
</div>
@endsection
