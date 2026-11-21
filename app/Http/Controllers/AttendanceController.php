<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $library = $request->user()->library;

        abort_unless($library, 403, 'Library account not found.');

        $date = $request->query('date', now()->toDateString());
        $search = trim((string) $request->query('search', ''));
        $filter = trim((string) $request->query('filter', 'all')); // all, present, inside, absent, unmarked

        $studentsQuery = Student::where('library_id', $library->id)
            ->where('status', 'active')
            ->with('seat')
            ->orderBy('name');

        if ($search !== '') {
            $studentsQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('student_code', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%");
            });
        }

        $activeStudents = $studentsQuery->get();

        $attendancesByStudent = StudentAttendance::where('library_id', $library->id)
            ->whereDate('attendance_date', $date)
            ->get()
            ->keyBy('student_id');

        $presentCount = 0;
        $insideNowCount = 0;
        $absentCount = 0;

        $rows = $activeStudents->map(function ($student) use ($attendancesByStudent, &$presentCount, &$insideNowCount, &$absentCount) {
            $att = $attendancesByStudent->get($student->id);

            if ($att && $att->status === 'present') {
                $presentCount++;
                if (empty($att->check_out_time)) {
                    $insideNowCount++;
                }
            } elseif ($att && $att->status === 'absent') {
                $absentCount++;
            }

            return (object) [
                'student' => $student,
                'attendance' => $att,
            ];
        });

        $unmarkedCount = max(0, $activeStudents->count() - ($presentCount + $absentCount));

        if ($filter === 'present') {
            $rows = $rows->filter(fn($r) => $r->attendance && $r->attendance->status === 'present')->values();
        } elseif ($filter === 'inside') {
            $rows = $rows->filter(fn($r) => $r->attendance && $r->attendance->status === 'present' && empty($r->attendance->check_out_time))->values();
        } elseif ($filter === 'absent') {
            $rows = $rows->filter(fn($r) => $r->attendance && $r->attendance->status === 'absent')->values();
        } elseif ($filter === 'unmarked') {
            $rows = $rows->filter(fn($r) => !$r->attendance)->values();
        }

        return view('library.attendance.attendance', compact(
            'rows',
            'date',
            'search',
            'filter',
            'presentCount',
            'insideNowCount',
            'absentCount',
            'unmarkedCount'
        ));
    }

    public function checkIn(Request $request, $studentId)
    {
        $library = $request->user()->library;

        abort_unless($library, 403, 'Library account not found.');

        $student = Student::where('library_id', $library->id)->findOrFail($studentId);
        $date = $request->input('attendance_date', now()->toDateString());

        $attendance = StudentAttendance::where('library_id', $library->id)
            ->where('student_id', $student->id)
            ->whereDate('attendance_date', $date)
            ->first();

        if ($attendance) {
            $attendance->update([
                'status' => 'present',
                'check_in_time' => $attendance->check_in_time ?: now()->format('H:i:s'),
                'check_out_time' => null,
            ]);
        } else {
            StudentAttendance::create([
                'library_id' => $library->id,
                'student_id' => $student->id,
                'attendance_date' => $date,
                'check_in_time' => now()->format('H:i:s'),
                'status' => 'present',
            ]);
        }

        return redirect()->back()->with('success', $student->name . ' checked in.');
    }

    public function checkOut(Request $request, $studentId)
    {
        $library = $request->user()->library;

        abort_unless($library, 403, 'Library account not found.');

        $student = Student::where('library_id', $library->id)->findOrFail($studentId);
        $date = $request->input('attendance_date', now()->toDateString());

        $attendance = StudentAttendance::where('library_id', $library->id)
            ->where('student_id', $student->id)
            ->whereDate('attendance_date', $date)
            ->first();

        if ($attendance) {
            $attendance->update([
                'status' => 'present',
                'check_in_time' => $attendance->check_in_time ?: now()->format('H:i:s'),
                'check_out_time' => now()->format('H:i:s'),
            ]);
        } else {
            StudentAttendance::create([
                'library_id' => $library->id,
                'student_id' => $student->id,
                'attendance_date' => $date,
                'check_in_time' => now()->format('H:i:s'),
                'check_out_time' => now()->format('H:i:s'),
                'status' => 'present',
            ]);
        }

        return redirect()->back()->with('success', $student->name . ' checked out.');
    }

    public function markAbsent(Request $request, $studentId)
    {
        $library = $request->user()->library;

        abort_unless($library, 403, 'Library account not found.');

        $student = Student::where('library_id', $library->id)->findOrFail($studentId);
        $date = $request->input('attendance_date', now()->toDateString());

        StudentAttendance::updateOrCreate(
            [
                'library_id' => $library->id,
                'student_id' => $student->id,
                'attendance_date' => $date,
            ],
            [
                'status' => 'absent',
                'check_in_time' => null,
                'check_out_time' => null,
            ]
        );

        return redirect()->back()->with('success', $student->name . ' marked absent.');
    }

    public function markAllPresent(Request $request)
    {
        $library = $request->user()->library;

        abort_unless($library, 403, 'Library account not found.');

        $date = $request->input('attendance_date', now()->toDateString());
        $nowTime = now()->format('H:i:s');

        $activeStudentIds = Student::where('library_id', $library->id)
            ->where('status', 'active')
            ->pluck('id');

        $alreadyMarkedIds = StudentAttendance::where('library_id', $library->id)
            ->whereDate('attendance_date', $date)
            ->pluck('student_id')
            ->toArray();

        $unmarkedIds = $activeStudentIds->diff($alreadyMarkedIds);

        foreach ($unmarkedIds as $sid) {
            StudentAttendance::create([
                'library_id' => $library->id,
                'student_id' => $sid,
                'attendance_date' => $date,
                'check_in_time' => $nowTime,
                'status' => 'present',
            ]);
        }

        return redirect()->back()->with('success', $unmarkedIds->count() . ' unmarked students checked in.');
    }
    public function kiosk(Request $request)
    {
        $library = $request->user()->library;

        abort_unless($library, 403, 'Library account not found.');

        // Session mein kiosk lock flag set karein
        $request->session()->put('kiosk_locked', true);

        return view('library.attendance.kiosk', compact('library'));
    }

    public function kioskSearch(Request $request)
    {
        $library = $request->user()->library;

        abort_unless($library, 403, 'Library account not found.');

        $digits = preg_replace('/\D/', '', (string) $request->query('q', ''));

        if (strlen($digits) < 4) {
            return response()->json(['students' => []]);
        }

        $today = now()->toDateString();

        // Starting 4 digits (or exact 4 digits) match karein
        $students = Student::where('library_id', $library->id)
            ->where('status', 'active')
            ->where('mobile', 'like', $digits . '%')
            ->with('seat')
            ->orderBy('name')
            ->limit(8)
            ->get();

        $attendances = StudentAttendance::where('library_id', $library->id)
            ->whereDate('attendance_date', $today)
            ->whereIn('student_id', $students->pluck('id'))
            ->get()
            ->keyBy('student_id');

        $results = $students->map(function ($st) use ($attendances) {
            $att = $attendances->get($st->id);

            $state = 'not_checked_in'; // check-in kar sakta hai
            if ($att && $att->status === 'present' && empty($att->check_out_time)) {
                $state = 'inside'; // check-out kar sakta hai
            } elseif ($att && $att->status === 'present' && !empty($att->check_out_time)) {
                $state = 'checked_out'; // dobara check-in kar sakta hai
            }

            // Mobile number ko partially mask karein privacy ke liye (e.g. 9876****10)
            $rawMobile = preg_replace('/\D/', '', (string) $st->mobile);
            $maskedMobile = strlen($rawMobile) >= 6
                ? substr($rawMobile, 0, 4) . '****' . substr($rawMobile, -2)
                : $st->mobile;

            return [
                'id' => $st->id,
                'name' => $st->name,
                'student_code' => $st->student_code,
                'masked_mobile' => $maskedMobile,
                'seat' => $st->seat ? $st->seat->seat_number : 'No Seat',
                'state' => $state,
                'check_in_time' => ($att && $att->check_in_time)
                    ? \Carbon\Carbon::parse($att->check_in_time)->format('h:i A')
                    : null,
                'check_out_time' => ($att && $att->check_out_time)
                    ? \Carbon\Carbon::parse($att->check_out_time)->format('h:i A')
                    : null,
            ];
        });

        return response()->json(['students' => $results]);
    }

    public function kioskPunch(Request $request, $studentId)
    {
        $library = $request->user()->library;

        abort_unless($library, 403, 'Library account not found.');

        $student = Student::where('library_id', $library->id)
            ->where('status', 'active')
            ->findOrFail($studentId);

        $today = now()->toDateString();
        $nowTime = now()->format('H:i:s');
        $formattedTime = now()->format('h:i A');

        $attendance = StudentAttendance::where('library_id', $library->id)
            ->where('student_id', $student->id)
            ->whereDate('attendance_date', $today)
            ->first();

        if ($attendance && $attendance->status === 'present' && empty($attendance->check_out_time)) {
            // Check-Out mark karein
            $attendance->update([
                'check_out_time' => $nowTime,
            ]);

            return response()->json([
                'ok' => true,
                'action' => 'check_out',
                'message' => "Goodbye {$student->name}! Checked Out at {$formattedTime}",
            ]);
        }

        // Check-In mark karein
        if ($attendance) {
            $attendance->update([
                'status' => 'present',
                'check_in_time' => $attendance->check_in_time ?: $nowTime,
                'check_out_time' => null,
            ]);
        } else {
            StudentAttendance::create([
                'library_id' => $library->id,
                'student_id' => $student->id,
                'attendance_date' => $today,
                'check_in_time' => $nowTime,
                'status' => 'present',
            ]);
        }

        return response()->json([
            'ok' => true,
            'action' => 'check_in',
            'message' => "Welcome {$student->name}! Checked In at {$formattedTime}",
        ]);
    }

    public function kioskUnlock(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'password' => ['required', 'string'],
        ]);

        if (!Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'ok' => false,
                'message' => 'Incorrect admin password!',
            ], 422);
        }

        $request->session()->forget('kiosk_locked');

        return response()->json([
            'ok' => true,
            'redirect' => '/library/attendance',
        ]);
    }
}
