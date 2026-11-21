@extends('layouts.library')

@section('title', 'Attendance — LMSP')

@section('content')
    <div class="container-fluid px-2 px-md-3 py-2" style="max-width: 1140px;">
        {{-- Compact Header --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
            <div>
                <h5 class="fw-bold mb-0">Daily Attendance</h5>
                <small class="text-muted">1-tap check-in, check-out & daily register</small>
            </div>

            <div class="d-flex flex-wrap align-items-center gap-2">
                <form method="GET" action="/library/attendance" class="d-flex align-items-center gap-1">
                    <input type="hidden" name="filter" value="{{ $filter }}">
                    <input type="hidden" name="search" value="{{ $search }}">
                    <input type="date" name="date" class="form-control form-control-sm" value="{{ $date }}"
                        onchange="this.form.submit()">
                </form>
                @if ($unmarkedCount > 0)
                    <form method="POST" action="/library/attendance/mark-all-present"
                        onsubmit="return confirm('Check-in all {{ $unmarkedCount }} unmarked active students?');">
                        @csrf
                        <input type="hidden" name="attendance_date" value="{{ $date }}">
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fa-solid fa-check-double me-1"></i> Check-in All ({{ $unmarkedCount }})
                        </button>
                    </form>
                @endif
                <a href="/library/attendance/kiosk" class="btn btn-dark btn-sm">
                    <i class="fa-solid fa-tablet-screen-button me-1"></i> Start Kiosk Mode
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show py-2 small" role="alert">
                <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Summary Strip --}}
        <div class="row g-2 mb-3">
            <div class="col-3">
                <div class="card border-0 shadow-sm text-center py-2">
                    <div class="text-muted" style="font-size: 0.72rem;">Present</div>
                    <div class="fw-bold fs-5 text-success">{{ $presentCount }}</div>
                </div>
            </div>
            <div class="col-3">
                <div class="card border-0 shadow-sm text-center py-2">
                    <div class="text-muted" style="font-size: 0.72rem;">Inside Now</div>
                    <div class="fw-bold fs-5 text-primary">{{ $insideNowCount }}</div>
                </div>
            </div>
            <div class="col-3">
                <div class="card border-0 shadow-sm text-center py-2">
                    <div class="text-muted" style="font-size: 0.72rem;">Absent</div>
                    <div class="fw-bold fs-5 text-danger">{{ $absentCount }}</div>
                </div>
            </div>
            <div class="col-3">
                <div class="card border-0 shadow-sm text-center py-2">
                    <div class="text-muted" style="font-size: 0.72rem;">Unmarked</div>
                    <div class="fw-bold fs-5 text-secondary">{{ $unmarkedCount }}</div>
                </div>
            </div>
        </div>

        {{-- Filter & Search Card --}}
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white py-2 px-3 border-bottom">
                <div class="row g-2 align-items-center">
                    <div class="col-12 col-md-7">
                        <div class="btn-group btn-group-sm flex-wrap" role="group">
                            @foreach (['all' => 'All', 'inside' => 'Inside', 'present' => 'Present', 'unmarked' => 'Unmarked', 'absent' => 'Absent'] as $key => $label)
                                <a href="/library/attendance?date={{ $date }}&filter={{ $key }}&search={{ urlencode($search) }}"
                                    class="btn {{ $filter === $key ? 'btn-primary' : 'btn-outline-primary' }}">
                                    {{ $label }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-12 col-md-5">
                        <form method="GET" action="/library/attendance" class="input-group input-group-sm">
                            <input type="hidden" name="date" value="{{ $date }}">
                            <input type="hidden" name="filter" value="{{ $filter }}">
                            <input type="text" name="search" class="form-control"
                                placeholder="Search student or code..." value="{{ $search }}">
                            <button type="submit" class="btn btn-outline-secondary">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light small">
                            <tr>
                                <th class="ps-3">Student</th>
                                <th>Seat</th>
                                <th>Status</th>
                                <th>In / Out</th>
                                <th class="text-end pe-3">Quick Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rows as $row)
                                @php
                                    $st = $row->student;
                                    $att = $row->attendance;
                                    $inTime =
                                        $att && $att->check_in_time
                                            ? \Carbon\Carbon::parse($att->check_in_time)->format('h:i A')
                                            : null;
                                    $outTime =
                                        $att && $att->check_out_time
                                            ? \Carbon\Carbon::parse($att->check_out_time)->format('h:i A')
                                            : null;
                                @endphp
                                <tr>
                                    <td class="ps-3">
                                        <a href="/library/students/view/{{ $st->id }}"
                                            class="fw-semibold text-decoration-none text-dark">
                                            {{ $st->name }}
                                        </a>
                                        <div class="text-muted" style="font-size: 0.74rem;">{{ $st->student_code }}</div>
                                    </td>
                                    <td>
                                        @if ($st->seat)
                                            <span
                                                class="badge bg-light text-dark border">{{ $st->seat->seat_number }}</span>
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if (!$att)
                                            <span
                                                class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Unmarked</span>
                                        @elseif ($att->status === 'absent')
                                            <span
                                                class="badge bg-danger-subtle text-danger border border-danger-subtle">Absent</span>
                                        @elseif (!$att->check_out_time)
                                            <span
                                                class="badge bg-success-subtle text-success border border-success-subtle">Inside</span>
                                        @else
                                            <span class="badge bg-info-subtle text-info border border-info-subtle">Checked
                                                Out</span>
                                        @endif
                                    </td>
                                    <td class="small">
                                        @if ($inTime)
                                            <div class="text-success fw-semibold">In: {{ $inTime }}</div>
                                        @endif
                                        @if ($outTime)
                                            <div class="text-muted">Out: {{ $outTime }}</div>
                                        @endif
                                        @if (!$inTime && !$outTime)
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="d-inline-flex gap-1">
                                            @if (!$att || $att->status === 'absent' || $att->check_out_time)
                                                <form method="POST"
                                                    action="/library/attendance/check-in/{{ $st->id }}">
                                                    @csrf
                                                    <input type="hidden" name="attendance_date"
                                                        value="{{ $date }}">
                                                    <button type="submit" class="btn btn-success btn-sm py-1 px-2">
                                                        <i class="fa-solid fa-right-to-bracket"></i> In
                                                    </button>
                                                </form>
                                            @endif

                                            @if ($att && $att->status === 'present' && !$att->check_out_time)
                                                <form method="POST"
                                                    action="/library/attendance/check-out/{{ $st->id }}">
                                                    @csrf
                                                    <input type="hidden" name="attendance_date"
                                                        value="{{ $date }}">
                                                    <button type="submit" class="btn btn-primary btn-sm py-1 px-2">
                                                        <i class="fa-solid fa-right-from-bracket"></i> Out
                                                    </button>
                                                </form>
                                            @endif

                                            @if (!$att || $att->status !== 'absent')
                                                <form method="POST"
                                                    action="/library/attendance/mark-absent/{{ $st->id }}">
                                                    @csrf
                                                    <input type="hidden" name="attendance_date"
                                                        value="{{ $date }}">
                                                    <button type="submit" class="btn btn-outline-danger btn-sm py-1 px-2"
                                                        title="Mark Absent">
                                                        <i class="fa-solid fa-xmark"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        No active students found for this filter.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
