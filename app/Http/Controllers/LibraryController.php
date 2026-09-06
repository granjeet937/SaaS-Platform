<?php

namespace App\Http\Controllers;

use App\Models\Library;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
                // 1. Logo upload handling
                $logoPath = null;
                if ($request->hasFile('logo')) {
                    $logoPath = $request->file('logo')->store('libraries/logos', 'public');
                    Log::info('Library logo uploaded successfully.', ['path' => $logoPath]);
                }

                // 2. Unique library code generator
                do {
                    $libraryCode = 'LIB-' . strtoupper(Str::random(8));
                } while (Library::where('library_code', $libraryCode)->exists());

                // 3. Create Library record
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

                // 4. Create Owner/Admin User
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
                ->with('error', 'Registration failed. Please check the logs or try again.');
        }
    }
}
