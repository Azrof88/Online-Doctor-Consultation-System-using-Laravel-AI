@extends('layouts.app')
@section('title',"Edit Zoom Meeting #{$zoomMeeting->id}")

@section('content')
<div class="container">
  <h1>Edit Zoom Meeting</h1>

  <form action="{{ route('doctor.zoom-meetings.update',$zoomMeeting) }}"
        method="POST">
    @csrf @method('PATCH')

    <div class="mb-3">
      <label class="form-label">Start URL</label>
      <input name="start_url" type="url"
             class="form-control @error('start_url') is-invalid @enderror"
             value="{{ old('start_url',$zoomMeeting->start_url) }}">
      @error('start_url')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Join URL</label>
      <input name="join_url" type="url"
             class="form-control @error('join_url') is-invalid @enderror"
             value="{{ old('join_url',$zoomMeeting->join_url) }}">
      @error('join_url')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <button class="btn btn-primary">Save</button>
    <a href="{{ route('doctor.zoom-meetings.show',$zoomMeeting) }}"
       class="btn btn-link">Cancel</a>
  </form>
</div>
@endsection
