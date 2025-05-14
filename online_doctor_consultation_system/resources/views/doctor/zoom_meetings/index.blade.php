@extends('layouts.app')
@section('title','My Zoom Meetings')

@section('content')
<div class="container">
  <h1>Zoom Meetings</h1>

  <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Appt. ID</th>
        <th>Patient</th>
        <th>Start URL</th>
        <th>Join URL</th>
        <th class="text-end">Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($meetings as $m)
        <tr>
          <td>{{ $m->id }}</td>
          <td>{{ $m->appointment_id }}</td>
          <td>{{ $m->appointment->patient->user->name }}</td>
          <td>
            <a href="{{ $m->start_url }}" target="_blank">Start</a>
          </td>
          <td>
            <a href="{{ $m->join_url }}" target="_blank">Join</a>
          </td>
          <td class="text-end">
            <a href="{{ route('doctor.zoom-meetings.show',$m) }}"
               class="btn btn-sm btn-outline-primary">View</a>
            <a href="{{ route('doctor.zoom-meetings.edit',$m) }}"
               class="btn btn-sm btn-outline-secondary">Edit</a>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" class="text-center">No Zoom meetings yet.</td>
        </tr>
      @endforelse
    </tbody>
  </table>

  {{ $meetings->links() }}
</div>
@endsection
