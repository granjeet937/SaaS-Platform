<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration — {{ $library->library_name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #eff6ff 0%, #f8fafc 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        .reg-card {
            max-width: 520px;
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(15, 23, 42, 0.08);
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center p-3">

    <div class="card border-0 reg-card overflow-hidden">
        <div class="bg-primary text-white p-4 text-center">
            <span class="badge bg-white text-primary rounded-pill px-3 py-1 mb-2 fw-semibold">
                ONLINE ADMISSION FORM
            </span>
            <h4 class="fw-bold mb-1">{{ $library->library_name }}</h4>
            <p class="small text-white-50 mb-0">
                {{ $library->city }}{{ $library->state ? ', ' . $library->state : '' }}
            </p>
        </div>

        <div class="card-body p-4">
            @if (session('submitted'))
                <div class="text-center py-4">
                    <div class="text-success mb-3" style="font-size: 3.2rem;">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Registration Submitted!</h4>
                    <p class="text-muted small mb-4">
                        Your details have been sent to <strong>{{ $library->library_name }}</strong>.
                        Please meet the library admin at the desk to get your seat and fee plan activated.
                    </p>
                    <a href="{{ route('public.admission.form', $token) }}"
                        class="btn btn-outline-primary btn-sm rounded-pill px-4">
                        Register Another Student
                    </a>
                </div>
            @else
                @if ($errors->any())
                    <div class="alert alert-danger py-2 small">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('public.admission.store', $token) }}">
                    @csrf

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-semibold mb-1">Full Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                placeholder="Enter your full name" maxlength="100" required>
                        </div>

                        <div class="col-12 col-sm-6">
                            <label class="form-label small fw-semibold mb-1">Mobile Number <span
                                    class="text-danger">*</span></label>
                            <input type="tel" name="mobile" class="form-control" value="{{ old('mobile') }}"
                                placeholder="10-digit mobile" maxlength="20" inputmode="tel" required>
                        </div>

                        <div class="col-12 col-sm-6">
                            <label class="form-label small fw-semibold mb-1">Joining Date <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="admission_date" class="form-control"
                                value="{{ old('admission_date', date('Y-m-d')) }}" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-semibold mb-1">Email Address (Optional)</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                                placeholder="you@example.com" maxlength="100">
                        </div>

                        <div class="col-12 col-sm-6">
                            <label class="form-label small fw-semibold mb-1">Guardian / Father Name</label>
                            <input type="text" name="guardian_name" class="form-control"
                                value="{{ old('guardian_name') }}" placeholder="Guardian name" maxlength="100">
                        </div>

                        <div class="col-12 col-sm-6">
                            <label class="form-label small fw-semibold mb-1">Guardian Mobile</label>
                            <input type="tel" name="guardian_mobile" class="form-control"
                                value="{{ old('guardian_mobile') }}" placeholder="Emergency contact" maxlength="20"
                                inputmode="tel">
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-semibold mb-1">Full Address</label>
                            <textarea name="address" class="form-control" rows="2" placeholder="House/Street, Village/City">{{ old('address') }}</textarea>
                        </div>

                        <div class="col-12 mt-3">
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-3">
                                <i class="fa-solid fa-paper-plane me-1"></i> Submit Registration
                            </button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>

</body>

</html>
