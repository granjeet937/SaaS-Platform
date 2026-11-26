@extends('layouts.library')

@section('title', 'Students — LMSP')

@section('content')
    @php
        $library = auth()->user()->library;
        if ($library && empty($library->admission_token)) {
            $library->update(['admission_token' => strtoupper(\Illuminate\Support\Str::random(16))]);
        }
        $inviteToken = $library->admission_token ?? '';
        $inviteUrl = $inviteToken ? url('/admission/' . $inviteToken) : '';
        $pendingCount = $library
            ? \App\Models\Student::where('library_id', $library->id)->where('status', 'pending')->count()
            : 0;
    @endphp

    <style>
        .filter-scroll {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }

        .filter-scroll::-webkit-scrollbar {
            display: none;
        }

        .student-mobile-card {
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            background: #fff;
            transition: box-shadow 0.15s ease;
        }
    </style>

    <div class="container-fluid px-2 px-sm-3 py-2" style="max-width: 1200px;">

        {{-- Top Page Header --}}
        <div
            class="d-flex flex-column flex-sm-row justify-content-between align-items-stretch align-items-sm-center mb-3 gap-2">
            <div>
                <h4 class="fw-bold mb-0">Students Directory</h4>
                <small class="text-muted">Manage admissions, shifts, and seats</small>
            </div>

            <div class="d-flex align-items-center justify-content-between justify-content-sm-end gap-2">
                @if ($pendingCount > 0)
                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fw-semibold">
                        <i class="fa-solid fa-hourglass-half me-1"></i> {{ $pendingCount }} Pending
                    </span>
                @endif
                <a href="/library/students/add" class="btn btn-primary btn-sm px-3 py-2 fw-semibold rounded-3 shadow-sm">
                    <i class="fa-solid fa-user-plus me-1"></i> Add Student
                </a>
            </div>
        </div>

        {{-- Flash Alerts --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show py-2 small rounded-3" role="alert">
                <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show py-2 small rounded-3" role="alert">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Responsive Student Self-Registration Link Card --}}
        @if ($inviteUrl)
            <div class="card border-0 shadow-sm rounded-4 mb-3"
                style="background: linear-gradient(135deg, #eff6ff 0%, #f8fafc 100%); border-left: 4px solid #2563eb !important;">
                <div class="card-body p-3">
                    <div class="row align-items-center g-2">
                        <div class="col-12 col-lg-7">
                            <div class="d-flex align-items-start align-items-sm-center gap-2">
                                <div class="bg-primary text-white rounded-3 d-flex align-items-center justify-content-center flex-shrink-0 mt-1 mt-sm-0"
                                    style="width: 36px; height: 36px;">
                                    <i class="fa-solid fa-link"></i>
                                </div>
                                <div class="min-w-0 flex-grow-1">
                                    <div class="fw-bold text-primary small">Self-Registration Link</div>
                                    <div class="text-dark small text-break user-select-all" style="font-size: 0.78rem;">
                                        {{ $inviteUrl }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-5">
                            <div class="d-flex gap-2 justify-content-stretch justify-content-lg-end">
                                <button type="button" id="copyInviteBtn"
                                    class="btn btn-primary btn-sm rounded-3 flex-grow-1 flex-lg-grow-0 px-3"
                                    onclick="copyInviteLink('{{ $inviteUrl }}')">
                                    <i class="fa-regular fa-copy me-1"></i> Copy
                                </button>

                                <a href="https://wa.me/?text={{ urlencode('Hello! Register online for ' . ($library->library_name ?? 'our study library') . ' using this link: ' . $inviteUrl) }}"
                                    target="_blank"
                                    class="btn btn-success btn-sm rounded-3 flex-grow-1 flex-lg-grow-0 px-3">
                                    <i class="fa-brands fa-whatsapp me-1"></i> Share
                                </a>

                                <form method="POST" action="/library/students/regenerate-token" class="d-inline"
                                    onsubmit="return confirm('Generate a new registration link? The previous link will immediately stop working.');">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-secondary btn-sm rounded-3 px-2"
                                        title="Reset & Generate New Link">
                                        <i class="fa-solid fa-rotate"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Filter & Search Bar --}}
        <div class="card border-0 shadow-sm rounded-4 mb-3">
            <div class="card-body p-2 p-sm-3">
                <div class="row g-2 align-items-center">
                    <div class="col-12 col-md-6">
                        <div class="filter-scroll">
                            <div class="btn-group btn-group-sm w-100 w-sm-auto" role="group" id="statusFilterGroup">
                                <button type="button" class="btn btn-primary active text-nowrap"
                                    data-filter="all">All</button>
                                <button type="button" class="btn btn-outline-primary text-nowrap" data-filter="pending">
                                    Pending @if ($pendingCount > 0)
                                        ({{ $pendingCount }})
                                    @endif
                                </button>
                                <button type="button" class="btn btn-outline-primary text-nowrap"
                                    data-filter="active">Active</button>
                                <button type="button" class="btn btn-outline-primary text-nowrap"
                                    data-filter="inactive">Inactive</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fa-solid fa-magnifying-glass text-muted"></i>
                            </span>
                            <input type="text" id="studentQuickSearch" class="form-control border-start-0"
                                placeholder="Search name, mobile, code, shift or seat...">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MOBILE CARD LIST --}}
        <div class="d-md-none" id="mobileStudentsList">
            @forelse ($students as $student)
                @php
                    $initials =
                        collect(explode(' ', trim($student->name)))
                            ->filter()
                            ->take(2)
                            ->map(fn($p) => strtoupper(substr($p, 0, 1)))
                            ->implode('') ?:
                        'ST';
                    $searchBlob = strtolower(
                        $student->name .
                            ' ' .
                            $student->mobile .
                            ' ' .
                            $student->student_code .
                            ' ' .
                            ($student->seat?->seat_number ?? '') .
                            ' ' .
                            ($student->shift?->shift_name ?? ''),
                    );
                @endphp
                <div class="student-mobile-card p-3 mb-2 shadow-sm student-item" data-status="{{ $student->status }}"
                    data-search="{{ $searchBlob }}">
                    <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                        <div class="d-flex align-items-center gap-2 min-w-0">
                            <div class="rounded-circle bg-primary-subtle text-primary fw-bold d-flex align-items-center justify-content-center flex-shrink-0"
                                style="width: 40px; height: 40px; font-size: 0.85rem;">
                                {{ $initials }}
                            </div>
                            <div class="min-w-0">
                                <a href="/library/students/view/{{ $student->id }}"
                                    class="fw-bold text-dark text-decoration-none d-block text-truncate">
                                    {{ $student->name }}
                                </a>
                                <div class="text-muted" style="font-size: 0.74rem;">
                                    {{ $student->student_code }}
                                    @if ($student->shift)
                                        &bull; <span
                                            class="text-primary fw-semibold">{{ $student->shift->shift_name }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="flex-shrink-0">
                            @if ($student->status === 'pending')
                                <span
                                    class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill">Pending</span>
                            @elseif ($student->status === 'active')
                                <span
                                    class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Active</span>
                            @else
                                <span
                                    class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill">{{ ucfirst($student->status) }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row g-2 bg-light rounded-3 p-2 mb-2 small text-center">
                        <div class="col-4 border-end">
                            <div class="text-muted" style="font-size: 0.68rem;">Mobile</div>
                            <a href="tel:{{ $student->mobile }}"
                                class="fw-semibold text-dark text-decoration-none">{{ $student->mobile }}</a>
                        </div>
                        <div class="col-4 border-end">
                            <div class="text-muted" style="font-size: 0.68rem;">Seat</div>
                            <div class="fw-semibold text-dark">{{ $student->seat?->seat_number ?? 'None' }}</div>
                        </div>
                        <div class="col-4">
                            <div class="text-muted" style="font-size: 0.68rem;">Monthly</div>
                            <div class="fw-semibold text-primary">
                                {{ $student->status === 'pending' ? '—' : '₹' . number_format((float) $student->payable_fee, 0) }}
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        @if ($student->status === 'pending')
                            <button type="button" class="btn btn-warning btn-sm fw-semibold text-dark flex-grow-1"
                                data-bs-toggle="modal" data-bs-target="#approveStudentModal"
                                data-id="{{ $student->id }}" data-name="{{ $student->name }}"
                                data-mobile="{{ $student->mobile }}"
                                data-date="{{ $student->admission_date?->format('Y-m-d') ?? date('Y-m-d') }}">
                                <i class="fa-solid fa-check-circle me-1"></i> Approve & Assign
                            </button>
                        @endif

                        <a href="/library/students/view/{{ $student->id }}"
                            class="btn btn-outline-primary btn-sm {{ $student->status === 'pending' ? '' : 'w-100' }}">
                            <i class="fa-solid fa-eye me-1"></i> View Details
                        </a>
                    </div>
                </div>
            @empty
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center text-muted">
                    No students found yet. Tap <strong>Add Student</strong> or share your invite link above.
                </div>
            @endforelse
        </div>

        {{-- DESKTOP TABLE VIEW --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden d-none d-md-block">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light small text-uppercase text-muted">
                        <tr>
                            <th class="ps-3">Student</th>
                            <th>Mobile</th>
                            <th>Shift</th>
                            <th>Seat</th>
                            <th>Payable Fee</th>
                            <th>Status</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $student)
                            @php
                                $initials =
                                    collect(explode(' ', trim($student->name)))
                                        ->filter()
                                        ->take(2)
                                        ->map(fn($p) => strtoupper(substr($p, 0, 1)))
                                        ->implode('') ?:
                                    'ST';
                                $searchBlob = strtolower(
                                    $student->name .
                                        ' ' .
                                        $student->mobile .
                                        ' ' .
                                        $student->student_code .
                                        ' ' .
                                        ($student->seat?->seat_number ?? '') .
                                        ' ' .
                                        ($student->shift?->shift_name ?? ''),
                                );
                            @endphp
                            <tr class="student-item" data-status="{{ $student->status }}"
                                data-search="{{ $searchBlob }}">
                                <td class="ps-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-primary-subtle text-primary fw-bold d-flex align-items-center justify-content-center flex-shrink-0"
                                            style="width: 36px; height: 36px; font-size: 0.82rem;">
                                            {{ $initials }}
                                        </div>
                                        <div>
                                            <a href="/library/students/view/{{ $student->id }}"
                                                class="fw-semibold text-dark text-decoration-none">
                                                {{ $student->name }}
                                            </a>
                                            <div class="text-muted" style="font-size: 0.74rem;">
                                                {{ $student->student_code }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="small">
                                    <a href="tel:{{ $student->mobile }}" class="text-decoration-none text-dark">
                                        {{ $student->mobile }}
                                    </a>
                                </td>

                                <td>
                                    @if ($student->shift)
                                        <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle">
                                            {{ $student->shift->shift_name }}
                                        </span>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>

                                <td>
                                    @if ($student->seat)
                                        <span class="badge bg-light text-dark border fw-semibold">
                                            <i
                                                class="fa-solid fa-chair text-primary me-1"></i>{{ $student->seat->seat_number }}
                                        </span>
                                    @else
                                        <span class="text-muted small">Unassigned</span>
                                    @endif
                                </td>

                                <td class="fw-semibold">
                                    @if ($student->status === 'pending')
                                        <span class="text-muted small">—</span>
                                    @else
                                        ₹{{ number_format((float) $student->payable_fee, 0) }}
                                    @endif
                                </td>

                                <td>
                                    @if ($student->status === 'pending')
                                        <span
                                            class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-2">
                                            <i class="fa-solid fa-clock me-1"></i>Pending
                                        </span>
                                    @elseif ($student->status === 'active')
                                        <span
                                            class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2">
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-2">
                                            {{ ucfirst($student->status) }}
                                        </span>
                                    @endif
                                </td>

                                <td class="text-end pe-3">
                                    <div class="d-inline-flex gap-1">
                                        @if ($student->status === 'pending')
                                            <button type="button" class="btn btn-warning btn-sm fw-semibold text-dark"
                                                data-bs-toggle="modal" data-bs-target="#approveStudentModal"
                                                data-id="{{ $student->id }}" data-name="{{ $student->name }}"
                                                data-mobile="{{ $student->mobile }}"
                                                data-date="{{ $student->admission_date?->format('Y-m-d') ?? date('Y-m-d') }}">
                                                <i class="fa-solid fa-check-circle me-1"></i> Approve & Assign
                                            </button>
                                        @endif

                                        <a href="/library/students/view/{{ $student->id }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fa-solid fa-eye me-1"></i> View
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    No students found yet. Click <strong>Add Student</strong> or share your registration
                                    link above.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if ($students->hasPages())
            <div class="mt-3 d-flex justify-content-center">
                {{ $students->links() }}
            </div>
        @endif
    </div>

    {{-- Responsive Approve & Assign Shift/Seat/Fee Modal --}}
    <div class="modal fade" id="approveStudentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <form id="approveStudentForm" method="POST" action="">
                    @csrf
                    <div class="modal-header border-0 pb-1">
                        <div>
                            <h5 class="modal-title fw-bold mb-0">Approve & Activate Student</h5>
                            <small class="text-muted" id="modalStudentSubtitle">Assign shift, seat & monthly fee</small>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body pt-2">
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <label class="form-label small fw-semibold mb-1">Admission Date <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="admission_date" id="approveAdmissionDate"
                                    class="form-control" required>
                            </div>

                            <div class="col-12 col-sm-6">
                                <label class="form-label small fw-semibold mb-1">Select Shift <span
                                        class="text-danger">*</span></label>
                                <select name="shift_id" id="approveShiftSelect" class="form-select" required>
                                    <option value="" data-fee="">-- Choose Shift --</option>
                                    @foreach ($shifts as $sh)
                                        <option value="{{ $sh->id }}" data-fee="{{ $sh->monthly_fee }}">
                                            {{ $sh->shift_name }} (₹{{ (int) $sh->monthly_fee }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label small fw-semibold mb-1">Assign Seat</label>
                                <select name="seat_id" class="form-select">
                                    <option value="">-- No Seat (Optional) --</option>
                                    @foreach ($availableSeats as $seat)
                                        @php
                                            $usedHrs = $seat->activeStudents->sum(
                                                fn($s) => $s->shift->duration_hours ?? 0,
                                            );
                                        @endphp
                                        <option value="{{ $seat->id }}">
                                            {{ $seat->seat_number }}{{ $seat->section ? ' (' . $seat->section . ')' : '' }}{{ $usedHrs > 0 ? " - {$usedHrs}/24h used" : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-6">
                                <label class="form-label small fw-semibold mb-1">Monthly Fee (₹) <span
                                        class="text-danger">*</span></label>
                                <input type="number" step="0.01" min="0" name="total_fee"
                                    id="approveTotalFee" class="form-control" placeholder="800" required>
                            </div>

                            <div class="col-6">
                                <label class="form-label small fw-semibold mb-1">Discount (₹)</label>
                                <input type="number" step="0.01" min="0" name="discount"
                                    id="approveDiscount" class="form-control" value="0">
                            </div>

                            <div class="col-12">
                                <div
                                    class="p-2 px-3 rounded-3 bg-light border d-flex justify-content-between align-items-center">
                                    <span class="small fw-semibold text-muted">Net Monthly Payable:</span>
                                    <span class="fw-bold fs-5 text-primary" id="approvePayablePreview">₹0.00</span>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-label small fw-semibold mb-1">Initial Payment (₹)</label>
                                <input type="number" step="0.01" min="0" name="initial_payment"
                                    id="approveInitialPayment" class="form-control" value="0">
                            </div>

                            <div class="col-6">
                                <label class="form-label small fw-semibold mb-1">Payment Mode</label>
                                <select name="payment_method" class="form-select">
                                    <option value="cash">Cash</option>
                                    <option value="upi">UPI</option>
                                    <option value="card">Card</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label small fw-semibold mb-1">Transaction / Ref ID (Optional)</label>
                                <input type="text" name="reference_number" class="form-control"
                                    placeholder="UPI Ref / Receipt note">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success fw-semibold px-4">
                            <i class="fa-solid fa-check me-1"></i> Activate Student
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function copyInviteLink(url) {
            const btn = document.getElementById('copyInviteBtn');
            const originalHtml = btn.innerHTML;

            function showCopiedFeedback() {
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-dark');
                btn.innerHTML = '<i class="fa-solid fa-check me-1"></i> Copied';
                setTimeout(() => {
                    btn.classList.remove('btn-dark');
                    btn.classList.add('btn-primary');
                    btn.innerHTML = originalHtml;
                }, 2000);
            }

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(url).then(showCopiedFeedback).catch(() => fallbackCopy(url));
            } else {
                fallbackCopy(url);
            }

            function fallbackCopy(text) {
                const textArea = document.createElement('textarea');
                textArea.value = text;
                textArea.style.position = 'fixed';
                textArea.style.left = '-9999px';
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                try {
                    document.execCommand('copy');
                    showCopiedFeedback();
                } catch (err) {
                    alert('Copy failed. Please copy manually: ' + text);
                }
                document.body.removeChild(textArea);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const approveModal = document.getElementById('approveStudentModal');
            if (approveModal) {
                const totalEl = document.getElementById('approveTotalFee');
                const discountEl = document.getElementById('approveDiscount');
                const previewEl = document.getElementById('approvePayablePreview');
                const shiftEl = document.getElementById('approveShiftSelect');

                function updatePayable() {
                    const total = parseFloat(totalEl.value) || 0;
                    const disc = parseFloat(discountEl.value) || 0;
                    const net = Math.max(0, total - disc);
                    previewEl.textContent = '₹' + net.toFixed(2);
                }

                approveModal.addEventListener('show.bs.modal', function(event) {
                    const btn = event.relatedTarget;
                    const id = btn.getAttribute('data-id');
                    const name = btn.getAttribute('data-name');
                    const mobile = btn.getAttribute('data-mobile');
                    const date = btn.getAttribute('data-date');

                    document.getElementById('approveStudentForm').action =
                        `/library/students/approve/${id}`;
                    document.getElementById('modalStudentSubtitle').textContent = `${name} (${mobile})`;
                    document.getElementById('approveAdmissionDate').value = date;
                    if (shiftEl) shiftEl.value = '';
                    totalEl.value = '';
                    discountEl.value = '0';
                    document.getElementById('approveInitialPayment').value = '0';
                    previewEl.textContent = '₹0.00';
                });

                if (shiftEl) {
                    shiftEl.addEventListener('change', function() {
                        const fee = this.options[this.selectedIndex]?.dataset?.fee;
                        if (fee !== undefined && fee !== '') {
                            totalEl.value = fee;
                            updatePayable();
                        }
                    });
                }

                totalEl.addEventListener('input', updatePayable);
                discountEl.addEventListener('input', updatePayable);
            }

            let activeStatus = 'all';
            const searchInput = document.getElementById('studentQuickSearch');
            const items = document.querySelectorAll('.student-item');

            function filterItems() {
                const term = (searchInput?.value || '').toLowerCase().trim();
                items.forEach(item => {
                    const itemStatus = item.getAttribute('data-status');
                    const itemText = item.getAttribute('data-search') || '';
                    const matchesStatus = (activeStatus === 'all' || itemStatus === activeStatus);
                    const matchesSearch = (term === '' || itemText.includes(term));
                    item.style.display = (matchesStatus && matchesSearch) ? '' : 'none';
                });
            }

            document.querySelectorAll('#statusFilterGroup button').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('#statusFilterGroup button').forEach(b => {
                        b.classList.remove('btn-primary', 'active');
                        b.classList.add('btn-outline-primary');
                    });
                    this.classList.remove('btn-outline-primary');
                    this.classList.add('btn-primary', 'active');
                    activeStatus = this.getAttribute('data-filter');
                    filterItems();
                });
            });

            if (searchInput) {
                searchInput.addEventListener('input', filterItems);
            }
        });
    </script>
@endsection
