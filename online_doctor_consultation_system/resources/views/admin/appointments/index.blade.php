@extends('layouts.app')
@section('content')
<h3>All Appointments</h3>
<table class="table">
  <thead>
    <tr>
      <th>ID</th><th>Patient</th><th>Doctor</th><th>Date/Time</th><th>Status</th><th></th>
    </tr>
  </thead>
  <tbody>
    @foreach($appointments as $a)
    <tr>
      <td>{{ $a->id }}</td>
      <td>{{ $a->patient->user->name }}</td>
      <td>{{ $a->doctor->user->name }}</td>
      <td>{{ $a->scheduled_datetime }}</td>
      <td>{{ ucfirst($a->status) }}</td>
      <td>
        <a href="{{ route('admin.appointments.show',$a) }}" class="btn btn-sm btn-info">View</a>
        <form action="{{ route('admin.appointments.destroy',$a) }}" method="POST" class="d-inline">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger">Delete</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection
