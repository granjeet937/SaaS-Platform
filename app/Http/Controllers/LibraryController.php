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

        if ($user->library->status !== 'active') {

            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/library-login')
                ->with('error', 'Your library account is currently pending approval.');
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

        return view('library.dashboard', [
            'user' => $user,
            'library' => $library,
        ]);
    }
}
