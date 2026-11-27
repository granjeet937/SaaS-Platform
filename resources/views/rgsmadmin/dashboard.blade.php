@extends('layouts.rgsmadmin')

@section('title', 'SaaS Admin Dashboard — LMSP')

@section('content')
    {{-- KPI Summary Strip --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small fw-semibold">Total Libraries</span>
                        <span class="badge bg-primary-subtle text-primary rounded-3 p-2"><i
                                class="fa-solid fa-building-columns"></i></span>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $stats['totalLibraries'] }}</h3>
                    <small class="text-success">{{ $stats['activeLibraries'] }} active tenants</small>
                </div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small fw-semibold">Pending Approval</span>
                        <span class="badge bg-warning-subtle text-warning rounded-3 p-2"><i
                                class="fa-solid fa-hourglass-half"></i></span>
                    </div>
                    <h3 class="fw-bold mb-0 text-warning">{{ $stats['pendingLibraries'] }}</h3>
                    <small class="text-muted">Awaiting verification</small>
                </div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small fw-semibold">Total Students</span>
                        <span class="badge bg-info-subtle text-info rounded-3 p-2"><i class="fa-solid fa-users"></i></span>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $stats['totalStudents'] }}</h3>
                    <small class="text-muted">Across all libraries</small>
                </div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small fw-semibold">Active Subscriptions</span>
                        <span class="badge bg-success-subtle text-success rounded-3 p-2"><i
                                class="fa-solid fa-crown"></i></span>
                    </div>
                    <h3 class="fw-bold mb-0 text-success">{{ $stats['activeSubscriptions'] }}</h3>
                    <small class="text-muted">SaaS MRR: ₹{{ number_format($stats['saasRevenue'], 0) }}</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Registered Libraries Management Table --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div
            class="card-header bg-white py-3 px-4 border-bottom d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h6 class="fw-bold mb-0">Registered Study Libraries</h6>
                <small class="text-muted">Approve new libraries, inspect plans, or suspend accounts</small>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <div class="btn-group btn-group-sm">
                    @foreach (['all' => 'All', 'pending' => 'Pending', 'active' => 'Active', 'suspended' => 'Suspended'] as $key => $label)
                        <a href="{{ url('/rgsmadmin/dashboard?status=' . $key . '&search=' . urlencode($search)) }}"
                            class="btn {{ $statusFilter === $key ? 'btn-primary' : 'btn-outline-primary' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>

                <form method="GET" action="{{ url('/rgsmadmin/dashboard') }}" class="input-group input-group-sm"
                    style="width: 230px;">
                    <input type="hidden" name="status" value="{{ $statusFilter }}">
                    <input type="text" name="search" class="form-control" placeholder="Search library or code..."
                        value="{{ $search }}">
                    <button class="btn btn-outline-secondary" type="submit"><i class="fa-solid fa-search"></i></button>
                </form>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light small">
                        <tr>
                            <th class="ps-4">Library</th>
                            <th>Owner & Contact</th>
                            <th>Location</th>
                            <th>Seats / Students</th>
                            <th>Plan</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($libraries as $lib)
                            @php
                                $owner = $lib->users->first();
                                $sub = $lib->activeSubscription;
                            @endphp
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ $lib->library_name }}</div>
                                    <div class="small text-muted">{{ $lib->library_code }} &bull; {{ $lib->library_type }}
                                    </div>
                                </td>
                                <td class="small">
                                    <div class="fw-semibold">{{ $owner?->name ?? '—' }}</div>
                                    <div class="text-muted">{{ $owner?->email ?? '—' }}</div>
                                    <div class="text-muted">{{ $owner?->phone ?? '' }}</div>
                                </td>
                                <td class="small">
                                    {{ $lib->city }}, {{ $lib->state }}
                                    <div class="text-muted">{{ $lib->pincode }}</div>
                                </td>
                                <td class="small">
                                    <strong>{{ $lib->students_count }}</strong> / {{ $lib->total_seats }} seats
                                </td>
                                <td class="small">
                                    <span class="badge bg-light text-dark border">
                                        {{ $sub?->plan?->name ?? 'No Plan' }}
                                    </span>
                                    @if ($sub?->end_date)
                                        <div class="text-muted" style="font-size: 11px;">Exp:
                                            {{ $sub->end_date->format('d M Y') }}</div>
                                    @endif
                                </td>
                                <td>
                                    @if ($lib->status === 'active')
                                        <span
                                            class="badge bg-success-subtle text-success border border-success-subtle">Active</span>
                                    @elseif ($lib->status === 'pending')
                                        <span
                                            class="badge bg-warning-subtle text-warning border border-warning-subtle">Pending</span>
                                    @else
                                        <span
                                            class="badge bg-danger-subtle text-danger border border-danger-subtle text-capitalize">{{ $lib->status }}</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-inline-flex gap-1">
                                        @if ($lib->status !== 'active')
                                            <form method="POST"
                                                action="{{ url('/rgsmadmin/libraries/' . $lib->id . '/approve') }}"
                                                onsubmit="return confirm('Approve & activate {{ $lib->library_name }}?');">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fa-solid fa-check me-1"></i> Approve
                                                </button>
                                            </form>
                                        @endif

                                        @if ($lib->status === 'active')
                                            <form method="POST"
                                                action="{{ url('/rgsmadmin/libraries/' . $lib->id . '/suspend') }}"
                                                onsubmit="return confirm('Suspend {{ $lib->library_name }}?');">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                                    <i class="fa-solid fa-ban me-1"></i> Suspend
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No libraries found for this filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($libraries->hasPages())
            <div class="card-footer bg-white py-2 px-4">
                {{ $libraries->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection
