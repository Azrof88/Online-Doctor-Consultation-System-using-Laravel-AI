@extends('layouts.admin')

@section('content')
<div class="card">
  <div class="card-header">
    <i class="bi bi-cash-stack"></i> Payment #{{ $payment->id }}
  </div>
  <div class="card-body">
    <p><strong>Appointment ID:</strong> {{ $payment->appointment->id }}</p>
    <p><strong>Doctor:</strong> {{ $payment->appointment->doctor->user->name }}</p>
    <p><strong>Patient:</strong> {{ $payment->appointment->patient->user->name }}</p>
    <p><strong>Amount:</strong> ${{ number_format($payment->amount, 2) }}</p>
    <p><strong>Status:</strong> {{ ucfirst($payment->status) }}</p>
    <p><strong>Paid At:</strong>
      {{ $payment->created_at->format('Y-m-d H:i') }}
    </p>
    @if($payment->transaction_id)
      <p><strong>Transaction ID:</strong> {{ $payment->transaction_id }}</p>
    @endif
    @if($payment->notes)
      <p><strong>Notes:</strong> {{ $payment->notes }}</p>
    @endif
  </div>
  <div class="card-footer">
    <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
      ← Back to payments
    </a>
  </div>
</div>
@endsection
