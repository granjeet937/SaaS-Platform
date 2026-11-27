<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SaaS Admin Login — LMSP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: radial-gradient(circle at top right, #1e3a8a 0%, #07162e 55%, #040b18 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', system-ui, sans-serif;
            padding: 16px;
        }

        .login-card {
            max-width: 420px;
            width: 100%;
            background: #ffffff;
            border-radius: 22px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.45);
            overflow: hidden;
        }
    </style>
</head>

<body>
    <div class="login-card p-4 p-md-5">
        <div class="text-center mb-4">
            <div class="rounded-4 bg-primary text-white d-inline-grid mb-3 shadow-sm"
                style="width:52px;height:52px;place-items:center;font-size:22px;">
                <i class="fa-solid fa-crown"></i>
            </div>
            <h4 class="fw-bold mb-1">LMSP SaaS Admin</h4>
            <p class="text-muted small mb-0">Sign in to manage libraries, approvals & subscriptions</p>
        </div>

        @if (session('error'))
            <div class="alert alert-danger py-2 small rounded-3">{{ session('error') }}</div>
        @endif
        @if (session('success'))
            <div class="alert alert-success py-2 small rounded-3">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ url('/rgsmadmin') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-semibold">Admin Email</label>
                <input type="email" name="email" class="form-control rounded-3 py-2" value="{{ old('email') }}"
                    placeholder="contact@lmsp.com" required autofocus>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-semibold">Password</label>
                <input type="password" name="password" class="form-control rounded-3 py-2" placeholder="••••••••"
                    required>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4 small">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="rememberAdmin">
                    <label class="form-check-label text-muted" for="rememberAdmin">Remember me</label>
                </div>
                <a href="{{ url('/') }}" class="text-decoration-none">Back to Website</a>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold rounded-3">
                <i class="fa-solid fa-right-to-bracket me-1"></i> Login to Admin Console
            </button>

            <div class="text-center mt-3 small">
                <span class="text-muted">First time setup?</span>
                <a href="{{ url('/rgsmadmin/register') }}" class="text-decoration-none fw-semibold">Create Super
                    Admin</a>
            </div>
        </form>
    </div>
</body>

</html>
