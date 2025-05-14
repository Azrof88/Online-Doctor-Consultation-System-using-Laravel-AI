<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Patient Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      .sidebar { height: 100vh; }
    </style>
</head>
<body class="bg-light">
  <div class="container-fluid">
    <div class="row">
      {{-- Sidebar --}}
      <nav class="col-md-3 col-lg-2 d-md-block bg-white sidebar py-4">
        <div class="nav flex-column">
          <a class="nav-link active" href="{{ route('patient.home') }}">🏠 Home</a>
          <a class="nav-link"        href="{{ route('patient.profile') }}">👤 Profile</a>
          <a class="nav-link"        href="{{ route('patient.appointments.create') }}">📅 Book Appointment</a>
          <a class="nav-link"        href="{{ route('patient.appointments.index') }}">🩺 My Appointments</a>
          <a class="nav-link"        href="{{ route('patient.payments.index') }}">💳 My Payments</a>
          <a class="nav-link"        href="{{ route('patient.symptom-checks.index') }}">🔍 Symptom Check</a>
          <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button class="nav-link btn btn-link text-danger p-0">Logout</button>
          </form>
        </div>
      </nav>

      {{-- Main Content --}}
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
        <h1 class="h2 mb-4">Welcome, {{ $user->name }}</h1>

        {{-- My Appointments --}}
        <div class="card mb-4">
          <div class="card-header">🩺 My Appointments</div>
          <div class="card-body">
            @if($appointments->isEmpty())
              <p class="text-muted">You have no appointments yet.</p>
            @else
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Doctor</th>
                    <th>Date & Time</th>
                    <th>Mode</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($appointments as $appt)
                  <tr>
                    <td>{{ $appt->id }}</td>
                    <td>{{ $appt->doctor->user->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($appt->scheduled_datetime)
                                ->format('Y-m-d h:i A') }}</td>
                    <td>{{ ucfirst($appt->mode) }}</td>
                    <td>{{ ucfirst($appt->status) }}</td>
                    <td class="text-end">
    @if($appt->status === 'pending')
      <a href="{{ route('patient.appointments.show', $appt) }}"
         class="btn btn-sm btn-primary">
        Pay / Confirm
      </a>

    @elseif($appt->mode === 'online' && $appt->status === 'confirmed')
      @if($appt->zoomMeeting?->join_url)
        <a href="{{ $appt->zoomMeeting->join_url }}"
           class="btn btn-sm btn-success"
           target="_blank"
           rel="noopener">
          Join Zoom
        </a>
      @else
        <span class="btn btn-sm btn-secondary disabled">
          No meeting link
        </span>
      @endif

    @else
      <span class="text-muted">—</span>
    @endif
  </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            @endif
          </div>
        </div>

        {{-- My Symptom Checks --}}
        <div class="card">
          <div class="card-header">🔍 My Symptom Checks</div>
          <div class="card-body">
            @if($symptomChecks->isEmpty())
              <p class="text-muted">You haven’t done any symptom checks yet.</p>
            @else
              <ul class="list-group">
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
            @endif
          </div>
        </div>

      </main>
    </div>
  </div>
  <!-- … scripts … -->
</body>
</html>
