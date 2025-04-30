<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h1 class="mb-4">Welcome, Admin {{ $user->name }}</h1>
    <div class="list-group">
      <a href="#" class="list-group-item">Manage Doctors</a>
      <a href="#" class="list-group-item">Manage Patients</a>
      <a href="#" class="list-group-item">View Reports</a>
    </div>
  </div>
</body>
</html>
