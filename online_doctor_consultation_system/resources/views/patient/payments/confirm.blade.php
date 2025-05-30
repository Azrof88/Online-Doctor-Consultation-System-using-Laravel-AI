@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Confirm Payment</h2>
    <p>Appointment with Dr. {{ $appointment->doctor->user->name }}</p>
    <p>Amount: 100 BDT (replace with actual amount)</p>

    <form method="POST" action="{{ route('patient.appointments.pay.submit', $appointment) }}">
        @csrf
        <button type="submit" class="btn btn-primary">Pay Now</button>
    </form>
</div>
@endsection
