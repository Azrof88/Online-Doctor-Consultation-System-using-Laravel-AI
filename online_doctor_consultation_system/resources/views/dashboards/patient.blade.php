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
          <a class="nav-link active" href="#">🏠 Home</a>
          <a class="nav-link" href="#">👤 Profile</a>
          <a class="nav-link" href="#">📅 Book Appointment</a>
          <a class="nav-link" href="#">🩺 My Appointments</a>
          <a class="nav-link" href="#">💳 My Payments</a>
          <a class="nav-link" href="#">🔍 Symptom Check</a>
          <a class="nav-link text-danger" href="{{ route('logout') }}">Logout</a>
        </div>
      </nav>

      {{-- Main Content --}}
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
        <h1 class="h2 mb-4">Welcome, {{ $user->name }}</h1>

        {{-- My Appointments --}}
        <div class="card mb-4">
          <div class="card-header">🩺 My Appointments</div>
          <div class="card-body">
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
                {{-- @foreach($appointments as $appt) --}}
                {{-- <tr>
                  <td>{{ $appt->id }}</td>
                  <td>{{ $appt->doctor->user->name }}</td>
                  <td>{{ $appt->scheduled_datetime }}</td>
                  <td>{{ ucfirst($appt->mode) }}</td>
                  <td>{{ ucfirst($appt->status) }}</td>
                  <td>
                    @if($appt->status==='pending')
                      <a href="#" class="btn btn-sm btn-primary">Pay/Confirm</a>
                    @elseif($appt->mode==='online' && $appt->status==='confirmed')
                      <a href="{{ $appt->zoomMeeting->join_url }}" class="btn btn-sm btn-success">Join Zoom</a>
                    @endif
                  </td>
                </tr> --}}
                {{-- @endforeach --}}
                <tr>
                  <td>1</td>
                  <td>Dr. John Doe</td>
                  <td>2023-10-01 10:00 AM</td>
                  <td>Online</td>
                  <td>Confirmed</td>
                  <td>
                    <a href="#" class="btn btn-sm btn-primary">Pay/Confirm</a>
                    <a href="#" class="btn btn-sm btn-success">Join Zoom</a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        {{-- Symptom Checks --}}
        <div class="card">
          <div class="card-header">🔍 My Symptom Checks</div>
          <div class="card-body">
            <ul class="list-group">
              {{-- @foreach($symptomChecks as $check) --}}
              <li class="list-group-item">
                {{-- <strong>{{ $check->created_at->format('Y-m-d') }}:</strong>
                {{ Str::limit($check->symptoms_text, 50) }} --}}
                 {{-- extra started here --}}
                <strong>2023-10-01:</strong>
                Fever, Cough, Headache
                <span class="badge bg-primary float-end">Pending</span>
                {{-- extra ended here --}}
                <a href="#" class="float-end">View Details</a>
              </li>
              {{-- @endforeach --}}
            </ul>
          </div>
        </div>
      </main>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
