<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Register - Online Doctor Consultation</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5.3 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">-->

  <style>
    body {
      background: url('https://images.unsplash.com/photo-1526256262350-7da7584cf5eb?fit=crop&w=1400&q=80') no-repeat center center fixed;
      background-size: cover;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .card {
      backdrop-filter: blur(10px);
      background: rgba(8, 6, 6, 0.8);
      border-radius: 15px;
      padding: 2rem;
      width: 100%;
      max-width: 400px;
      color: white;
    }
    .card a {
      color: #0dcaf0;
      text-decoration: underline;
    }

    .form-floating > label {
      color: #ced4da; /* Bootstrap's light gray */
      font-weight: 500;
    }
  </style>


</head>
<body>

<div class="card shadow-lg">
  <h3 class="text-center mb-4">Sign Up</h3>

  <form method="GET" action="/register">
    @csrf

    <div class="form-floating mb-3">
      <input type="text" name="name" class="form-control" id="name" placeholder="Name" required>
      <label for="name">Full Name</label>
    </div>

    <div class="form-floating mb-3">
      <input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
      <label for="email">Email address</label>
    </div>

    <div class="form-floating mb-3">
        <input type="text" name="mobile" class="form-control" id="mobile" placeholder="Mobile Number" required pattern="[0-9]{10,15}">
        <label for="mobile">Mobile Number</label>
      </div>

      <div class="form-floating mb-3">
        <select class="form-select" name="role" id="role" required>
          <option value="1" selected>Admin</option>
          <option value="2">Doctor</option>
          <option value="3">Patient</option>
        </select>
        <label for="role">Register As</label>
      </div>



      <div class="form-floating mb-3">
        <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
        <label for="password">Password</label>
      </div>

    <div class="form-floating mb-3">
      <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Confirm Password" required>
      <label for="password_confirmation">Confirm Password</label>
    </div>

    <button type="submit" class="btn btn-success w-100">Register</button>

    <div class="text-center mt-3">
      <small>Already have an account? <a href="/login">Login</a></small>
    </div>
  </form>
</div>

</body>
</html>
