<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Login - Online Doctor Consultation</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5.3 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: url('https://images.unsplash.com/photo-1603398938378-02a6c5b82c88?fit=crop&w=1400&q=80') no-repeat center center fixed;
      background-size: cover;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .card {
      backdrop-filter: blur(10px);
      background: rgba(255, 255, 255, 0.8);
      border-radius: 15px;
      padding: 2rem;
      width: 100%;
      max-width: 400px;
    }
  </style>
</head>
<body>

<div class="card shadow-lg">
  <h3 class="text-center mb-4">Login</h3>

  <form method="GET" action="/login">
    @csrf

    <div class="form-floating mb-3">
      <input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
      <label for="email">Email address</label>
    </div>

    <div class="form-floating mb-3">
      <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
      <label for="password">Password</label>
    </div>

    <div class="mb-3 form-check">
      <input type="checkbox" class="form-check-input" id="remember" name="remember">
      <label class="form-check-label" for="remember">Remember Me</label>
    </div>

    <button type="submit" class="btn btn-primary w-100">Login</button>

    <div class="text-center mt-3">
      <small>Don't have an account? <a href="/register">Sign Up</a></small>
    </div>
  </form>
</div>

</body>
</html>
