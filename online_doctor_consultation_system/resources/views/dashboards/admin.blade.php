<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
  <style>.sidebar { height: 100vh; }</style>
</head>
<body class="bg-light">
  <div class="container-fluid">
    <div class="row">
      {{-- Sidebar --}}
      <nav class="col-md-3 col-lg-2 d-md-block bg-white sidebar py-4">
        <div class="nav flex-column">
          <a class="nav-link active" href="{{ route('admin.home') }}">🏠 Home</a>
          <a class="nav-link" href="{{ route('admin.profile') }}">👤 Profile</a>
          <a class="nav-link" href="{{ route('admin.doctors.index') }}">🩺 Doctors</a>
          <a class="nav-link" href="{{ route('admin.patients.index') }}">👥 Patients</a>
          <a class="nav-link" href="{{ route('admin.appointments.index') }}">📅 Appointments</a>
          <a class="nav-link" href="{{ route('admin.payments.index') }}">💰 Payments</a>
          <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button class="nav-link btn btn-link text-danger p-0">Logout</button>
          </form>
        </div>
      </nav>

      {{-- Main Content --}}
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
        <h1 class="h2 mb-4">Admin Panel</h1>

        {{-- Manage Doctors --}}
        <div class="card mb-4">
          <div class="card-header">🩺 Manage Doctors</div>
          <div class="card-body">
            <a href="{{ route('admin.doctors.create') }}" class="btn btn-sm btn-primary mb-3">
              + New Doctor
            </a>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>ID</th><th>Name</th><th>Email</th><th>Mobile</th><th>Specialization</th><th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($doctors as $doc)
                <tr>
                  <td>{{ $doc->id }}</td>
                  <td>{{ $doc->user->name }}</td>
                  <td>{{ $doc->user->email }}</td>
                  <td>{{ $doc->user->mobile }}</td>
                  <td>{{ $doc->specialization }}</td>
                  <td>
                    <a href="{{ route('admin.doctors.edit', $doc) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                    <form method="POST" action="{{ route('admin.doctors.destroy', $doc) }}" class="d-inline">
                      @csrf @method('DELETE')
                      <button class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

        {{-- Manage Patients --}}
        <div class="card">
          <div class="card-header">👥 Manage Patients</div>
          <div class="card-body">
            <a href="{{ route('admin.patients.create') }}" class="btn btn-sm btn-primary mb-3">
              + New Patient
            </a>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>ID</th><th>Name</th><th>Email</th><th>Mobile</th><th>Age</th><th>Gender</th><th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($patients as $pat)
                <tr>
                  <td>{{ $pat->id }}</td>
                  <td>{{ $pat->user->name }}</td>
                  <td>{{ $pat->user->email }}</td>
                  <td>{{ $pat->user->mobile }}</td>
                  <td>{{ $pat->age }}</td>
                  <td>{{ ucfirst($pat->gender) }}</td>
                  <td>
                    <a href="{{ route('admin.patients.edit', $pat) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                    <form method="POST" action="{{ route('admin.patients.destroy', $pat) }}" class="d-inline">
                      @csrf @method('DELETE')
                      <button class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </main>
    </div>
  </div>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
  </script>
</body>
</html>
