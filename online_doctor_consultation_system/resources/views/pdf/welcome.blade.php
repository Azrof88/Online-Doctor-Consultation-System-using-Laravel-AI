<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Welcome to Online Doctor System</title>
  <style>
    body { font-family: sans-serif; }
    h1 { color: #2c3e50; }
    p  { font-size: 14px; }
    .info { margin-top: 20px; }
  </style>
</head>
<body>
  <h1>Welcome, {{ $user->name }}!</h1>
  <p>Thank you for registering as a <strong>{{ ucfirst($user->role) }}</strong> at Online Doctor System.</p>

  <div class="info">
    <h2>Your Account Details</h2>
    <ul>
      <li><strong>Name:</strong> {{ $user->name }}</li>
      <li><strong>Email:</strong> {{ $user->email }}</li>
      <li><strong>Mobile:</strong> {{ $user->mobile }}</li>
      <li><strong>User Type:</strong> {{ ucfirst($user->role) }}</li>
    </ul>
  </div>

  <p>If you have any questions, just reply to this email.</p>
  <p>— The Online Doctor Team</p>
</body>
</html>
