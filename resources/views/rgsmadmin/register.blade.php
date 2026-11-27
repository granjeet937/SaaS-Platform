<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SaaS Admin Registration — LMSP</title>
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

        .reg-card {
            max-width: 450px;
            width: 100%;
            background: #ffffff;
            border-radius: 22px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.45);
        }
    </style>
</head>

<body>
    <div class="reg-card p-4 p-md-5">
        <div class="text-center mb-4">
            <div class="rounded-4 bg-primary text-white d-inline-grid mb-3 shadow-sm"
                style="width:52px;height:52px;place-items:center;font-size:22px;">
                <i class="fa-solid fa-user-shield"></i>
            </div>
            <h4 class="fw-bold mb-1">Create Super Admin</h4>
            <p class="text-muted small mb-0">Authorized LMSP SaaS Owner Setup</p>
        </div>

        @if (session('error'))
            <div class="alert alert-danger py-2 small rounded-3">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger py-2 small rounded-3">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/rgsmadmin/register') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label small fw-semibold">Secret Setup Key</label>
                <input type="password" name="setup_key" class="form-control rounded-3"
                    placeholder="Enter setup key" required>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-semibold">Full Name</label>
                <input type="text" name="name" class="form-control rounded-3" value="{{ old('name') }}"
                    placeholder="Satyendra Kumar Maurya" required>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-semibold">Admin Email</label>
                <input type="email" name="email" class="form-control rounded-3" value="{{ old('email') }}"
                    placeholder="admin@lmsp.com" required>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-semibold">Mobile Number (10 digits)</label>
                <input type="text" name="phone" class="form-control rounded-3" value="{{ old('phone') }}"
                    maxlength="10" placeholder="9876543210" required>
            </div>

            <div class="row g-2 mb-4">
                <div class="col-6">
                    <label class="form-label small fw-semibold">Password</label>
                    <input type="password" name="password" class="form-control rounded-3" placeholder="Min 8 chars"
                        required>
                </div>
                <div class="col-6">
                    <label class="form-label small fw-semibold">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control rounded-3"
                        placeholder="Repeat password" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold rounded-3">
                <i class="fa-solid fa-check-circle me-1"></i> Create Admin Account
            </button>

            <div class="text-center mt-3 small">
                <a href="{{ url('/rgsmadmin') }}" class="text-decoration-none">Already registered? Login here</a>
            </div>
        </form>
    </div>
</body>

</html>
