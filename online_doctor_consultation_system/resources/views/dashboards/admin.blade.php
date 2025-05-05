<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .sidebar { height: 100vh; }
  </style>
</head>
<body class="bg-light">
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <nav class="col-md-3 col-lg-2 d-md-block bg-white sidebar py-4">
        <div class="nav flex-column">
          <a class="nav-link active" href="#">🏠 Home</a>
          <a class="nav-link" href="#">👤 Profile</a>
          <a class="nav-link" href="#">🩺 Doctors</a>
          <a class="nav-link" href="#">👥 Patients</a>
          <a class="nav-link" href="#">📅 Appointments</a>
          <a class="nav-link" href="#">💰 Payments</a>
          <a class="nav-link text-danger" href="{{ route('logout') }}">Logout</a>
        </div>
      </nav>

      <!-- Main Content -->
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
        <h1 class="h2 mb-4">Admin Panel</h1>

        <!-- Manage Doctors -->
        <div class="card mb-4">
          <div class="card-header">🩺 Manage Doctors</div>
          <div class="card-body">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>Specialization</th>
                </tr>
              </thead>
              <tbody>
                {{-- @foreach($doctors as $doc) --}}
                {{-- <tr>
                  <td>{{ $doc->id }}</td>
                  <td>{{ $doc->user->name }}</td>
                  <td>{{ $doc->user->email }}</td>
                  <td>{{ $doc->user->mobile }}</td>
                  <td>{{ $doc->specialization }}</td>
                </tr> --}}
                {{-- @endforeach --}}
                <tr>
                  <td>1</td>
                  <td>John Doe</td>
                  <td>john@example.com</td>
                  <td>1234567890</td>
                  <td>Cardiology</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Jane Smith</td>
                  <td>jane@example.com</td>
                  <td>0987654321</td>
                  <td>Orthopedics</td>
                </tr>
                <tr>

              </tbody>
            </table>
          </div>
        </div>

        <!-- Manage Patients -->
        <div class="card">
          <div class="card-header">👥 Manage Patients</div>
          <div class="card-body">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>Age</th>
                  <th>Gender</th>
                </tr>
              </thead>
              <tbody>
                {{-- @foreach($patients as $pat) --}}
                {{-- <tr>
                  <td>{{ $pat->id }}</td>
                  <td>{{ $pat->user->name }}</td>
                  <td>{{ $pat->user->email }}</td>
                  <td>{{ $pat->user->mobile }}</td>
                  <td>{{ $pat->age }}</td>
                  <td>{{ ucfirst($pat->gender) }}</td>
                </tr> --}}

                <tr>
                  <td>1</td>
                  <td>John Doe</td>
                  <td>john@example.com</td>
                  <td>1234567890</td>
                  <td>25</td>
                  <td>Male</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Jane Smith</td>
                  <td>jane@example.com</td>
                  <td>0987654321</td>
                  <td>28</td>
                  <td>Female</td>
                </tr>

                {{-- @endforeach --}}
              </tbody>
            </table>
          </div>
        </div>
      </main>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
