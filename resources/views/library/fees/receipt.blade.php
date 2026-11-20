<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee Receipt #REC-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .receipt-box {
            max-width: 720px;
            margin: 30px auto;
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 32px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
        }

        .receipt-header {
            border-bottom: 2px dashed #dee2e6;
            padding-bottom: 18px;
            margin-bottom: 22px;
        }

        .receipt-footer {
            border-top: 2px dashed #dee2e6;
            padding-top: 18px;
            margin-top: 24px;
        }

        @media print {
            body {
                background: #fff;
            }

            .no-print {
                display: none !important;
            }

            .receipt-box {
                box-shadow: none;
                border: 1px solid #000;
                margin: 0;
                max-width: 100%;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        {{-- Action Bar (Hidden in Print) --}}
        <div class="d-flex justify-content-between align-items-center mx-auto mt-3 no-print" style="max-width: 720px;">
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> Back
            </a>
            <button onclick="window.print()" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-print me-1"></i> Print / Save PDF
            </button>
        </div>

        {{-- Printable Receipt --}}
        <div class="receipt-box">
            <div class="receipt-header d-flex justify-content-between align-items-start">
                <div>
                    <h4 class="fw-bold mb-1 text-primary">{{ $library->library_name ?? 'Study Library' }}</h4>
                    @if (!empty($library->address))
                        <div class="text-muted small">{{ $library->address }}</div>
                    @endif
                    @if (!empty($library->phone))
                        <div class="text-muted small">Phone: {{ $library->phone }}</div>
                    @endif
                </div>
                <div class="text-end">
                    <span
                        class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 text-uppercase">
                        Payment Receipt
                    </span>
                    <div class="fw-bold mt-2">Receipt #: REC-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</div>
                    <div class="text-muted small">
                        Date:
                        {{ $payment->payment_date ? $payment->payment_date->format('d M Y') : now()->format('d M Y') }}
                    </div>
                </div>
            </div>

            {{-- Student Details --}}
            <div class="row g-3 mb-4">
                <div class="col-6">
                    <div class="text-muted small">Received From</div>
                    <div class="fw-bold fs-6">{{ $student->name ?? 'N/A' }}</div>
                    <div class="small text-muted">Code: <strong>{{ $student->student_code ?? '—' }}</strong></div>
                    <div class="small text-muted">Mobile: {{ $student->mobile ?? '—' }}</div>
                </div>
                <div class="col-6 text-end">
                    <div class="text-muted small">Seat & Admission</div>
                    <div class="fw-semibold">
                        Seat: {{ $student && $student->seat ? $student->seat->seat_number : 'Not Assigned' }}
                        @if ($student && $student->seat && $student->seat->section)
                            ({{ $student->seat->section }})
                        @endif
                    </div>
                    <div class="small text-muted">
                        Admission:
                        {{ $student && $student->admission_date ? $student->admission_date->format('d M Y') : '—' }}
                    </div>
                    <div class="small text-muted text-uppercase">
                        Mode: <strong>{{ str_replace('_', ' ', $payment->payment_method) }}</strong>
                    </div>
                </div>
            </div>

            {{-- Payment Breakdown Table --}}
            <table class="table table-bordered align-middle mb-3">
                <thead class="table-light">
                    <tr>
                        <th>Description</th>
                        <th class="text-end" style="width: 170px;">Amount (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="fw-semibold">Library Fee Payment</div>
                            @if ($payment->reference_number)
                                <div class="small text-muted">Ref / UTR: {{ $payment->reference_number }}</div>
                            @endif
                            @if ($payment->notes)
                                <div class="small text-muted">Notes: {{ $payment->notes }}</div>
                            @endif
                        </td>
                        <td class="text-end fw-bold fs-6 text-success">
                            ₹{{ number_format((float) $payment->amount, 2) }}
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-end text-muted fw-normal">Total Due Till Date (30d Cycles)</th>
                        <td class="text-end">₹{{ number_format($totalDue, 2) }}</td>
                    </tr>
                    <tr>
                        <th class="text-end text-muted fw-normal">Total Paid Till Date</th>
                        <td class="text-end text-success fw-semibold">₹{{ number_format($totalPaid, 2) }}</td>
                    </tr>
                    <tr class="table-light">
                        <th class="text-end">Remaining Balance</th>
                        <td class="text-end fw-bold {{ $remainingBalance > 0 ? 'text-danger' : 'text-success' }}">
                            ₹{{ number_format($remainingBalance, 2) }}
                        </td>
                    </tr>
                </tfoot>
            </table>

            <div class="receipt-footer d-flex justify-content-between align-items-end">
                <div class="small text-muted">
                    <div>Status: <strong class="text-success text-uppercase">{{ $payment->payment_status }}</strong>
                    </div>
                    <div>This is a computer-generated receipt.</div>
                </div>
                <div class="text-end">
                    <div style="height: 32px;"></div>
                    <div class="small fw-semibold border-top pt-1 px-3">Authorized Signatory</div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
