@extends('layouts.app')

@section('content')
<div class="container">
  <h2>My Appointments</h2>
  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Doctor</th>
        <th>Date & Time</th>
        <th>Mode</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($appointments as $appt)
      <tr>
        <td>{{ $appt->id }}</td>
        <td>{{ $appt->doctor->user->name }}</td>
        <td>{{ $appt->scheduled_datetime->format('Y-m-d h:i A') }}</td>
        <td>{{ ucfirst($appt->mode) }}</td>
        <td>{{ ucfirst($appt->status) }}</td>
        <td>
            @if($appt->status === 'pending')
            <form
              method="POST"
              action="{{ route('patient.appointments.pay', $appt) }}"
              style="display:inline"
            >
              @csrf
              <button class="btn btn-sm btn-primary">Pay/Confirm</button>
            </form>

          @elseif($appt->mode==='online' && $appt->status==='confirmed')
            <a href="{{ $appt->zoomMeeting->join_url }}" class="btn btn-sm btn-success">Join Zoom</a>
          @endif
          <a href="{{ route('patient.appointments.show', $appt) }}" class="btn btn-sm btn-outline-secondary">View</a>
        </td>
      </tr>
      @empty
      <tr><td colspan="6">No appointments yet.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
