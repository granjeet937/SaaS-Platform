<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Self Attendance Kiosk — {{ $library->library_name ?? 'LMSP' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        :root {
            --primary-grad: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%);
            --bg-grad: radial-gradient(circle at top right, #1e293b 0%, #0f172a 55%, #090d16 100%);
        }

        body {
            background: var(--bg-grad);
            min-height: 100vh;
            color: #fff;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            user-select: none;
            overflow-x: hidden;
        }

        .top-glass-bar {
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            max-width: 680px;
        }

        .live-dot {
            width: 8px;
            height: 8px;
            background: #22c55e;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
            animation: pulseGreen 1.8s infinite;
        }

        @keyframes pulseGreen {
            0% {
                box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
            }

            70% {
                box-shadow: 0 0 0 8px rgba(34, 197, 94, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(34, 197, 94, 0);
            }
        }

        .kiosk-card {
            background: #ffffff;
            color: #0f172a;
            border-radius: 26px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.45), 0 0 0 1px rgba(255, 255, 255, 0.08);
            max-width: 470px;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .kiosk-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--primary-grad);
        }

        .kiosk-badge {
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid #bfdbfe;
            font-size: 0.72rem;
            letter-spacing: 0.08em;
            font-weight: 700;
        }

        .digit-display {
            font-size: 2.1rem;
            letter-spacing: 0.45rem;
            font-weight: 800;
            text-align: center;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            height: 64px;
            color: #0f172a;
            transition: all 0.2s ease;
        }

        .digit-display:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.16);
            background: #ffffff;
        }

        .digit-display::placeholder {
            color: #cbd5e1;
            letter-spacing: 0.5rem;
        }

        .keypad-btn {
            height: 56px;
            font-size: 1.4rem;
            font-weight: 700;
            border-radius: 14px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #1e293b;
            box-shadow: 0 2px 0 #cbd5e1;
            transition: all 0.1s ease;
        }

        .keypad-btn:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
        }

        .keypad-btn:active {
            transform: translateY(2px);
            box-shadow: 0 0 0 #cbd5e1;
            background: #e2e8f0;
        }

        .keypad-btn-clear {
            background: #fef2f2;
            border-color: #fecaca;
            color: #dc2626;
            box-shadow: 0 2px 0 #fca5a5;
            font-size: 0.85rem;
            letter-spacing: 0.05em;
        }

        .keypad-btn-clear:hover {
            background: #fee2e2;
            color: #b91c1c;
        }

        .keypad-btn-back {
            background: #f1f5f9;
            border-color: #cbd5e1;
            color: #475569;
            box-shadow: 0 2px 0 #94a3b8;
        }

        .student-match-btn {
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            transition: all 0.18s ease;
            text-align: left;
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.04);
        }

        .student-match-btn:hover,
        .student-match-btn:active {
            border-color: #2563eb;
            background: #f8faff;
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.12);
        }

        .student-avatar {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: var(--primary-grad);
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .action-pill-in {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #86efac;
            font-weight: 700;
            font-size: 0.78rem;
            padding: 6px 12px;
            border-radius: 999px;
        }

        .action-pill-out {
            background: #dbeafe;
            color: #1d4ed8;
            border: 1px solid #93c5fd;
            font-weight: 700;
            font-size: 0.78rem;
            padding: 6px 12px;
            border-radius: 999px;
        }
    </style>
</head>

<body class="d-flex flex-column justify-content-between p-3">

    {{-- Top Glass Bar (No Sidebar / No Admin Links) --}}
    <div class="top-glass-bar d-flex justify-content-between align-items-center container py-2 px-3">
        <div class="d-flex align-items-center gap-2">
            <span class="live-dot"></span>
            <div>
                <div class="fw-bold fs-6 lh-sm">{{ $library->library_name ?? 'Study Library' }}</div>
                <div class="text-white-50" style="font-size: 0.78rem;" id="liveClock">
                    {{ now()->format('d M Y • h:i:s A') }}
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-outline-light btn-sm rounded-pill px-3 fw-semibold" data-bs-toggle="modal"
            data-bs-target="#unlockModal">
            <i class="fa-solid fa-lock me-1"></i> Admin Exit
        </button>
    </div>

    {{-- Center Self-Check-In Card --}}
    <div class="d-flex justify-content-center align-items-center my-auto py-3">
        <div class="kiosk-card p-4">
            <div class="text-center mb-3">
                <span class="badge kiosk-badge rounded-pill px-3 py-1 mb-2">
                    <i class="fa-solid fa-fingerprint me-1"></i> SELF ATTENDANCE KIOSK
                </span>
                <h4 class="fw-bold mb-1">Mark Your Attendance</h4>
                <p class="text-muted small mb-0">Enter the first 4 digits of your registered mobile number</p>
            </div>

            {{-- Success / Feedback Banner --}}
            <div id="punchAlert" class="alert d-none text-center fw-bold py-3 rounded-4 mb-3 shadow-sm" role="alert">
            </div>

            {{-- 4-Digit Input Display --}}
            <div class="mb-3 position-relative">
                <input type="tel" id="mobileDigitsInput" class="form-control digit-display" maxlength="10"
                    inputmode="numeric" placeholder="••••" autocomplete="off" autofocus>
            </div>

            {{-- Matching Students Results --}}
            <div id="resultsContainer" class="mb-3"></div>

            {{-- Tactile Touch Keypad --}}
            <div class="row g-2" id="touchKeypad">
                @foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9] as $num)
                    <div class="col-4">
                        <button type="button" class="btn w-100 keypad-btn" data-key="{{ $num }}">
                            {{ $num }}
                        </button>
                    </div>
                @endforeach
                <div class="col-4">
                    <button type="button" class="btn w-100 keypad-btn keypad-btn-clear" id="btnClear">
                        CLEAR
                    </button>
                </div>
                <div class="col-4">
                    <button type="button" class="btn w-100 keypad-btn" data-key="0">
                        0
                    </button>
                </div>
                <div class="col-4">
                    <button type="button" class="btn w-100 keypad-btn keypad-btn-back" id="btnBackspace"
                        aria-label="Backspace">
                        <i class="fa-solid fa-delete-left"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center text-white-50 small">
        <i class="fa-solid fa-shield-halved me-1"></i> Protected Kiosk Mode • LMSP
    </div>

    {{-- Admin Unlock Modal (Required to Exit or Go Back) --}}
    <div class="modal fade" id="unlockModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content text-dark border-0 shadow-lg rounded-4">
                <form id="unlockForm">
                    <div class="modal-header border-0 pb-1">
                        <h6 class="modal-title fw-bold">
                            <i class="fa-solid fa-shield-halved text-danger me-1"></i> Admin Verification
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-1">
                        <p class="small text-muted mb-2">Enter your admin password to unlock and return to the
                            dashboard:</p>
                        <input type="password" id="adminPasswordInput" class="form-control rounded-3"
                            placeholder="Enter admin password" required>
                        <div id="unlockError" class="text-danger small mt-1 d-none"></div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="submit" class="btn btn-danger w-100 fw-semibold rounded-3">
                            <i class="fa-solid fa-unlock me-1"></i> Unlock & Exit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const inputEl = document.getElementById('mobileDigitsInput');
            const resultsEl = document.getElementById('resultsContainer');
            const punchAlert = document.getElementById('punchAlert');
            const unlockModalEl = document.getElementById('unlockModal');
            const unlockModal = new bootstrap.Modal(unlockModalEl);

            // 1. Live IST Clock
            setInterval(() => {
                const now = new Date();
                document.getElementById('liveClock').textContent = now.toLocaleString('en-IN', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: true
                });
            }, 1000);

            // 2. Prevent Browser Back Button without Admin Password
            history.pushState(null, '', location.href);
            window.addEventListener('popstate', function() {
                history.pushState(null, '', location.href);
                unlockModal.show();
            });

            // 3. Search Students on 4+ Digits
            let searchTimer = null;

            function triggerSearch() {
                const digits = inputEl.value.replace(/\D/g, '');
                inputEl.value = digits;

                if (digits.length < 4) {
                    resultsEl.innerHTML = '';
                    return;
                }

                clearTimeout(searchTimer);
                searchTimer = setTimeout(() => {
                    resultsEl.innerHTML =
                        '<div class="text-center text-muted small py-2"><i class="fa-solid fa-spinner fa-spin me-1"></i> Searching student profile...</div>';

                    fetch(`/library/attendance/kiosk/search?q=${encodeURIComponent(digits)}`)
                        .then(res => res.json())
                        .then(data => renderStudents(data.students || []))
                        .catch(() => {
                            resultsEl.innerHTML =
                                '<div class="text-center text-danger small py-2">Network error. Please try again.</div>';
                        });
                }, 160);
            }

            function getInitials(name) {
                return (name || 'ST')
                    .trim()
                    .split(/\s+/)
                    .slice(0, 2)
                    .map(part => part[0].toUpperCase())
                    .join('');
            }

            function renderStudents(students) {
                if (!students.length) {
                    resultsEl.innerHTML =
                        '<div class="alert alert-warning py-2 px-3 small text-center rounded-3 mb-0"><i class="fa-solid fa-circle-exclamation me-1"></i> No active student found matching these digits.</div>';
                    return;
                }

                resultsEl.innerHTML = students.map(st => {
                    const isInside = st.state === 'inside';
                    const initials = getInitials(st.name);

                    const avatarHtml = st.photo_url ?
                        `<img src="${st.photo_url}" alt="${st.name}" class="rounded-3 object-fit-cover border flex-shrink-0" style="width:46px;height:46px;">` :
                        `<div class="student-avatar">${initials}</div>`;

                    const badgeHtml = isInside ?
                        `<span class="action-pill-out"><i class="fa-solid fa-right-from-bracket me-1"></i>Check Out</span>` :
                        `<span class="action-pill-in"><i class="fa-solid fa-right-to-bracket me-1"></i>Check In</span>`;

                    const shiftLine = st.shift_timing ?
                        `${st.shift_name} (${st.shift_timing})` :
                        st.shift_name;

                    const timeNote = isInside && st.check_in_time ?
                        `<div class="text-primary fw-semibold" style="font-size:0.74rem;"><i class="fa-regular fa-clock me-1"></i>Checked in at ${st.check_in_time}</div>` :
                        (st.check_out_time ?
                            `<div class="text-muted" style="font-size:0.74rem;">Last check-out: ${st.check_out_time}</div>` :
                            '');

                    return `
                        <button type="button" class="btn student-match-btn w-100 p-3 mb-2 d-flex justify-content-between align-items-center gap-2"
                                onclick="punchStudent(${st.id})">
                            <div class="d-flex align-items-center gap-3 min-w-0">
                                ${avatarHtml}
                                <div class="min-w-0">
                                    <div class="fw-bold fs-6 text-dark lh-sm text-truncate">${st.name}</div>
                                    <div class="text-muted small">${st.masked_mobile} &bull; Seat: <strong class="text-dark">${st.seat}</strong></div>
                                    <div class="text-info-emphasis fw-semibold" style="font-size:0.74rem;"><i class="fa-solid fa-clock me-1"></i>${shiftLine}</div>
                                    ${timeNote}
                                </div>
                            </div>
                            <div class="text-end flex-shrink-0">
                                ${badgeHtml}
                            </div>
                        </button>
                    `;
                }).join('');
            }

            window.punchStudent = function(studentId) {
                resultsEl.innerHTML =
                    '<div class="text-center text-primary fw-semibold py-3"><i class="fa-solid fa-spinner fa-spin me-1"></i> Recording attendance...</div>';

                fetch(`/library/attendance/kiosk/punch/${studentId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.ok) {
                            const noteHtml = data.off_shift_note ?
                                `<div class="small fw-normal mt-1 text-warning-emphasis">${data.off_shift_note}</div>` :
                                '';

                            punchAlert.className =
                                `alert ${data.action === 'check_in' ? 'alert-success' : 'alert-primary'} text-center fw-bold py-3 rounded-4 mb-3 shadow-sm`;
                            punchAlert.innerHTML =
                                `<i class="fa-solid fa-circle-check me-1"></i> ${data.message}${noteHtml}`;
                            punchAlert.classList.remove('d-none');

                            setTimeout(() => {
                                inputEl.value = '';
                                resultsEl.innerHTML = '';
                                punchAlert.classList.add('d-none');
                                inputEl.focus();
                            }, 3200);
                        }
                    });
            };

            inputEl.addEventListener('input', triggerSearch);

            // Touch Keypad Events
            document.querySelectorAll('[data-key]').forEach(btn => {
                btn.addEventListener('click', () => {
                    if (inputEl.value.length < 10) {
                        inputEl.value += btn.dataset.key;
                        triggerSearch();
                    }
                });
            });

            document.getElementById('btnClear').addEventListener('click', () => {
                inputEl.value = '';
                resultsEl.innerHTML = '';
                inputEl.focus();
            });

            document.getElementById('btnBackspace').addEventListener('click', () => {
                inputEl.value = inputEl.value.slice(0, -1);
                triggerSearch();
            });

            // Admin Unlock Form
            document.getElementById('unlockForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const password = document.getElementById('adminPasswordInput').value;
                const errEl = document.getElementById('unlockError');
                errEl.classList.add('d-none');

                fetch('/library/attendance/kiosk/unlock', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            password
                        })
                    })
                    .then(async res => {
                        const data = await res.json();
                        if (res.ok && data.ok) {
                            window.location.href = data.redirect;
                        } else {
                            errEl.textContent = data.message || 'Invalid password';
                            errEl.classList.remove('d-none');
                        }
                    });
            });

            unlockModalEl.addEventListener('shown.bs.modal', () => {
                document.getElementById('adminPasswordInput').focus();
            });
        });
    </script>
</body>

</html>
