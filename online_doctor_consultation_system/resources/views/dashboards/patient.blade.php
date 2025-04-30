<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Patient Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h1 class="mb-4">Welcome {{ $user->name }}</h1>
    <div class="list-group">
      <a href="#" class="list-group-item">Book Appointment</a>
      <a href="#" class="list-group-item">My Medical Records</a>
      <a href="#" class="list-group-item">Profile Settings</a>
    </div>
  </div>
</body>
</html>
