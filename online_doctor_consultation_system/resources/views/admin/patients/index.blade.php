@extends('layouts.admin')

@section('content')
<div class="card mb-4">
  <div class="card-header">
    <i class="bi bi-people"></i> Manage Patients
    <a href="{{ route('admin.patients.create') }}"
       class="btn btn-sm btn-primary float-end">+ New Patient</a>
  </div>
  <div class="card-body p-0">
    <table class="table mb-0">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Mobile</th>
          <th>Age</th>
          <th>Gender</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($patients as $p)
        <tr>
          <td>{{ $p->id }}</td>
          <td>{{ $p->user->name }}</td>
          <td>{{ $p->user->email }}</td>
          <td>{{ $p->contact_number }}</td>
          <td>{{ $p->age }}</td>
          <td>{{ ucfirst($p->gender) }}</td>
          <td>
            <a href="{{ route('admin.patients.edit', $p) }}"
               class="btn btn-sm btn-secondary">Edit</a>
            <form action="{{ route('admin.patients.destroy', $p) }}"
                  method="POST" class="d-inline">
              @csrf @method('DELETE')
              <button onclick="return confirm('Delete this patient?')"
                      class="btn btn-sm btn-danger">Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" class="text-center">No patients found</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="card-footer">
    {{ $patients->links() }}
  </div>
</div>
@endsection
