@extends('layouts.admin')

@section('content')
<div class="card">
  <div class="card-header">
    <i class="bi bi-calendar-check"></i> Appointment #{{ $appointment->id }}
  </div>
  <div class="card-body">
    <p><strong>Doctor:</strong> {{ $appointment->doctor->user->name }}</p>
    <p><strong>Patient:</strong> {{ $appointment->patient->user->name }}</p>
    <p><strong>Scheduled At:</strong> {{ $appointment->scheduled_datetime->format('Y-m-d H:i') }}</p>
    <p><strong>Reason/Notes:</strong> {{ $appointment->notes ?? '—' }}</p>
    @if($appointment->zoom_link)
      <p><strong>Zoom Link:</strong>
        <a href="{{ $appointment->zoom_link }}" target="_blank">
          {{ $appointment->zoom_link }}
        </a>
      </p>
    @endif
  </div>
  <div class="card-footer">
    <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary">
      ← Back to list
    </a>
  </div>
</div>
@endsection
