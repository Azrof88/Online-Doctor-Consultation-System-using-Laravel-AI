@extends('layouts.admin')

@section('content')
<div class="card">
  <div class="card-header"><i class="bi bi-people"></i> Edit Patient</div>
  <div class="card-body">
    <form action="{{ route('admin.patients.update', $patient) }}" method="POST">
      @csrf @method('PUT')

      {{-- User --}}
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input name="name" class="form-control"
               value="{{ old('name',$patient->user->name) }}" required>
        @error('name')<div class="text-danger">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control"
               value="{{ old('email',$patient->user->email) }}" required>
        @error('email')<div class="text-danger">{{ $message }}</div>@enderror
      </div>

      {{-- Patient --}}
      <div class="mb-3">
        <label class="form-label">Mobile</label>
        <input name="contact_number" class="form-control"
               value="{{ old('contact_number',$patient->contact_number) }}" required>
        @error('contact_number')<div class="text-danger">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Age</label>
        <input type="number" name="age" class="form-control"
               value="{{ old('age',$patient->age) }}" required>
        @error('age')<div class="text-danger">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Gender</label>
        <select name="gender" class="form-select" required>
          <option value="male"   {{ old('gender',$patient->gender)=='male'? 'selected':'' }}>Male</option>
          <option value="female" {{ old('gender',$patient->gender)=='female'? 'selected':'' }}>Female</option>
          <option value="other"  {{ old('gender',$patient->gender)=='other'? 'selected':'' }}>Other</option>
        </select>
        @error('gender')<div class="text-danger">{{ $message }}</div>@enderror
      </div>

      <button class="btn btn-primary">Update Patient</button>
    </form>
  </div>
</div>
@endsection
