@extends('layouts.admin')

@section('content')
<div class="card mb-4">
  <div class="card-header">
    <i class="bi bi-calendar-check"></i> Manage Appointments
  </div>
  <div class="card-body p-0">
    <table class="table mb-0">
      <thead>
        <tr>
          <th>ID</th>
          <th>Doctor</th>
          <th>Patient</th>
          <th>Scheduled</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($appointments as $appt)
        <tr>
          <td>{{ $appt->id }}</td>
          <td>{{ $appt->doctor->user->name }}</td>
          <td>{{ $appt->patient->user->name }}</td>
          <td>{{ $appt->scheduled_datetime->format('Y-m-d H:i') }}</td>
          <td>
            <a href="{{ route('admin.appointments.show', $appt) }}"
               class="btn btn-sm btn-info">View</a>
            <form action="{{ route('admin.appointments.destroy', $appt) }}"
                  method="POST" class="d-inline">
              @csrf @method('DELETE')
              <button onclick="return confirm('Cancel this appointment?')"
                      class="btn btn-sm btn-danger">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="text-center">No appointments found</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="card-footer">
    {{ $appointments->links() }}
  </div>
</div>
@endsection
