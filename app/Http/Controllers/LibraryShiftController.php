<?php

namespace App\Http\Controllers;

use App\Models\Library;
use App\Models\LibraryShift;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LibraryShiftController extends Controller
{
    private function getPresetTemplates(float $fee = 0): array
    {
        return [
            '4x6' => [
                ['shift_name' => 'Morning Shift (6 Hrs)',   'duration_hours' => 6,  'start_time' => '06:00', 'end_time' => '12:00', 'monthly_fee' => $fee],
                ['shift_name' => 'Afternoon Shift (6 Hrs)', 'duration_hours' => 6,  'start_time' => '12:00', 'end_time' => '18:00', 'monthly_fee' => $fee],
                ['shift_name' => 'Evening Shift (6 Hrs)',   'duration_hours' => 6,  'start_time' => '18:00', 'end_time' => '00:00', 'monthly_fee' => $fee],
                ['shift_name' => 'Night Shift (6 Hrs)',     'duration_hours' => 6,  'start_time' => '00:00', 'end_time' => '06:00', 'monthly_fee' => $fee],
            ],
            '3x8' => [
                ['shift_name' => 'Morning Slot (8 Hrs)',    'duration_hours' => 8,  'start_time' => '06:00', 'end_time' => '14:00', 'monthly_fee' => $fee],
                ['shift_name' => 'Evening Slot (8 Hrs)',    'duration_hours' => 8,  'start_time' => '14:00', 'end_time' => '22:00', 'monthly_fee' => $fee],
                ['shift_name' => 'Night Slot (8 Hrs)',      'duration_hours' => 8,  'start_time' => '22:00', 'end_time' => '06:00', 'monthly_fee' => $fee],
            ],
            '2x12' => [
                ['shift_name' => 'Day Full Shift (12 Hrs)',   'duration_hours' => 12, 'start_time' => '06:00', 'end_time' => '18:00', 'monthly_fee' => $fee],
                ['shift_name' => 'Night Full Shift (12 Hrs)', 'duration_hours' => 12, 'start_time' => '18:00', 'end_time' => '06:00', 'monthly_fee' => $fee],
            ],
            '1x24' => [
                ['shift_name' => 'Full Day Reserved (24 Hrs)', 'duration_hours' => 24, 'start_time' => '00:00', 'end_time' => '23:59', 'monthly_fee' => $fee],
            ],
        ];
    }

    private function detectActivePreset($shifts): ?string
    {
        $existingNames = $shifts->pluck('shift_name')->toArray();
        if (empty($existingNames)) {
            return null;
        }

        foreach ($this->getPresetTemplates() as $key => $items) {
            $templateNames = array_column($items, 'shift_name');
            if (count(array_intersect($templateNames, $existingNames)) > 0) {
                return $key;
            }
        }

        return null;
    }

    public function index()
    {
        $libraryId = Auth::user()->library_id;

        $shifts = LibraryShift::where('library_id', $libraryId)
            ->orderBy('start_time', 'asc')
            ->orderBy('duration_hours', 'asc')
            ->get();

        $activePreset = $this->detectActivePreset($shifts);

        return view('library.shifts.shifts', compact('shifts', 'activePreset'));
    }

    private function generateShiftCode(Library $library): string
    {
        $sequence = LibraryShift::where('library_id', $library->id)->count() + 1;

        do {
            $shiftCode = $library->library_code . '-SHF' . str_pad((string) $sequence, 2, '0', STR_PAD_LEFT);
            $sequence++;
        } while (LibraryShift::where('shift_code', $shiftCode)->exists());

        return $shiftCode;
    }


    public function storeBulk(Request $request)
    {
        $library = $request->user()->library;
        abort_unless($library, 403, 'Library account not found.');

        $validated = $request->validate([
            'preset_type' => ['required', 'in:4x6,3x8,2x12,1x24'],
            'base_fee'    => ['required', 'numeric', 'min:0', 'max:999999.99'],
        ]);

        $existingShifts = LibraryShift::where('library_id', $library->id)->get();
        $activePreset = $this->detectActivePreset($existingShifts);

        // Agar pehle se koi preset active hai to naya preset block karein
        if ($activePreset !== null) {
            return redirect()->route('shifts.index')
                ->with('error', 'A shift preset is already active. Delete existing preset shifts first if you want to switch templates, or use "+ Add Custom Shift".');
        }

        $fee = (float) $validated['base_fee'];
        $selectedBatch = $this->getPresetTemplates($fee)[$validated['preset_type']];
        $createdCount = 0;

        DB::transaction(function () use ($library, $selectedBatch, &$createdCount) {
            foreach ($selectedBatch as $item) {
                LibraryShift::create([
                    'library_id'     => $library->id,
                    'shift_code'     => $this->generateShiftCode($library),
                    'shift_name'     => $item['shift_name'],
                    'duration_hours' => $item['duration_hours'],
                    'start_time'     => $item['start_time'],
                    'end_time'       => $item['end_time'],
                    'monthly_fee'    => $item['monthly_fee'],
                    'status'         => true,
                ]);
                $createdCount++;
            }
        });

        return redirect()->route('shifts.index')
            ->with('success', "{$createdCount} shift(s) generated automatically!");
    }

    public function update(Request $request, $id)
    {
        $shift = LibraryShift::where('library_id', Auth::user()->library_id)
            ->findOrFail($id);

        $validated = $request->validate([
            'shift_name'     => ['required', 'string', 'max:100'],
            'duration_hours' => ['required', 'integer', 'in:4,6,8,10,12,16,24'],
            'start_time'     => ['nullable', 'date_format:H:i'],
            'end_time'       => ['nullable', 'date_format:H:i'],
            'monthly_fee'    => ['required', 'numeric', 'min:0', 'max:999999.99'],
        ]);

        $shift->update([
            'shift_name'     => $validated['shift_name'],
            'duration_hours' => $validated['duration_hours'],
            'start_time'     => $validated['start_time'] ?? null,
            'end_time'       => $validated['end_time'] ?? null,
            'monthly_fee'    => $validated['monthly_fee'],
        ]);

        return redirect()->route('shifts.index')
            ->with('success', 'Shift updated successfully.');
    }

    public function toggleStatus($id)
    {
        $shift = LibraryShift::where('library_id', Auth::user()->library_id)
            ->findOrFail($id);

        $shift->update(['status' => !$shift->status]);

        return redirect()->route('shifts.index')
            ->with('success', 'Shift status updated.');
    }

    public function destroy($id)
    {
        $libraryId = Auth::user()->library_id;
        $shift = LibraryShift::where('library_id', $libraryId)->findOrFail($id);

        $hasStudents = Student::where('library_id', $libraryId)
            ->where('shift_id', $shift->id)
            ->exists();

        if ($hasStudents) {
            return redirect()->route('shifts.index')
                ->with('error', 'Cannot delete this shift because students are assigned to it. Mark it Inactive instead.');
        }

        $shift->delete();

        return redirect()->route('shifts.index')
            ->with('success', 'Shift deleted successfully.');
    }
}
