<?php

namespace App\Http\Controllers;

use App\Models\Seat;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    public function index(Request $request)
    {
        $library = $request->user()->library;

        abort_unless($library, 403, 'Library account not found.');

        $totalSeats = (int) ($library->total_seats ?? 0);
        $padLength = max(2, strlen((string) $totalSeats));

        $existingNumbers = Seat::where('library_id', $library->id)
            ->pluck('seat_number')
            ->flip();

        $newSeats = [];
        $now = now();

        for ($i = 1; $i <= $totalSeats; $i++) {
            $seatNumber = 'LAB' . $library->id . '-' . str_pad((string) $i, $padLength, '0', STR_PAD_LEFT);

            if (!isset($existingNumbers[$seatNumber])) {
                $newSeats[] = [
                    'library_id' => $library->id,
                    'seat_number' => $seatNumber,
                    'section' => null,
                    'status' => 'available',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        if (!empty($newSeats)) {
            Seat::insert($newSeats);
        }

        $seats = Seat::where('library_id', $library->id)
            ->with('student')
            ->orderBy('id')
            ->get();

        $sections = $seats->pluck('section')
            ->filter()
            ->unique()
            ->values();

        $stats = [
            'total' => $totalSeats,
            'available' => $seats->where('status', 'available')->count(),
            'occupied' => $seats->where('status', 'occupied')->count(),
            'maintenance' => $seats->where('status', 'maintenance')->count(),
        ];

        return view('library.seats.seatindex', compact('library', 'seats', 'sections', 'stats'));
    }

    public function updateSection(Request $request)
    {
        $library = $request->user()->library;

        abort_unless($library, 403, 'Library account not found.');

        $validated = $request->validate([
            'seat_ids' => ['required', 'array', 'min:1'],
            'seat_ids.*' => ['integer'],
            'section' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'in:available,maintenance'],
        ]);

        $seats = Seat::where('library_id', $library->id)
            ->whereIn('id', $validated['seat_ids'])
            ->get();

        foreach ($seats as $seat) {
            $updateData = [
                'section' => isset($validated['section']) && trim($validated['section']) !== ''
                    ? trim($validated['section'])
                    : null,
            ];

            // Occupied seat ka status bina student release kiye change nahi hoga
            if (!empty($validated['status']) && $seat->status !== 'occupied') {
                $updateData['status'] = $validated['status'];
            }

            $seat->update($updateData);
        }

        return redirect('/library/seats')
            ->with('success', count($seats) . ' seat(s) updated successfully.');
    }
}
