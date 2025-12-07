<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex align-items-center justify-content-center vh-100">
    <div class="card shadow-sm p-4" style="width: 100%; max-width: 420px;">
        <h3 class="card-title text-center mb-3">Forgot Password</h3>
        <p class="text-center text-muted mb-4">Enter your email to receive a password reset link</p>

        <!-- Status Message -->
        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <!-- Validation Errors -->
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <p class="mb-0">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <input type="email" name="email" class="form-control form-control-lg" placeholder="Your Email" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">Send Reset Link</button>
            </div>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('login.show') }}">Back to Login</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
