@extends('layouts.app')
@section('title','My Appointments')

@section('content')
<div class="container">
  <h1>Appointments</h1>

  <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Patient</th>
        <th>Date &amp; Time</th>
        <th>Mode</th>
        <th>Status</th>
        <th class="text-end">Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($appointments as $appt)
        <tr>
          <td>{{ $appt->id }}</td>
          <td>{{ $appt->patient->user->name }}</td>
          <td>{{ \Carbon\Carbon::parse($appt->scheduled_datetime)
                        ->format('Y-m-d h:i A') }}</td>
          <td>{{ ucfirst($appt->mode) }}</td>
          <td>{{ ucfirst($appt->status) }}</td>
          <td class="text-end">
            <a href="{{ route('doctor.appointments.show', $appt) }}"
               class="btn btn-sm btn-outline-primary">
              View
            </a>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" class="text-center">No appointments found.</td>
        </tr>
      @endforelse
    </tbody>
  </table>

  {{ $appointments->links() }}
</div>
@endsection
