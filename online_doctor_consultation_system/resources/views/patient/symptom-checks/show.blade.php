@extends('layouts.app')
@section('title', 'Symptom Check Details')

@section('content')
<div class="container">
  <h1>Symptom Check — {{ $symptomCheck->created_at->format('Y-m-d') }}</h1>
  <p class="text-muted">
    Checked on {{ $symptomCheck->created_at->format('h:i A') }}
  </p>

  {{-- 1) Raw symptoms text --}}
  <div class="card mb-4">
    <div class="card-header">Your Reported Symptoms</div>
    <div class="card-body">
      <p style="white-space: pre-wrap;">{{ $symptomCheck->symptoms_text }}</p>
    </div>
  </div>

  {{-- 2) Disease predictions --}}
  <div class="card mb-4">
    <div class="card-header">Predicted Conditions</div>
    <div class="card-body">
      @if($symptomCheck->diseases->isEmpty())
        <p class="text-secondary">No results yet. Please check back soon.</p>
      @else
        <ul class="list-group">
          @foreach($symptomCheck->diseases as $disease)
            <li class="list-group-item">
              <h5 class="mb-1">{{ $disease->name }}</h5>
              @if($disease->description)
                <small class="text-muted">{{ $disease->description }}</small>
              @endif
            </li>
          @endforeach
        </ul>
      @endif
    </div>
  </div>

  {{-- 3) Placeholder for ML insights --}}
  <div class="card mb-4">
    <div class="card-header">Machine-Learning Analysis</div>
    <div class="card-body">
      <p class="text-muted">
        Your AI-driven health insights will appear here once the model is live.
      </p>
    </div>
  </div>

  {{-- 4) Back link --}}
  <a href="{{ route('patient.symptom-checks.index') }}" class="btn btn-secondary">
    ← Back to all Symptom Checks
  </a>
</div>
@endsection
