@extends('layouts.library')

@section('title', 'Add New Student — LMSP')

@section('content')
        <div class="container py-2">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Students</h2>
                    <p class="text-muted mb-0">Manage library admissions and seat assignments.</p>
                </div>

                <a href="/library/students/add" class="btn btn-primary">
                    + Add Student
                </a>
            </div>
            <div class="card border-0 shadow-sm rounded-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Student Code</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Seat</th>
                                <th>Payable Fee</th>
                                <th>Admission Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($students as $student)
                                <tr>
                                    <td>{{ $student->student_code }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->mobile }}</td>
                                    <td>{{ $student->seat?->seat_number ?? 'Not assigned' }}</td>
                                    <td>₹{{ number_format((float) $student->payable_fee, 2) }}</td>
                                    <td>{{ $student->admission_date?->format('d M Y') }}</td>
                                    <td>
                                        <span class="badge bg-success">
                                            {{ ucfirst($student->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        No students found. Click Add Student to register one.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-body">
                    {{ $students->links() }}
                </div>
            </div>
        </div>
@endsection
