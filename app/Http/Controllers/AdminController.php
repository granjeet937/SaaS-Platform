<?php

namespace App\Http\Controllers;

use App\Mail\LibraryNotificationMail;
use App\Models\Library;
use App\Models\Student;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function showRegister()
    {
        if (Auth::check() && in_array(Auth::user()->role, ['super_admin', 'admin'])) {
            return redirect('/rgsmadmin/dashboard');
        }

        return view('rgsmadmin.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'setup_key' => ['required', 'string'],
            'name'      => ['required', 'string', 'max:100'],
            'email'     => ['required', 'email', 'max:150', 'unique:users,email'],
            'phone'     => ['required', 'digits:10', 'unique:users,phone'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $expectedKey = env('RGSM_ADMIN_SETUP_KEY');

        if (empty($expectedKey) || !hash_equals($expectedKey, $validated['setup_key'])) {
            return back()
                ->withInput($request->except(['password', 'password_confirmation', 'setup_key']))
                ->with('error', 'Invalid Secret Setup Key. Registration denied.');
        }

        $admin = User::create([
            'library_id' => null,
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'phone'      => $validated['phone'],
            'password'   => Hash::make($validated['password']),
            'role'       => 'super_admin',
        ]);

        Auth::login($admin);
        $request->session()->regenerate();

        return redirect('/rgsmadmin/dashboard')->with('success', 'Super Admin account created successfully!');
    }
    public function showLogin()
    {
        if (Auth::check() && in_array(Auth::user()->role, ['super_admin', 'admin'])) {
            return redirect('/rgsmadmin/dashboard');
        }
        return view('rgsmadmin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withInput($request->only('email'))->with('error', 'Invalid admin credentials.');
        }

        $request->session()->regenerate();
        $user = Auth::user();

        if (!in_array($user->role, ['super_admin', 'admin'])) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->with('error', 'Access denied. SaaS Super Admin privileges required.');
        }

        return redirect('/rgsmadmin/dashboard')->with('success', 'Welcome back, SaaS Admin!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/rgsmadmin')->with('success', 'Logged out successfully.');
    }

    public function dashboard(Request $request)
    {
        abort_unless(Auth::check() && in_array(Auth::user()->role, ['super_admin', 'admin']), 403);

        $statusFilter = $request->query('status', 'all');
        $search = trim((string) $request->query('search', ''));

        $query = Library::with(['users' => fn($q) => $q->where('role', 'library_admin'), 'activeSubscription.plan'])
            ->withCount('students')
            ->latest();

        if (in_array($statusFilter, ['pending', 'active', 'suspended'])) {
            $query->where('status', $statusFilter);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('library_name', 'like', "%{$search}%")
                    ->orWhere('library_code', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%");
            });
        }

        $libraries = $query->paginate(15);

        $stats = [
            'totalLibraries'      => Library::count(),
            'activeLibraries'     => Library::where('status', 'active')->count(),
            'pendingLibraries'    => Library::where('status', 'pending')->count(),
            'totalStudents'       => Student::count(),
            'activeSubscriptions' => Subscription::where('status', 'active')->count(),
            'saasRevenue'         => (float) Subscription::where('payment_status', 'paid')
                ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
                ->sum('plans.price'),
        ];

        return view('rgsmadmin.dashboard', compact('libraries', 'stats', 'statusFilter', 'search'));
    }

    public function approveLibrary(int $id)
    {
        abort_unless(Auth::check() && in_array(Auth::user()->role, ['super_admin', 'admin']), 403);

        $library = Library::findOrFail($id);
        $library->update(['status' => 'active']);

        $owner = User::where('library_id', $library->id)
            ->where('role', 'library_admin')
            ->first();

        if ($owner && $owner->email) {
            try {
                Mail::to($owner->email)->send(new LibraryNotificationMail([
                    'subject'        => "Library Approved & Activated — {$library->library_name}",
                    'library_name'   => 'LMSP — Library Management SaaS Platform',
                    'recipient_name' => $owner->name,
                    'badge_text'     => 'ACCOUNT APPROVED',
                    'badge_color'    => '#16a34a',
                    'intro_message'  => "Great news! Your study library {$library->library_name} has been approved and is now live on LMSP.",
                    'details'        => [
                        'Library Code' => $library->library_code,
                        'Library Name' => $library->library_name,
                        'Login Email'  => $owner->email,
                        'Login URL'    => url('/library-login'),
                        'Status'       => 'Active',
                    ],
                    'footer_note'    => 'Log in now to configure your shifts, seat sections, and student admissions.',
                ]));
            } catch (\Throwable $e) {
                Log::warning('Library approval mail failed: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', "{$library->library_name} approved and activation email sent!");
    }

    public function suspendLibrary(int $id)
    {
        abort_unless(Auth::check() && in_array(Auth::user()->role, ['super_admin', 'admin']), 403);

        $library = Library::findOrFail($id);
        $library->update(['status' => 'suspended']);

        return redirect()->back()->with('success', "{$library->library_name} has been suspended.");
    }
}
