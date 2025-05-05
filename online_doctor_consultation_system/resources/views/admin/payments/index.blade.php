@extends('layouts.app')
@section('content')
<h3>All Payments</h3>
<table class="table">
  <thead>
    <tr>
      <th>ID</th><th>Appointment</th><th>Patient</th><th>Amount</th><th>Status</th><th></th>
    </tr>
  </thead>
  <tbody>
    @foreach($payments as $p)
    <tr>
      <td>{{ $p->id }}</td>
      <td>{{ $p->appointment->id }}</td>
      <td>{{ $p->appointment->patient->user->name }}</td>
      <td>${{ number_format($p->amount,2) }}</td>
      <td>{{ ucfirst($p->status) }}</td>
      <td>
        <a href="{{ route('admin.payments.show',$p) }}" class="btn btn-sm btn-info">View</a>
        <form action="{{ route('admin.payments.destroy',$p) }}" method="POST" class="d-inline">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger">Delete</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection
