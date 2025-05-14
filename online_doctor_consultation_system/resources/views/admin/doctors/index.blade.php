@extends('layouts.admin')

@section('content')
<div class="card mb-4">
  <div class="card-header">
    <i class="bi bi-stethoscope"></i> Manage Doctors
    <a href="{{ route('admin.doctors.create') }}"
       class="btn btn-sm btn-primary float-end">
      + New Doctor
    </a>
  </div>
  <div class="card-body p-0">
    <table class="table mb-0">
      <thead>
        <tr>
          <th>ID</th><th>Name</th><th>Email</th>
          <th>Mobile</th><th>Specialization</th><th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($doctors as $d)
        <tr>
          <td>{{ $d->id }}</td>
          <td>{{ $d->name }}</td>
          <td>{{ $d->email }}</td>
          <td>{{ $d->mobile }}</td>
          <td>{{ $d->specialization }}</td>
          <td>
            <a href="{{ route('admin.doctors.edit', $d) }}"
               class="btn btn-sm btn-secondary">Edit</a>
            <form action="{{ route('admin.doctors.destroy', $d) }}"
                  method="POST"
                  class="d-inline">
              @csrf @method('DELETE')
              <button onclick="return confirm('Delete this doctor?')"
                      class="btn btn-sm btn-danger">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center">No doctors found</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="card-footer">
    {{ $doctors->links() }}
  </div>
</div>
@endsection
