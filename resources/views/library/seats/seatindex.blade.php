@extends('layouts.library')

@section('content')
    <style>
        .seat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 10px;
        }

        .seat-box {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 8px 5px;
            text-align: center;
            cursor: pointer;
            background: #fff;
            transition: all 0.12s ease;
            user-select: none;
            position: relative;
        }

        .seat-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        }

        .seat-box.status-available {
            border-color: #bbf7d0;
            background: #f0fdf4;
        }

        .seat-box.status-occupied {
            border-color: #fecaca;
            background: #fef2f2;
        }

        .seat-box.status-maintenance {
            border-color: #fde68a;
            background: #fffbeb;
        }

        .seat-box.selected {
            border-color: #0d6efd !important;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.25);
            background: #eff6ff !important;
        }

        .seat-check-badge {
            position: absolute;
            top: 5px;
            right: 6px;
            font-size: 0.75rem;
            color: #0d6efd;
            display: none;
        }

        .seat-box.selected .seat-check-badge {
            display: block;
        }

        .seat-number {
            font-weight: 700;
            font-size: 0.92rem;
            color: #1e293b;
        }

        .seat-section-tag {
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 4px;
            background: rgba(15, 23, 42, 0.07);
            color: #334155;
            display: inline-block;
            margin-top: 4px;
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .seat-student-name {
            font-size: 0.7rem;
            color: #dc2626;
            font-weight: 600;
            margin-top: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 4px;
        }
    </style>

    <div class="container-fluid py-3">
        {{-- Header --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
            <div>
                <h4 class="mb-1 fw-bold">Seats & Section Alignment</h4>
                <p class="text-muted mb-0 small">
                    <strong>{{ $library->library_name }}</strong> &bull; Total Capacity: <strong>{{ $stats['total'] }}
                        Seats</strong>
                </p>
            </div>

            {{-- Color Legend --}}
            <div class="d-flex flex-wrap gap-3 small bg-white px-3 py-2 rounded shadow-sm border">
                <span><span class="legend-dot bg-success"></span>Available ({{ $stats['available'] }})</span>
                <span><span class="legend-dot bg-danger"></span>Occupied ({{ $stats['occupied'] }})</span>
                <span><span class="legend-dot bg-warning"></span>Maintenance ({{ $stats['maintenance'] }})</span>
                <span><span class="legend-dot bg-primary"></span>Selected</span>
            </div>
        </div>

        {{-- Step 1 & Step 2 Action Panel --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <div class="row g-3">
                    {{-- Quick Range Selector --}}
                    <div class="col-lg-5 border-end-lg">
                        <label class="form-label small fw-bold text-uppercase text-muted mb-2">
                            1. Quick Select Seats (Range or Click)
                        </label>
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text">Seat #</span>
                            <input type="number" id="rangeFrom" class="form-control" min="1"
                                max="{{ $seats->count() }}" placeholder="From (e.g. 1)">
                            <span class="input-group-text">to</span>
                            <input type="number" id="rangeTo" class="form-control" min="1"
                                max="{{ $seats->count() }}" placeholder="To (e.g. 20)">
                            <button type="button" class="btn btn-outline-primary" id="selectRangeBtn">Select Range</button>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" class="btn btn-sm btn-light border" id="selectAllVisibleBtn">
                                <i class="fa-solid fa-check-double me-1"></i> Select Visible
                            </button>
                            <button type="button" class="btn btn-sm btn-light border text-danger" id="clearSelectionBtn">
                                <i class="fa-solid fa-xmark me-1"></i> Clear
                            </button>
                            <span class="small text-muted align-self-center ms-1">
                                Tip: <strong>Shift + Click</strong> se range select karein
                            </span>
                        </div>
                    </div>

                    {{-- Section & Status Alignment Form --}}
                    <div class="col-lg-7">
                        <form action="/library/seats/update-section" method="POST" id="alignSectionForm">
                            @csrf
                            <div id="selectedSeatInputs"></div>

                            <label class="form-label small fw-bold text-uppercase text-muted mb-2">
                                2. Assign Section & Status (<span class="text-primary" id="selectedCountDisplay">0
                                    selected</span>)
                            </label>

                            <div class="row g-2 align-items-center">
                                <div class="col-sm-5">
                                    <input type="text" name="section" id="sectionInput" list="sectionSuggestions"
                                        class="form-control form-control-sm" placeholder="Type section (e.g. Hall A)">
                                    <datalist id="sectionSuggestions">
                                        <option value="Hall A">
                                        <option value="Hall B">
                                        <option value="AC Cabin">
                                        <option value="Non-AC Hall">
                                        <option value="Girls Section">
                                        <option value="Ground Floor">
                                        <option value="First Floor">
                                            @foreach ($sections as $sec)
                                        <option value="{{ $sec }}">
                                            @endforeach
                                    </datalist>
                                </div>

                                <div class="col-sm-4">
                                    <select name="status" id="statusSelect" class="form-select form-select-sm">
                                        <option value="">Keep Status</option>
                                        <option value="available">Set Available</option>
                                        <option value="maintenance">Set Maintenance</option>
                                    </select>
                                </div>

                                <div class="col-sm-3 d-grid">
                                    <button type="submit" class="btn btn-primary btn-sm" id="applyAlignBtn" disabled>
                                        <i class="fa-solid fa-check me-1"></i> Apply
                                    </button>
                                </div>
                            </div>

                            {{-- Quick Preset Chips --}}
                            <div class="d-flex flex-wrap gap-1 mt-2 align-items-center">
                                <span class="small text-muted me-1">Quick fill:</span>
                                @foreach (['Hall A', 'Hall B', 'AC Cabin', 'Non-AC Hall', 'Girls Section'] as $preset)
                                    <button type="button" class="btn btn-outline-secondary py-0 px-2 quick-section-chip"
                                        style="font-size: 0.72rem;" data-section="{{ $preset }}">
                                        {{ $preset }}
                                    </button>
                                @endforeach
                                <button type="button" class="btn btn-outline-danger py-0 px-2 quick-section-chip"
                                    style="font-size: 0.72rem;" data-section="">
                                    Clear Section
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter & Search Toolbar --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <div class="d-flex flex-wrap gap-1 align-items-center">
                <button type="button" class="btn btn-sm btn-dark section-filter-btn active" data-section="all">
                    All ({{ $seats->count() }})
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary section-filter-btn"
                    data-section="unassigned">
                    Unassigned ({{ $seats->whereNull('section')->count() }})
                </button>
                @foreach ($sections as $sec)
                    <button type="button" class="btn btn-sm btn-outline-primary section-filter-btn"
                        data-section="{{ $sec }}">
                        {{ $sec }} ({{ $seats->where('section', $sec)->count() }})
                    </button>
                @endforeach
            </div>

            <div class="d-flex gap-2">
                <select id="statusFilter" class="form-select form-select-sm" style="width: 145px;">
                    <option value="all">All Status</option>
                    <option value="available">Available</option>
                    <option value="occupied">Occupied</option>
                    <option value="maintenance">Maintenance</option>
                </select>
                <input type="text" id="seatSearchInput" class="form-control form-control-sm" style="width: 180px;"
                    placeholder="Search seat or student...">
            </div>
        </div>

        {{-- Visual Seat Grid --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                @if ($seats->isEmpty())
                    <div class="text-center py-5 text-muted">
                        Library ki <strong>total_seats</strong> 0 set hai. Pehle library profile mein total seats set
                        karein.
                    </div>
                @else
                    <div class="seat-grid" id="seatGrid">
                        @foreach ($seats as $index => $seat)
                            <div class="seat-box status-{{ $seat->status }}" data-id="{{ $seat->id }}"
                                data-index="{{ $index + 1 }}" data-section="{{ $seat->section ?? 'unassigned' }}"
                                data-status="{{ $seat->status }}"
                                data-search="{{ strtolower($seat->seat_number . ' ' . ($seat->section ?? '') . ' ' . ($seat->student->name ?? '')) }}"
                                title="Seat #{{ $index + 1 }} ({{ $seat->seat_number }})">

                                <i class="fa-solid fa-circle-check seat-check-badge"></i>

                                <div class="seat-number">
                                    {{ $seat->seat_number }}
                                </div>

                                <div class="seat-section-tag">
                                    {{ $seat->section ?: 'No Section' }}
                                </div>

                                @if ($seat->status === 'occupied' && $seat->student)
                                    <div class="seat-student-name" title="{{ $seat->student->name }}">
                                        {{ $seat->student->name }}
                                    </div>
                                @else
                                    <div class="text-muted text-capitalize" style="font-size: 0.6rem;">
                                        {{ $seat->status }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectedIds = new Set();
            const seatBoxes = Array.from(document.querySelectorAll('.seat-box'));
            const selectedInputsDiv = document.getElementById('selectedSeatInputs');
            const selectedCountDisplay = document.getElementById('selectedCountDisplay');
            const applyAlignBtn = document.getElementById('applyAlignBtn');
            const sectionInput = document.getElementById('sectionInput');
            const statusFilter = document.getElementById('statusFilter');
            const seatSearchInput = document.getElementById('seatSearchInput');

            let activeSectionFilter = 'all';
            let lastClickedIndex = null;

            function syncSelectionUI() {
                selectedInputsDiv.innerHTML = '';
                selectedIds.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'seat_ids[]';
                    input.value = id;
                    selectedInputsDiv.appendChild(input);
                });

                const count = selectedIds.size;
                selectedCountDisplay.textContent = count === 1 ? '1 seat selected' : `${count} seats selected`;
                applyAlignBtn.disabled = count === 0;
            }

            function applyFilters() {
                const statusVal = statusFilter.value;
                const query = seatSearchInput.value.trim().toLowerCase();

                seatBoxes.forEach(box => {
                    const matchSection = activeSectionFilter === 'all' || box.dataset.section ===
                        activeSectionFilter;
                    const matchStatus = statusVal === 'all' || box.dataset.status === statusVal;
                    const matchSearch = !query || box.dataset.search.includes(query);

                    box.style.display = (matchSection && matchStatus && matchSearch) ? '' : 'none';
                });
            }

            // Single click & Shift+Click range selection
            seatBoxes.forEach((box, idx) => {
                box.addEventListener('click', function(e) {
                    const id = this.dataset.id;

                    if (e.shiftKey && lastClickedIndex !== null) {
                        const start = Math.min(lastClickedIndex, idx);
                        const end = Math.max(lastClickedIndex, idx);
                        for (let i = start; i <= end; i++) {
                            if (seatBoxes[i].style.display !== 'none') {
                                selectedIds.add(seatBoxes[i].dataset.id);
                                seatBoxes[i].classList.add('selected');
                            }
                        }
                    } else {
                        if (selectedIds.has(id)) {
                            selectedIds.delete(id);
                            this.classList.remove('selected');
                        } else {
                            selectedIds.add(id);
                            this.classList.add('selected');
                        }
                    }

                    lastClickedIndex = idx;
                    syncSelectionUI();
                });
            });

            // Range selection by number (From - To)
            document.getElementById('selectRangeBtn').addEventListener('click', function() {
                const from = parseInt(document.getElementById('rangeFrom').value, 10);
                const to = parseInt(document.getElementById('rangeTo').value, 10);

                if (isNaN(from) || isNaN(to) || from < 1 || to < from) {
                    alert('Please enter a valid seat range (e.g. From 1 to 20).');
                    return;
                }

                seatBoxes.forEach(box => {
                    const seatIdx = parseInt(box.dataset.index, 10);
                    if (seatIdx >= from && seatIdx <= to) {
                        selectedIds.add(box.dataset.id);
                        box.classList.add('selected');
                    }
                });
                syncSelectionUI();
            });

            // Select all visible
            document.getElementById('selectAllVisibleBtn').addEventListener('click', function() {
                seatBoxes.forEach(box => {
                    if (box.style.display !== 'none') {
                        selectedIds.add(box.dataset.id);
                        box.classList.add('selected');
                    }
                });
                syncSelectionUI();
            });

            // Clear selection
            document.getElementById('clearSelectionBtn').addEventListener('click', function() {
                selectedIds.clear();
                lastClickedIndex = null;
                seatBoxes.forEach(box => box.classList.remove('selected'));
                syncSelectionUI();
            });

            // Quick section preset chips
            document.querySelectorAll('.quick-section-chip').forEach(chip => {
                chip.addEventListener('click', function() {
                    sectionInput.value = this.dataset.section;
                    sectionInput.focus();
                });
            });

            // Section filter buttons
            const sectionFilterBtns = document.querySelectorAll('.section-filter-btn');
            sectionFilterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    sectionFilterBtns.forEach(b => b.classList.remove('active', 'btn-dark'));
                    this.classList.add('active', 'btn-dark');
                    activeSectionFilter = this.dataset.section;
                    applyFilters();
                });
            });

            statusFilter.addEventListener('change', applyFilters);
            seatSearchInput.addEventListener('input', applyFilters);
        });
    </script>
@endsection
