<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Doctor Dashboard</title>
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
          <a class="nav-link @if(request()->routeIs('doctor.home')) active @endif"
             href="{{ route('doctor.home') }}">🏠 Home</a>

          <a class="nav-link @if(request()->routeIs('doctor.profile*')) active @endif"
             href="{{ route('doctor.profile') }}">👤 Profile</a>

          <a class="nav-link @if(request()->routeIs('doctor.appointments*')) active @endif"
             href="{{ route('doctor.appointments.index') }}">📅 Appointments</a>

          <a class="nav-link @if(request()->routeIs('doctor.availability*')) active @endif"
             href="{{ route('doctor.availability.edit') }}">🕒 Availability</a>

          <a class="nav-link @if(request()->routeIs('doctor.payments*')) active @endif"
             href="{{ route('doctor.payments.index') }}">💰 Payments</a>

          <a class="nav-link @if(request()->routeIs('doctor.zoom-meetings*')) active @endif"
             href="{{ route('doctor.zoom-meetings.index') }}">🔗 Zoom Meetings</a>

          <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button class="nav-link btn btn-link text-danger p-0">Logout</button>
          </form>
        </div>
      </nav>

      {{-- Main Content --}}
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
        <h1 class="h2 mb-4">Welcome Dr. {{ $user->name }}</h1>

        {{-- Upcoming Appointments --}}
        <div class="card mb-4">
          <div class="card-header">📅 Upcoming Appointments</div>
          <div class="card-body p-0">
            <table class="table mb-0">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Patient</th>
                  <th>Date & Time</th>
                  <th>Mode</th>
                  <th>Status</th>
                  <th class="text-end">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($appointments as $appt)
                  <tr>
                    <td>{{ $appt->id }}</td>
                    <td>{{ $appt->patient->user->name }}</td>
                    <td>{{ \Illuminate\Support\Carbon::parse($appt->scheduled_datetime)->format('Y-m-d h:i A') }}</td>
                    <td>{{ ucfirst($appt->mode) }}</td>
                    <td>{{ ucfirst($appt->status) }}</td>
                    <td class="text-end">
                      @if($appt->status === 'pending')
                        <form action="{{ route('doctor.appointments.update', $appt) }}"
                              method="POST" class="d-inline">
                          @csrf @method('PATCH')
                          <button name="status" value="confirmed" class="btn btn-sm btn-success">
                            Confirm
                          </button>
                        </form>
                        <form action="{{ route('doctor.appointments.update', $appt) }}"
                              method="POST" class="d-inline">
                          @csrf @method('PATCH')
                          <button name="status" value="cancelled" class="btn btn-sm btn-danger">
                            Cancel
                          </button>
                        </form>

                      @elseif($appt->mode==='online' && $appt->status==='confirmed')
                        @if($appt->zoomMeeting?->start_url)
                          <a href="{{ $appt->zoomMeeting->start_url }}"
                             class="btn btn-sm btn-primary"
                             target="_blank" rel="noopener">
                            Start Zoom
                          </a>
                        @else
                          <span class="text-muted">No Zoom Link</span>
                        @endif

                      @else
                        <span class="text-muted">—</span>
                      @endif
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="text-center py-3">
                      No upcoming appointments.
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

        {{-- Availability Schedule --}}
        <div class="card">
          <div class="card-header">🕒 My Availability</div>
          <div class="card-body">
            <p>{{ $doctor->availability_schedule ?? 'Not set yet.' }}</p>
<a href="{{ route('doctor.availability.edit') }}"
   class="btn btn-sm btn-outline-secondary">
  Edit Schedule
</a>

          </div>
        </div>
      </main>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
