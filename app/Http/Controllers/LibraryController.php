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
            $library = DB::transaction(function () use ($request, $validated) {
                $logoPath = null;
                if ($request->hasFile('logo')) {
                    $logoPath = $request->file('logo')->store('libraries/logos', 'public');
                    Log::info('Library logo uploaded successfully.', ['path' => $logoPath]);
                }

                do {
                    $libraryCode = 'LIB-' . strtoupper(Str::random(8));
                } while (Library::where('library_code', $libraryCode)->exists());

                $library = Library::create([
                    'library_code' => $libraryCode,
                    'library_type' => $validated['library_type'],
                    'library_name' => $validated['library_name'],
                    'logo'         => $logoPath,
                    'address'      => $validated['address'],
                    'city'         => $validated['city'],
                    'state'        => $validated['state'],
                    'pincode'      => $validated['pincode'],
                    'total_seats'  => $validated['total_seats'],
                    'facilities'   => $validated['facilities'] ?? [],
                    'status'       => 'pending',
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
                    'library_id' => $library->id,
                    'plan_id' => $freePlan->id,
                    'start_date' => Carbon::today(),
                    'end_date' => Carbon::today()->addDays($freePlan->duration_days),
                    'status' => 'active',
                    'payment_status' => 'not_required',
                ]);
                return $library;
            });

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
            'email' => ['required', 'email', 'max:191',],

            'password' => ['required', 'string', 'min:8',],
        ]);
        $throttleKey = Str::transliterate(
            Str::lower($validated['email']) . '|' . $request->ip()
        );

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()->withInput($request->only('email'))->with('error', "Too many login attempts. Please try again in {$seconds} seconds.");
        }
        $remember = $request->boolean('remember');

        if (!Auth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password'],
        ], $remember)) {

            RateLimiter::hit($throttleKey, 60);
            return back()->withInput($request->only('email'))->with('error', 'Invalid email or password.');
        }
        RateLimiter::clear($throttleKey);
        $request->session()->regenerate();
        $user = Auth::user();
        if ($user->role !== 'library_admin') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/library-login')->with('error', 'You are not authorized to access the library panel.');
        }
        if (!$user->library) {

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/library-login')->with('error', 'Library account is not properly configured.');
        }

        // if ($user->library->status !== 'active') {

        //     Auth::logout();

        //     $request->session()->invalidate();
        //     $request->session()->regenerateToken();

        //     return redirect('/library-login')
        //         ->with('error', 'Your library account is currently pending approval.');
        // }

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

        // Default fallback stats
        $stats = [
            'totalStudents' => 0,
            'activeStudents' => 0,
            'newThisMonth' => 0,
            'totalSeats' => 0,
            'occupiedSeats' => 0,
            'availableSeats' => 0,
            'maintenanceSeats' => 0,
            'seatOccupancyPercent' => 0,
            'thisMonthRevenue' => 0,
            'totalPendingDues' => 0,
            'expiringSoonCount' => 0,
            'collectionRatePercent' => 0,
        ];

        $seats = collect();
        $recentStudents = collect();
        $recentActivities = collect();

        if ($library) {
            $today = now()->startOfDay();
            $sevenDaysLater = $today->copy()->addDays(7);

            // 1. Students & 30-day cycle calculations
            $allStudents = Student::where('library_id', $library->id)
                ->with(['seat', 'payments' => fn($q) => $q->where('payment_status', 'paid')])
                ->orderByDesc('id')
                ->get();

            $stats['totalStudents'] = $allStudents->count();
            $stats['activeStudents'] = $allStudents->where('status', 'active')->count();
            $stats['newThisMonth'] = $allStudents->filter(function ($st) {
                return $st->admission_date && $st->admission_date->isCurrentMonth() && $st->admission_date->isCurrentYear();
            })->count();

            $totalDueAll = 0;
            $totalPaidAll = 0;
            $totalPendingDues = 0;
            $expiringSoonCount = 0;

            foreach ($allStudents as $st) {
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

            // 2. Seats Stats & First 20 Seats for Mini Grid
            $allSeats = Seat::where('library_id', $library->id)
                ->orderBy('seat_number')
                ->get();

            $stats['totalSeats'] = $allSeats->count();
            $stats['occupiedSeats'] = $allSeats->where('status', 'occupied')->count();
            $stats['availableSeats'] = $allSeats->where('status', 'available')->count();
            $stats['maintenanceSeats'] = $allSeats->where('status', 'maintenance')->count();
            $stats['seatOccupancyPercent'] = $stats['totalSeats'] > 0
                ? (int) round(($stats['occupiedSeats'] / $stats['totalSeats']) * 100)
                : 0;

            $seats = $allSeats->take(20);

            // 3. Revenue This Month
            $stats['thisMonthRevenue'] = (float) StudentPayment::where('library_id', $library->id)
                ->where('payment_status', 'paid')
                ->whereMonth('payment_date', now()->month)
                ->whereYear('payment_date', now()->year)
                ->sum('amount');

            // 4. Recent Students (Latest 5)
            $recentStudents = $allStudents->take(5);

            // 5. Recent Activity (Combine latest admissions + latest payments)
            $admissionEvents = $allStudents->take(4)->map(function ($st) {
                return (object) [
                    'type' => 'admission',
                    'timestamp' => $st->created_at ?? now(),
                    'title' => $st->name,
                    'detail' => 'was added as a new student.',
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
                        'type' => 'payment',
                        'timestamp' => $pay->created_at ?? now(),
                        'title' => '₹' . number_format((float) $pay->amount, 0),
                        'detail' => 'received from ' . ($pay->student->name ?? 'Student') . '.',
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
            'recentStudents',
            'recentActivities'
        ));
    }
}
