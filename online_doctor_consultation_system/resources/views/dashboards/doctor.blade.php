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
          <a class="nav-link active" href="#">🏠 Home</a>
          <a class="nav-link" href="#">👤 Profile</a>
          <a class="nav-link" href="#">📅 Appointments</a>
          <a class="nav-link" href="#">🕒 Availability</a>
          <a class="nav-link" href="#">💰 Payments</a>
          <a class="nav-link" href="#">🔗 Zoom Meetings</a>
          <a class="nav-link text-danger" href="{{ route('logout') }}">Logout</a>
        </div>
      </nav>

      {{-- Main Content --}}
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
        <h1 class="h2 mb-4">Welcome Dr. {{ $user->name }}</h1>

        {{-- Upcoming Appointments --}}
        <div class="card mb-4">
          <div class="card-header">📅 Upcoming Appointments</div>
          <div class="card-body">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Patient</th>
                  <th>Date & Time</th>
                  <th>Mode</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                {{-- @foreach($appointments as $appt)
                <tr>
                  <td>{{ $appt->id }}</td>
                  <td>{{ $appt->patient->user->name }}</td>
                  <td>{{ $appt->scheduled_datetime }}</td>
                  <td>{{ ucfirst($appt->mode) }}</td>
                  <td>{{ ucfirst($appt->status) }}</td>
                  <td>
                    @if($appt->status==='pending')
                      <a href="#" class="btn btn-sm btn-success">Confirm</a>
                      <a href="#" class="btn btn-sm btn-danger">Cancel</a>
                    @elseif($appt->mode==='online' && $appt->status==='confirmed')
                      <a href="{{ $appt->zoomMeeting->start_url }}" class="btn btn-sm btn-primary">Start Zoom</a>

                    @endif
                  </td>
                </tr>
                @endforeach --}}

                <tr>
                  <td>id</td>
                  <td>name</td>
                  <td>scheduled_datetime</td>
                  <td>mode</td>
                  <td>status</td>
                  <td>

                      <a href="#" class="btn btn-sm btn-success">Confirm</a>
                      <a href="#" class="btn btn-sm btn-danger">Cancel</a>




                  </td>
                </tr>

              </tbody>
            </table>
          </div>
        </div>

        {{-- Availability Schedule --}}
        <div class="card">
          <div class="card-header">🕒 My Availability</div>
          <div class="card-body">
            {{-- <p>{{ $user->doctor->availability_schedule }}</p> --}}
            <p>Availability schedule</p>
            <a href="#" class="btn btn-sm btn-outline-secondary">Edit Schedule</a>
          </div>
        </div>
      </main>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
