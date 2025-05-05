<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register – Online Doctor Consult</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  @php
    // Detect if we're in reset mode (prefilled form)
    $isReset = isset($user);
  @endphp
  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="card-header text-center">
            <h4>{{ $isReset ? 'Reset Password' : 'Register' }}</h4>
          </div>
          <div class="card-body">
            <form action="{{ route('register.submit') }}" method="POST">
              @csrf

              {{-- Include user id if resetting --}}
              @if($isReset)
                <input type="hidden" name="id" value="{{ $user->id }}">
              @endif

              <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text"
                       class="form-control"
                       id="name"
                       name="name"
                       value="{{ old('name', $user->name ?? '') }}"
                       {{ $isReset ? 'readonly' : '' }}
                       required>
              </div>

              <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email"
                       class="form-control"
                       id="email"
                       name="email"
                       value="{{ old('email', $user->email ?? '') }}"
                       {{ $isReset ? 'readonly' : '' }}
                       required>
              </div>

              <div class="mb-3">
                <label for="mobile" class="form-label">Mobile Number</label>
                <input type="text"
                       class="form-control"
                       id="mobile"
                       name="mobile"
                       value="{{ old('mobile', $user->mobile ?? '') }}"
                       {{ $isReset ? 'readonly' : '' }}
                       required>
              </div>



<div class="mb-3">
  <label for="role" class="form-label">Role</label>

  @if($isReset)
    {{-- Reset mode: lock the role and include it as a hidden field --}}
    <input type="hidden" name="id"   value="{{ $user->id }}">
    <input type="hidden" name="role" value="{{ $user->role }}">
    <select class="form-select" disabled>
        <option>{{ ucfirst($user->roleModel->name) }}</option>
    </select>
  @else
    <select
      id="role"
      name="role"
      class="form-select @error('role') is-invalid @enderror"
      required
    >
      <option value="" disabled selected>Choose one</option>

      @foreach($roles as $role)
        {{-- Only show “Admin” if none exists yet --}}
        @if(!($role->id === 1 && $adminExists))
          <option
            value="{{ $role->id }}"
            {{ old('role') == $role->id ? 'selected' : '' }}
          >
            {{ ucfirst($role->name) }}
          </option>
        @endif
      @endforeach
    </select>
    @error('role')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  @endif
</div>


              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password"
                       class="form-control"
                       id="password"
                       name="password"
                       required>
              </div>

              <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password"
                       class="form-control"
                       id="password_confirmation"
                       name="password_confirmation"
                       required>
              </div>

              <div class="d-grid">
                <button type="submit" class="btn btn-success">
                  {{ $isReset ? 'Update Password' : 'Register' }}
                </button>
              </div>

            </form>
            <hr>
            <p class="text-center mb-0">
              @if($isReset)
                <a href="{{ route('login') }}">Back to Login</a>
              @else
                Already have an account?
                <a href="{{ route('login') }}">Login here</a>
              @endif
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
