@extends('layouts.app')
@section('title', 'My Symptom Checks')

@section('content')
<div class="container">
  <h1>My Symptom Checks</h1>

  @if($symptomChecks->isEmpty())
    <p>You haven’t done any symptom checks yet.</p>
  @else
    <ul class="list-group mb-3">
      @foreach($symptomChecks as $check)
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <div>
            <strong>{{ $check->created_at->format('Y-m-d') }}:</strong>
            {{ \Illuminate\Support\Str::limit($check->symptoms_text, 50) }}
          </div>
          <div>
            <a href="{{ route('patient.symptom-checks.show', $check) }}">
              View Details
            </a>
            <span class="badge bg-{{ $check->diseases->isEmpty() ? 'secondary' : 'primary' }} ms-2">
              {{ $check->diseases->isEmpty() ? 'Pending' : 'Results' }}
            </span>
          </div>
        </li>
      @endforeach
    </ul>

    {{-- Paginate if using paginate() --}}
    {{ $symptomChecks->links() }}
  @endif

  <a href="{{ route('dashboard') }}" class="btn btn-secondary">
    ← Back to Dashboard
  </a>
</div>
@endsection
