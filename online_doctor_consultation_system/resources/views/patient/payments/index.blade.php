{{-- resources/views/patient/payments/index.blade.php --}}
@extends('layouts.app')
@section('title', 'My Payments')

@section('content')
<div class="container">
  <h1>My Payments</h1>

  @if($payments->isEmpty())
    <p>You haven’t made any payments yet.</p>
  @else
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Doctor</th> {{-- renamed header for clarity --}}
          <th>Amount</th>
          <th>Status</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        @foreach($payments as $payment)
          <tr>
            <td>{{ $payment->id }}</td>
            <td>
              {{ optional($payment->appointment->doctor)->name ?? '—' }}
            </td>
            <td>{{ number_format($payment->amount, 2) }} {{ config('app.currency','BDT') }}</td>
            <td>{{ ucfirst($payment->status) }}</td>
            <td>{{ $payment->created_at->format('Y-m-d H:i') }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    {{ $payments->links() }}
  @endif
</div>
@endsection
