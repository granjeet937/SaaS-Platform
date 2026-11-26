<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\StudentController;
use App\Models\Plan;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\AttendanceController;
use App\Http\Middleware\EnsureKioskUnlocked;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LibraryShiftController;

Route::get('/', function () {
    $plans = Plan::where('status', 1)->orderBy('price', 'asc')->get();
    return view('index', compact('plans'));
})->name('login');

Route::get('/library-login', function () {
    return view('library.login');
});
Route::post('/library-loginLMSP', [LibraryController::class, 'loginLMSP']);
Route::post('/library-logout', [LibraryController::class, 'logout'])->middleware('auth')->name('library.logout');
Route::post('/library_registration_store', [LibraryController::class, 'datastore']);

Route::get('/library-registration', function () {
    return view('library.registration');
});

// Public Student Self-Registration (Token Protected)
Route::get('/admission/{token}', [StudentController::class, 'publicRegisterForm'])->name('public.admission.form');
Route::post('/admission/{token}', [StudentController::class, 'publicRegisterStore'])->middleware('throttle:10,1')->name('public.admission.store');

Route::middleware(['auth', EnsureKioskUnlocked::class])->group(function () {
    Route::get('/library-dashboard', [LibraryController::class, 'dashboard']);

    // Library Shifts Management
    Route::get('/library/shifts', [LibraryShiftController::class, 'index'])->name('shifts.index');
    Route::put('/library/shifts/{id}', [LibraryShiftController::class, 'update'])->name('shifts.update');
    Route::patch('/library/shifts/{id}/toggle-status', [LibraryShiftController::class, 'toggleStatus'])->name('shifts.toggle-status');
    Route::delete('/library/shifts/{id}', [LibraryShiftController::class, 'destroy'])->name('shifts.destroy');
    Route::post('/library/shifts/bulk', [LibraryShiftController::class, 'storeBulk'])->name('shifts.bulk');

    // Students
    Route::get('/library/students', [StudentController::class, 'index']);
    Route::get('/library/students/add', [StudentController::class, 'create']);
    Route::post('/library/students/store', [StudentController::class, 'store']);
    Route::get('/library/students/view/{id}', [StudentController::class, 'show']);
    Route::get('/library/students/{id}/photo', [StudentController::class, 'showPhoto'])->name('students.photo');
    Route::post('/library/students/update/{id}', [StudentController::class, 'update']);
    Route::post('/library/students/collect-fee/{id}', [StudentController::class, 'collectFee']);
    Route::post('/library/students/change-seat/{id}', [StudentController::class, 'changeSeat']);
    Route::post('/library/students/toggle-status/{id}', [StudentController::class, 'toggleStatus']);
    Route::post('/library/students/delete/{id}', [StudentController::class, 'destroy']);

    // Fees & Receipts
    Route::get('/library/fees', [StudentController::class, 'feesIndex']);
    Route::get('/library/payments/receipt/{id}', [StudentController::class, 'printReceipt']);

    // Seats
    Route::get('/library/seats', [SeatController::class, 'index']);
    Route::post('/library/seats/update-section', [SeatController::class, 'updateSection']);

    // Attendance & Kiosk
    Route::get('/library/attendance', [AttendanceController::class, 'index']);
    Route::post('/library/attendance/check-in/{studentId}', [AttendanceController::class, 'checkIn']);
    Route::post('/library/attendance/check-out/{studentId}', [AttendanceController::class, 'checkOut']);
    Route::post('/library/attendance/mark-absent/{studentId}', [AttendanceController::class, 'markAbsent']);
    Route::post('/library/attendance/mark-all-present', [AttendanceController::class, 'markAllPresent']);
    Route::get('/library/attendance/kiosk', [AttendanceController::class, 'kiosk']);
    Route::get('/library/attendance/kiosk/search', [AttendanceController::class, 'kioskSearch']);
    Route::post('/library/attendance/kiosk/punch/{studentId}', [AttendanceController::class, 'kioskPunch']);
    Route::post('/library/attendance/kiosk/unlock', [AttendanceController::class, 'kioskUnlock']);

    // Reports
    Route::get('/library/reports', [ReportController::class, 'index']);
    Route::get('/library/reports/export', [ReportController::class, 'exportCsv']);
    Route::get('/library/reports/student/{id}', [ReportController::class, 'studentParentReport']);

    // Student Invite Link & Pending Approval
    Route::post('/library/students/regenerate-token', [StudentController::class, 'regenerateInviteToken']);
    Route::post('/library/students/approve/{id}', [StudentController::class, 'approvePending']);
});
