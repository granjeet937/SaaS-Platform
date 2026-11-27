<?php

namespace App\Http\Controllers;

use App\Models\Library;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Seat;
use App\Models\Student;
use App\Models\StudentPayment;
use Carbon\Carbon;
use App\Models\StudentAttendance;
use App\Mail\LibraryNotificationMail;
use Illuminate\Support\Facades\Mail;

class LibraryController extends Controller
{
    public function create()
    {
        return view('library.registration');
    }

    public function datastore(Request $request)
    {
        Log::info('Library registration process started.', [
            'library_name' => $request->input('library_name'),
            'owner_email'  => $request->input('owner_email')
        ]);

        $validated = $request->validate([
            'library_type' => ['required', 'string', 'max:100'],
            'library_name' => ['required', 'string', 'max:150'],
            'logo'         => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'owner_name'   => ['required', 'string', 'max:100'],
            'owner_mobile' => ['required', 'digits:10', 'unique:users,phone'],
            'owner_email'  => ['required', 'email', 'max:150', 'unique:users,email'],
            'password'     => ['required', 'string', 'min:8', 'confirmed'],
            'address'      => ['required', 'string', 'max:500'],
            'city'         => ['required', 'string', 'max:100'],
            'state'        => ['required', 'string', 'max:100'],
            'pincode'      => ['required', 'digits:6'],
            'total_seats'  => ['required', 'integer', 'min:5', 'max:100000'],
            'facilities'   => ['nullable', 'array'],
            'facilities.*' => ['string', 'max:50'],
            'terms'        => ['accepted'],
        ]);

        try {
            [$library, $user, $freePlan] = DB::transaction(function () use ($request, $validated) {
                $logoPath = null;
                if ($request->hasFile('logo')) {
                    $logoPath = $request->file('logo')->store('libraries/logos', 'public');
                    Log::info('Library logo uploaded successfully.', ['path' => $logoPath]);
                }

                $cleanName = preg_replace('/[^a-zA-Z\s]/', '', trim($validated['library_name']));
                $words = array_values(array_filter(explode(' ', $cleanName)));

                if (count($words) >= 3) {
                    $prefix = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1) . substr($words[2], 0, 1));
                } else {
                    $joined = str_replace(' ', '', $cleanName);
                    $prefix = strtoupper(str_pad(substr($joined, 0, 3), 3, 'X'));
                }

                $sequence = Library::count() + 1;

                do {
                    $libraryCode = 'LIB-' . $prefix . str_pad($sequence, 3, '0', STR_PAD_LEFT);
                    $sequence++;
                } while (Library::where('library_code', $libraryCode)->exists());

                $library = Library::create([
                    'library_code'    => $libraryCode,
                    'library_type'    => $validated['library_type'],
                    'library_name'    => $validated['library_name'],
                    'admission_token' => strtoupper(Str::random(16)),
                    'logo'            => $logoPath,
                    'address'         => $validated['address'],
                    'city'            => $validated['city'],
                    'state'           => $validated['state'],
                    'pincode'         => $validated['pincode'],
                    'total_seats'     => $validated['total_seats'],
                    'facilities'      => $validated['facilities'] ?? [],
                    'status'          => 'pending',
                ]);

                $user = User::create([
                    'library_id' => $library->id,
                    'name'       => $validated['owner_name'],
                    'email'      => $validated['owner_email'],
                    'phone'      => $validated['owner_mobile'],
                    'password'   => Hash::make($validated['password']),
                    'role'       => 'library_admin',
                ]);

                Log::info('Library and Admin User created successfully.', [
                    'library_id'   => $library->id,
                    'library_code' => $library->library_code,
                    'user_id'      => $user->id
                ]);

                $freePlan = Plan::where('slug', 'free-trial')
                    ->where('status', 1)
                    ->firstOrFail();

                Subscription::create([
                    'library_id'     => $library->id,
                    'plan_id'        => $freePlan->id,
                    'start_date'     => Carbon::today(),
                    'end_date'       => Carbon::today()->addDays($freePlan->duration_days),
                    'status'         => 'active',
                    'payment_status' => 'not_required',
                ]);

                return [$library, $user, $freePlan];
            });

            try {
                Mail::to($user->email)->send(new LibraryNotificationMail([
                    'subject'        => "Library Registration Received — {$library->library_name} ({$library->library_code})",
                    'library_name'   => 'LMSP — Library Management SaaS Platform',
                    'recipient_name' => $user->name,
                    'badge_text'     => 'PENDING APPROVAL',
                    'badge_color'    => '#d97706',
                    'intro_message'  => "Thank you for registering {$library->library_name} on LMSP. Your library account is currently pending verification by the LMSP team.",
                    'details'        => [
                        'Library Code'   => $library->library_code,
                        'Library Name'   => $library->library_name,
                        'Owner Email'    => $user->email,
                        'Owner Mobile'   => $user->phone,
                        'City / State'   => "{$library->city}, {$library->state}",
                        'Total Seats'    => (string) $library->total_seats,
                        'Trial Plan'     => "{$freePlan->name} ({$freePlan->duration_days} Days)",
                        'Account Status' => 'Pending SaaS Admin Approval',
                    ],
                    'footer_note'    => 'You will receive an activation email as soon as your library is approved.',
                ]));
            } catch (\Throwable $mailEx) {
                Log::warning('Library registration mail failed: ' . $mailEx->getMessage());
            }

            return redirect('/library-login')->with([
                'success'      => 'Library registered successfully. Please login to continue.',
                'library_code' => $library->library_code,
                'library_name' => $library->library_name,
            ]);
        } catch (\Exception $e) {
            Log::error('Library Registration Failed: ' . $e->getMessage(), [
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput($request->except(['password', 'password_confirmation']))
                ->with('error', 'Registration failed. Please try again.');
        }
    }
    public function loginLMSP(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:191'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $throttleKey = Str::transliterate(
            Str::lower($validated['email']) . '|' . $request->ip()
        );

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()
                ->withInput($request->only('email'))
                ->with('error', "Too many login attempts. Please try again in {$seconds} seconds.");
        }

        $remember = $request->boolean('remember');

        if (!Auth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password'],
        ], $remember)) {
            RateLimiter::hit($throttleKey, 60);

            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Invalid email or password.');
        }

        RateLimiter::clear($throttleKey);
        $request->session()->regenerate();
        $user = Auth::user();

        if ($user->role !== 'library_admin') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/library-login')
                ->with('error', 'You are not authorized to access the library panel.');
        }

        if (!$user->library) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/library-login')
                ->with('error', 'Library account is not properly configured.');
        }

        $maxDevices = 2;
        $currentSessionId = $request->session()->getId();

        $otherSessions = \Illuminate\Support\Facades\DB::table('sessions')
            ->where('user_id', $user->id)
            ->where('id', '!=', $currentSessionId)
            ->orderByDesc('last_activity')
            ->pluck('id');

        if ($otherSessions->count() >= $maxDevices) {
            $sessionsToDelete = $otherSessions->slice($maxDevices - 1);

            \Illuminate\Support\Facades\DB::table('sessions')
                ->whereIn('id', $sessionsToDelete)
                ->delete();
        }

        return redirect('library-dashboard')->with('success', 'Welcome back to LMSP.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/library-login')
            ->with('success', 'You have been logged out successfully.');
    }
    public function dashboard()
    {
        $user = Auth::user();
        $library = $user->library;

        $subscription = null;

        if ($library) {
            $subscription = $library
                ->activeSubscription()
                ->with('plan')
                ->first();
        }

        $stats = [
            'totalStudents'         => 0,
            'activeStudents'        => 0,
            'pendingStudents'       => 0,
            'newThisMonth'          => 0,
            'presentToday'          => 0,
            'insideNow'             => 0,
            'attendanceRatePercent' => 0,
            'weeklyCheckInsTotal'   => 0,
            'totalSeats'            => 0,
            'occupiedSeats'         => 0,
            'partialSeats'          => 0,
            'availableSeats'        => 0,
            'maintenanceSeats'      => 0,
            'seatOccupancyPercent'  => 0,
            'totalBookedHours'      => 0,
            'totalCapacityHours'    => 0,
            'thisMonthRevenue'      => 0,
            'totalPendingDues'      => 0,
            'expiringSoonCount'     => 0,
            'collectionRatePercent' => 0,
        ];

        $seats = collect();
        $shiftSummary = collect();
        $recentStudents = collect();
        $recentActivities = collect();
        $weeklyAttendance = collect();

        if ($library) {
            $today = now()->startOfDay();
            $sevenDaysLater = $today->copy()->addDays(7);

            $allStudents = Student::where('library_id', $library->id)
                ->with([
                    'seat',
                    'shift',
                    'payments' => fn($q) => $q->where('payment_status', 'paid'),
                ])
                ->orderByDesc('id')
                ->get();

            $stats['totalStudents'] = $allStudents->count();
            $stats['activeStudents'] = $allStudents->where('status', 'active')->count();
            $stats['pendingStudents'] = $allStudents->where('status', 'pending')->count();
            $stats['newThisMonth'] = $allStudents->filter(function ($st) {
                return $st->admission_date && $st->admission_date->isCurrentMonth() && $st->admission_date->isCurrentYear();
            })->count();

            $totalDueAll = 0;
            $totalPaidAll = 0;
            $totalPendingDues = 0;
            $expiringSoonCount = 0;

            foreach ($allStudents as $st) {
                if ($st->status === 'pending') {
                    $st->computed_balance = 0;
                    $st->computed_next_due = null;
                    continue;
                }

                $admissionDate = $st->admission_date ? $st->admission_date->copy()->startOfDay() : $today->copy();
                $daysElapsed = max(0, (int) $admissionDate->diffInDays($today, false));
                $totalMonths = (int) floor($daysElapsed / 30) + 1;

                $due = round($totalMonths * (float) $st->payable_fee, 2);
                $paid = (float) $st->payments->sum('amount');
                $balance = max(0, round($due - $paid, 2));
                $nextDueDate = $admissionDate->copy()->addDays($totalMonths * 30);

                $st->computed_balance = $balance;
                $st->computed_next_due = $nextDueDate;

                $totalDueAll += $due;
                $totalPaidAll += $paid;
                $totalPendingDues += $balance;

                if ($st->status === 'active' && $nextDueDate->between($today, $sevenDaysLater)) {
                    $expiringSoonCount++;
                }
            }

            $stats['totalPendingDues'] = round($totalPendingDues, 2);
            $stats['expiringSoonCount'] = $expiringSoonCount;
            $stats['collectionRatePercent'] = $totalDueAll > 0
                ? min(100, (int) round(($totalPaidAll / $totalDueAll) * 100))
                : 100;

            // 2. Live Attendance Stats (Today + Last 7 Days)
            $todayAttendances = StudentAttendance::where('library_id', $library->id)
                ->whereDate('attendance_date', $today->toDateString())
                ->where('status', 'present')
                ->get();

            $stats['presentToday'] = $todayAttendances->count();
            $stats['insideNow'] = $todayAttendances->whereNull('check_out_time')->count();
            $insideStudentIds = $todayAttendances->whereNull('check_out_time')->pluck('student_id')->flip();

            $stats['attendanceRatePercent'] = $stats['activeStudents'] > 0
                ? min(100, (int) round(($stats['presentToday'] / $stats['activeStudents']) * 100))
                : 0;

            $start7Days = $today->copy()->subDays(6);
            $last7Records = StudentAttendance::where('library_id', $library->id)
                ->whereBetween('attendance_date', [$start7Days->toDateString(), $today->toDateString()])
                ->where('status', 'present')
                ->get()
                ->groupBy(fn($item) => $item->attendance_date->toDateString());

            $maxDaily = max(1, $stats['activeStudents']);

            for ($i = 6; $i >= 0; $i--) {
                $day = $today->copy()->subDays($i);
                $dateKey = $day->toDateString();
                $dayRows = $last7Records->get($dateKey, collect());

                $checkInCount = $dayRows->count();
                $checkOutCount = $dayRows->whereNotNull('check_out_time')->count();
                $stats['weeklyCheckInsTotal'] += $checkInCount;

                $weeklyAttendance->push((object) [
                    'label'      => $day->format('D'),
                    'check_in'   => $checkInCount,
                    'check_out'  => $checkOutCount,
                    'in_height'  => $checkInCount > 0 ? max(12, min(100, (int) round(($checkInCount / $maxDaily) * 100))) : 6,
                    'out_height' => $checkOutCount > 0 ? max(10, min(100, (int) round(($checkOutCount / $maxDaily) * 100))) : 4,
                ]);
            }

            // 3. Shift-Aware Seats Stats & First 20 Seats
            $allSeats = Seat::where('library_id', $library->id)
                ->with('activeStudents')
                ->orderBy('id')
                ->get()
                ->map(function ($seat) {
                    $usedHours = $seat->activeStudents->sum(fn($s) => $s->shift->duration_hours ?? 0);
                    $seat->used_hours = $usedHours;

                    if ($seat->status === 'maintenance') {
                        $seat->computed_status = 'maintenance';
                    } elseif ($usedHours >= 24 || $seat->status === 'occupied') {
                        $seat->computed_status = 'occupied';
                    } elseif ($usedHours > 0) {
                        $seat->computed_status = 'partial';
                    } else {
                        $seat->computed_status = 'available';
                    }

                    return $seat;
                });

            $stats['totalSeats'] = $allSeats->count();
            $stats['occupiedSeats'] = $allSeats->where('computed_status', 'occupied')->count();
            $stats['partialSeats'] = $allSeats->where('computed_status', 'partial')->count();
            $stats['availableSeats'] = $allSeats->where('computed_status', 'available')->count();
            $stats['maintenanceSeats'] = $allSeats->where('computed_status', 'maintenance')->count();

            $activeUsableSeats = max(1, $stats['totalSeats'] - $stats['maintenanceSeats']);
            $totalCapacityHours = $activeUsableSeats * 24;
            $totalBookedHours = $allSeats->where('computed_status', '!=', 'maintenance')->sum('used_hours');

            $stats['totalCapacityHours'] = $totalCapacityHours;
            $stats['totalBookedHours'] = $totalBookedHours;
            $stats['seatOccupancyPercent'] = ($stats['totalSeats'] - $stats['maintenanceSeats']) > 0
                ? min(100, (int) round(($totalBookedHours / $totalCapacityHours) * 100))
                : 0;

            $seats = $allSeats->take(20);

            // 4. Shift-Wise Breakdown
            $shifts = \App\Models\LibraryShift::where('library_id', $library->id)
                ->where('status', true)
                ->orderBy('start_time')
                ->orderBy('duration_hours')
                ->get();

            $activeStudentsList = $allStudents->where('status', 'active');
            $shiftSummary = $shifts->map(function ($sh) use ($activeStudentsList, $insideStudentIds) {
                $enrolled = $activeStudentsList->where('shift_id', $sh->id);
                $inside = $enrolled->filter(fn($s) => isset($insideStudentIds[$s->id]))->count();

                return (object) [
                    'id'       => $sh->id,
                    'name'     => $sh->shift_name,
                    'duration' => $sh->duration_hours,
                    'timing'   => ($sh->start_time && $sh->end_time)
                        ? \Carbon\Carbon::parse($sh->start_time)->format('h:i A') . ' - ' . \Carbon\Carbon::parse($sh->end_time)->format('h:i A')
                        : 'Flexible',
                    'fee'      => $sh->monthly_fee,
                    'enrolled' => $enrolled->count(),
                    'inside'   => $inside,
                ];
            });

            // 5. Revenue This Month
            $stats['thisMonthRevenue'] = (float) StudentPayment::where('library_id', $library->id)
                ->where('payment_status', 'paid')
                ->whereMonth('payment_date', now()->month)
                ->whereYear('payment_date', now()->year)
                ->sum('amount');

            // 6. Recent Students & Activity
            $recentStudents = $allStudents->take(5);

            $admissionEvents = $allStudents->take(4)->map(function ($st) {
                return (object) [
                    'type'      => 'admission',
                    'timestamp' => $st->created_at ?? now(),
                    'title'     => $st->name,
                    'detail'    => $st->status === 'pending'
                        ? 'submitted an online registration.'
                        : 'was added' . ($st->shift ? " ({$st->shift->shift_name})." : ' as a new student.'),
                ];
            });

            $latestPayments = StudentPayment::where('library_id', $library->id)
                ->where('payment_status', 'paid')
                ->with('student')
                ->orderByDesc('id')
                ->take(4)
                ->get()
                ->map(function ($pay) {
                    return (object) [
                        'type'      => 'payment',
                        'timestamp' => $pay->created_at ?? now(),
                        'title'     => '₹' . number_format((float) $pay->amount, 0),
                        'detail'    => 'received from ' . ($pay->student->name ?? 'Student') . '.',
                    ];
                });

            $recentActivities = $admissionEvents
                ->concat($latestPayments)
                ->sortByDesc('timestamp')
                ->take(5)
                ->values();
        }

        return view('library.dashboard', compact(
            'user',
            'library',
            'subscription',
            'stats',
            'seats',
            'shiftSummary',
            'recentStudents',
            'recentActivities',
            'weeklyAttendance'
        ));
    }
}
