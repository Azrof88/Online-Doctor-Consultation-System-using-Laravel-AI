@extends('layouts.app')
@section('title',"Zoom Meeting #{$zoomMeeting->id}")

@section('content')
<div class="container">
  <h1>Meeting #{{ $zoomMeeting->id }}</h1>
  <p><strong>Appointment:</strong> #{{ $zoomMeeting->appointment_id }}</p>
  <p><strong>Patient:</strong> {{ $zoomMeeting->appointment->patient->user->name }}</p>
  <p><strong>Start URL:</strong>
    <a href="{{ $zoomMeeting->start_url }}" target="_blank">{{ $zoomMeeting->start_url }}</a>
  </p>
  <p><strong>Join URL:</strong>
    <a href="{{ $zoomMeeting->join_url }}" target="_blank">{{ $zoomMeeting->join_url }}</a>
  </p>

  <a href="{{ route('doctor.zoom-meetings.edit',$zoomMeeting) }}"
     class="btn btn-outline-secondary">Edit</a>
  <a href="{{ route('doctor.zoom-meetings.index') }}"
     class="btn btn-link">← Back</a>
</div>
@endsection
