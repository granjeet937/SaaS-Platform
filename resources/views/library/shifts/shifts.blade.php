@extends('layouts.library')

@section('title', 'Smart Shifts & Fee Setup — LMSP')

@section('content')
    <style>
        .preset-card {
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px;
            cursor: pointer;
            transition: all 0.15s ease;
            background: #fff;
            height: 100%;
        }

        .preset-card:hover:not(.preset-locked):not(.preset-active) {
            border-color: #0d6efd;
            background: #f8fafc;
            transform: translateY(-2px);
        }

        .preset-card.preset-active {
            border: 2px solid #198754 !important;
            background: #f0fdf4 !important;
            cursor: default;
        }

        .preset-card.preset-locked {
            opacity: 0.55;
            background: #f8fafc;
            cursor: not-allowed;
            pointer-events: none;
        }

        .timeline-track {
            height: 34px;
            background: #e2e8f0;
            border-radius: 8px;
            position: relative;
            overflow: hidden;
            border: 1px solid #cbd5e1;
        }

        .timeline-block {
            position: absolute;
            top: 0;
            bottom: 0;
            font-size: 0.72rem;
            font-weight: 600;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            white-space: nowrap;
            padding: 0 4px;
            border-right: 1px solid rgba(255, 255, 255, 0.4);
        }
    </style>

    @php
        $presetCards = [
            [
                'key' => '4x6',
                'title' => '4 × 6 Hours Slots',
                'modal_title' => '4 Shifts × 6 Hours (24h Coverage)',
                'desc' => '6AM-12PM, 12-6PM, 6-12AM, 12-6AM',
                'placeholder' => '500',
            ],
            [
                'key' => '3x8',
                'title' => '3 × 8 Hours Slots',
                'modal_title' => '3 Shifts × 8 Hours (24h Coverage)',
                'desc' => '6AM-2PM, 2PM-10PM, 10PM-6AM',
                'placeholder' => '700',
            ],
            [
                'key' => '2x12',
                'title' => '2 × 12 Hours Slots',
                'modal_title' => '2 Shifts × 12 Hours (Day & Night)',
                'desc' => 'Day (6AM-6PM) & Night (6PM-6AM)',
                'placeholder' => '1000',
            ],
            [
                'key' => '1x24',
                'title' => '24 Hours Reserved',
                'modal_title' => 'Full Day Reserved (24 Hours)',
                'desc' => 'Dedicated full-day seat slot',
                'placeholder' => '1500',
            ],
        ];
    @endphp

    <div class="container-fluid py-3" style="max-width: 1100px;">
        {{-- Header --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
            <div>
                <h4 class="mb-0 fw-bold">Shifts & Fee Structure</h4>
                <small class="text-muted">Select a shift template and edit individual slot fees or timings anytime</small>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show py-2 small" role="alert">
                <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show py-2 small" role="alert">
                <i class="fa-solid fa-circle-exclamation me-1"></i> {{ session('error') }}
                <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show py-2 small" role="alert">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- 1-Click Smart Preset Generator (Single Active Plan Enforcement) --}}
        <div class="card border-0 shadow-sm mb-3 {{ $shifts->isEmpty() ? 'border-start border-4 border-primary' : '' }}">
            <div class="card-body py-3">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-1">
                    <span class="fw-bold small text-uppercase text-primary">
                        <i class="fa-solid fa-wand-magic-sparkles me-1"></i> 1-Click Auto Shift Generator
                    </span>
                    @if ($activePreset)
                        <span class="badge bg-success-subtle text-success border border-success-subtle fw-semibold">
                            <i class="fa-solid fa-lock me-1"></i> Active Template Locked
                        </span>
                    @else
                        <span class="badge bg-light text-muted border fw-normal">Select one template</span>
                    @endif
                </div>

                <div class="row g-2">
                    @foreach ($presetCards as $card)
                        @php
                            $isThisActive = $activePreset === $card['key'];
                            $isLocked = $activePreset !== null && !$isThisActive;
                        @endphp
                        <div class="col-6 col-md-3">
                            <div class="preset-card {{ $isThisActive ? 'preset-active' : ($isLocked ? 'preset-locked' : 'open-preset-btn') }}"
                                @if (!$activePreset) data-preset="{{ $card['key'] }}"
                                 data-title="{{ $card['modal_title'] }}"
                                 data-placeholder="{{ $card['placeholder'] }}" @endif>
                                <div class="d-flex justify-content-between align-items-start gap-1">
                                    <div class="fw-bold small {{ $isThisActive ? 'text-success' : 'text-dark' }}">
                                        {{ $card['title'] }}
                                    </div>
                                    @if ($isThisActive)
                                        <span class="badge bg-success" style="font-size: 0.65rem;">
                                            <i class="fa-solid fa-check me-1"></i>Active
                                        </span>
                                    @elseif($isLocked)
                                        <span class="text-muted" style="font-size: 0.72rem;"
                                            title="Delete active template shifts to switch">
                                            <i class="fa-solid fa-lock"></i>
                                        </span>
                                    @endif
                                </div>
                                <div class="text-muted mt-1" style="font-size: 0.72rem;">{{ $card['desc'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Visual 24-Hour Timeline Bar (Handles Midnight-Crossing Slots Properly) --}}
        @php
            $timedShifts = $shifts->where('status', true)->filter(fn($s) => $s->start_time && $s->end_time);
            $colors = ['#0d6efd', '#198754', '#6f42c1', '#fd7e14', '#0dcaf0', '#d63384'];
        @endphp
        @if ($timedShifts->isNotEmpty())
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body py-3 px-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small fw-bold text-uppercase text-muted">
                            <i class="fa-regular fa-clock me-1 text-primary"></i> 24-Hour Slot Coverage
                        </span>
                        <span class="badge bg-light text-dark border fw-normal">
                            {{ $timedShifts->sum('duration_hours') }}h Total Scheduled
                        </span>
                    </div>

                    <div class="position-relative text-muted mb-1"
                        style="height: 16px; font-size: 0.7rem; font-weight: 600;">
                        <span class="position-absolute start-0">12 AM</span>
                        <span class="position-absolute translate-middle-x" style="left: 25%;">6 AM</span>
                        <span class="position-absolute translate-middle-x" style="left: 50%;">12 PM</span>
                        <span class="position-absolute translate-middle-x" style="left: 75%;">6 PM</span>
                        <span class="position-absolute end-0">12 AM</span>
                    </div>

                    <div class="timeline-track">
                        @foreach ($timedShifts->values() as $idx => $ts)
                            @php
                                $startMin =
                                    \Carbon\Carbon::parse($ts->start_time)->hour * 60 +
                                    \Carbon\Carbon::parse($ts->start_time)->minute;
                                $durationMin = $ts->duration_hours * 60;
                                $bgColor = $colors[$idx % count($colors)];
                                $timeLabel =
                                    \Carbon\Carbon::parse($ts->start_time)->format('h:i A') .
                                    ' - ' .
                                    \Carbon\Carbon::parse($ts->end_time)->format('h:i A');
                                $segments = [];

                                if ($startMin + $durationMin <= 1440) {
                                    $segments[] = [
                                        'left' => ($startMin / 1440) * 100,
                                        'width' => ($durationMin / 1440) * 100,
                                        'label' => $ts->shift_name,
                                    ];
                                } else {
                                    $firstPartMin = 1440 - $startMin;
                                    $secondPartMin = $durationMin - $firstPartMin;

                                    $segments[] = [
                                        'left' => ($startMin / 1440) * 100,
                                        'width' => ($firstPartMin / 1440) * 100,
                                        'label' => $firstPartMin >= 180 ? $ts->shift_name : $ts->duration_hours . 'h',
                                    ];
                                    $segments[] = [
                                        'left' => 0,
                                        'width' => ($secondPartMin / 1440) * 100,
                                        'label' => $ts->shift_name . ' (cont.)',
                                    ];
                                }
                            @endphp

                            @foreach ($segments as $seg)
                                <div class="timeline-block"
                                    style="left: {{ $seg['left'] }}%; width: {{ $seg['width'] }}%; background: {{ $bgColor }};"
                                    title="{{ $ts->shift_name }} ({{ $timeLabel }})">
                                    <span class="text-truncate px-1">{{ $seg['label'] }}</span>
                                </div>
                            @endforeach
                        @endforeach
                    </div>

                    <div class="d-flex flex-wrap gap-2 mt-2">
                        @foreach ($timedShifts->values() as $idx => $ts)
                            <span class="badge fw-normal text-white px-2 py-1"
                                style="background: {{ $colors[$idx % count($colors)] }}; font-size: 0.7rem;">
                                {{ $ts->shift_name }}: {{ \Carbon\Carbon::parse($ts->start_time)->format('h:i A') }} –
                                {{ \Carbon\Carbon::parse($ts->end_time)->format('h:i A') }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        {{-- Shifts Table --}}
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Shift Name & Code</th>
                                <th>Duration</th>
                                <th>Timing</th>
                                <th>Monthly Fee</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($shifts as $index => $shift)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $shift->shift_name }}</div>
                                        <small class="text-muted">{{ $shift->shift_code }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info text-dark">{{ $shift->duration_hours }} Hours</span>
                                    </td>
                                    <td>
                                        @if ($shift->start_time && $shift->end_time)
                                            <span class="fw-medium">
                                                {{ \Carbon\Carbon::parse($shift->start_time)->format('h:i A') }}
                                                &rarr;
                                                {{ \Carbon\Carbon::parse($shift->end_time)->format('h:i A') }}
                                            </span>
                                        @else
                                            <span class="text-muted">Flexible / Any {{ $shift->duration_hours }} Hrs</span>
                                        @endif
                                    </td>
                                    <td class="fw-bold text-success">₹{{ number_format($shift->monthly_fee, 2) }}</td>
                                    <td>
                                        <form action="{{ route('shifts.toggle-status', $shift->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="btn btn-sm py-0 px-2 {{ $shift->status ? 'btn-success' : 'btn-secondary' }}">
                                                {{ $shift->status ? 'Active' : 'Inactive' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-end">
                                        <button type="button"
                                            class="btn btn-sm btn-outline-primary py-0 px-2 edit-shift-btn"
                                            data-id="{{ $shift->id }}" data-name="{{ $shift->shift_name }}"
                                            data-duration="{{ $shift->duration_hours }}"
                                            data-start="{{ $shift->start_time ? \Carbon\Carbon::parse($shift->start_time)->format('H:i') : '' }}"
                                            data-end="{{ $shift->end_time ? \Carbon\Carbon::parse($shift->end_time)->format('H:i') : '' }}"
                                            data-fee="{{ $shift->monthly_fee }}" data-bs-toggle="modal"
                                            data-bs-target="#editShiftModal">
                                            Edit
                                        </button>

                                        <form action="{{ route('shifts.destroy', $shift->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Delete this shift?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-sm btn-outline-danger py-0 px-2">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        Click a template in the <strong>1-Click Auto Shift Generator</strong> above to
                                        generate your library shifts.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- 1-Click Bulk Preset Modal -->
    <div class="modal fade" id="bulkPresetModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <form action="{{ route('shifts.bulk') }}" method="POST" class="modal-content">
                @csrf
                <input type="hidden" name="preset_type" id="preset_type_input">
                <div class="modal-header py-2">
                    <h6 class="modal-title fw-bold" id="presetModalTitle">Generate Shifts</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label small fw-semibold">Monthly Fee per Shift (₹) <span
                            class="text-danger">*</span></label>
                    <input type="number" step="0.01" min="0" name="base_fee" id="preset_fee_input"
                        class="form-control" required>
                    <small class="text-muted d-block mt-1">All slots will be created in one click. You can edit any shift's
                        fee or timing later.</small>
                </div>
                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary fw-semibold">Generate All Slots</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Shift Modal -->
    <div class="modal fade" id="editShiftModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editShiftForm" method="POST" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Library Shift</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Shift Name <span class="text-danger">*</span></label>
                        <input type="text" name="shift_name" id="edit_shift_name"
                            class="form-control form-control-sm" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Duration (Hours) <span
                                    class="text-danger">*</span></label>
                            <select name="duration_hours" id="edit_duration_hours" class="form-select form-select-sm"
                                required>
                                <option value="4">4 Hours</option>
                                <option value="6">6 Hours</option>
                                <option value="8">8 Hours</option>
                                <option value="10">10 Hours</option>
                                <option value="12">12 Hours</option>
                                <option value="16">16 Hours</option>
                                <option value="24">24 Hours</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Monthly Fee (₹) <span
                                    class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="monthly_fee" id="edit_monthly_fee"
                                class="form-control form-control-sm" required>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Start Time</label>
                            <input type="time" name="start_time" id="edit_start_time"
                                class="form-control form-control-sm">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">End Time</label>
                            <input type="time" name="end_time" id="edit_end_time"
                                class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary fw-semibold">Update Shift</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bulkModalEl = document.getElementById('bulkPresetModal');
            if (bulkModalEl) {
                const bulkModal = new bootstrap.Modal(bulkModalEl);
                document.querySelectorAll('.open-preset-btn').forEach(card => {
                    card.addEventListener('click', function() {
                        document.getElementById('preset_type_input').value = this.dataset.preset;
                        document.getElementById('presetModalTitle').textContent = this.dataset
                        .title;
                        document.getElementById('preset_fee_input').value = this.dataset
                        .placeholder;
                        bulkModal.show();
                    });
                });
            }

            const editForm = document.getElementById('editShiftForm');
            document.querySelectorAll('.edit-shift-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    editForm.action = `/library/shifts/${id}`;
                    document.getElementById('edit_shift_name').value = this.dataset.name;
                    document.getElementById('edit_duration_hours').value = this.dataset.duration;
                    document.getElementById('edit_start_time').value = this.dataset.start;
                    document.getElementById('edit_end_time').value = this.dataset.end;
                    document.getElementById('edit_monthly_fee').value = this.dataset.fee;
                });
            });
        });
    </script>
@endsection
