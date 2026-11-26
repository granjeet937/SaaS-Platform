<?php

namespace App\Http\Controllers;

use App\Models\LibraryShift;
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
            $seatNumber = 'LIB' . $library->id . '-' . str_pad((string) $i, $padLength, '0', STR_PAD_LEFT);

            if (!isset($existingNumbers[$seatNumber])) {
                $newSeats[] = [
                    'library_id'  => $library->id,
                    'seat_number' => $seatNumber,
                    'section'     => null,
                    'status'      => 'available',
                    'created_at'  => $now,
                    'updated_at'  => $now,
                ];
            }
        }

        if (!empty($newSeats)) {
            Seat::insert($newSeats);
        }

        $shifts = LibraryShift::where('library_id', $library->id)
            ->where('status', true)
            ->orderBy('start_time')
            ->orderBy('duration_hours')
            ->get();

        $seats = Seat::where('library_id', $library->id)
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

        $sections = $seats->pluck('section')
            ->filter()
            ->unique()
            ->values();

        $stats = [
            'total'       => $totalSeats,
            'available'   => $seats->where('computed_status', 'available')->count(),
            'partial'     => $seats->where('computed_status', 'partial')->count(),
            'occupied'    => $seats->where('computed_status', 'occupied')->count(),
            'maintenance' => $seats->where('computed_status', 'maintenance')->count(),
        ];

        return view('library.seats.seatindex', compact('library', 'seats', 'sections', 'stats', 'shifts'));
    }

    public function updateSection(Request $request)
    {
        $library = $request->user()->library;

        abort_unless($library, 403, 'Library account not found.');

        $validated = $request->validate([
            'seat_ids'   => ['required', 'array', 'min:1'],
            'seat_ids.*' => ['integer'],
            'section'    => ['nullable', 'string', 'max:255'],
            'status'     => ['nullable', 'in:available,maintenance'],
        ]);

        $seats = Seat::where('library_id', $library->id)
            ->withCount('activeStudents')
            ->whereIn('id', $validated['seat_ids'])
            ->get();

        foreach ($seats as $seat) {
            $updateData = [
                'section' => isset($validated['section']) && trim($validated['section']) !== ''
                    ? trim($validated['section'])
                    : null,
            ];

            if (!empty($validated['status']) && $seat->active_students_count === 0 && $seat->status !== 'occupied') {
                $updateData['status'] = $validated['status'];
            }

            $seat->update($updateData);
        }

        return redirect('/library/seats')
            ->with('success', count($seats) . ' seat(s) updated successfully.');
    }
}
