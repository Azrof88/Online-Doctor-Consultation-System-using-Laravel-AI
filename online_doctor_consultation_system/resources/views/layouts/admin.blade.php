<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin Panel')</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      display: flex;
      min-height: 100vh;
    }
    .sidebar {
      width: 240px;
      background-color: #f8f9fa;
    }
    .sidebar .nav-link {
      color: #333;
    }
    .sidebar .nav-link.active {
      background-color: #e9ecef;
    }
    .content-area {
      flex: 1;
      padding: 20px;
    }
  </style>
</head>
<body>
  <nav class="sidebar d-flex flex-column p-3">
    <a href="{{ route('admin.home') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-decoration-none">
      <span class="fs-4"><i class="bi bi-speedometer2"></i> Admin</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
      <li class="nav-item">
        <a href="{{ route('admin.home') }}" class="nav-link {{ request()->routeIs('admin.home') ? 'active' : '' }}">
          <i class="bi bi-house"></i> Home
        </a>
      </li>
      <li>
        <a href="{{ route('admin.profile') }}" class="nav-link {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
          <i class="bi bi-person"></i> Profile
        </a>
      </li>
      <li>
        <a href="{{ route('admin.doctors.index') }}" class="nav-link {{ request()->routeIs('admin.doctors.*') ? 'active' : '' }}">
          <i class="bi bi-stethoscope"></i> Doctors
        </a>
      </li>
      <li>
        <a href="{{ route('admin.patients.index') }}" class="nav-link {{ request()->routeIs('admin.patients.*') ? 'active' : '' }}">
          <i class="bi bi-people"></i> Patients
        </a>
      </li>
      <li>
        <a href="{{ route('admin.appointments.index') }}" class="nav-link {{ request()->routeIs('admin.appointments.*') ? 'active' : '' }}">
          <i class="bi bi-calendar-check"></i> Appointments
        </a>
      </li>
      <li>
        <a href="{{ route('admin.payments.index') }}" class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
          <i class="bi bi-cash-stack"></i> Payments
        </a>
      </li>
    </ul>
    <hr>
    <div>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-outline-danger w-100">
          <i class="bi bi-box-arrow-right"></i> Logout
        </button>
      </form>
    </div>
  </nav>

  <main class="content-area">
    @if(session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    @yield('content')
  </main>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
