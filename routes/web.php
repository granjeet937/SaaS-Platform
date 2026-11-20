<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\StudentController;
use App\Models\Plan;
use App\Http\Controllers\SeatController;

Route::get('/', function () {

    $plans = Plan::where('status', 1)
        ->orderBy('price', 'asc')
        ->get();

    return view('index', compact('plans'));
});

Route::get('/library-login', function () {
    return view('library.login');
});
Route::post('/library-loginLMSP', [LibraryController::class, 'loginLMSP']);
Route::post('/library-logout', [LibraryController::class, 'logout'])->middleware('auth')->name('library.logout');
Route::post('/library_registration_store', [LibraryController::class, 'datastore']);

Route::get('/library-registration', function () {
    return view('library.registration');
});


Route::middleware('auth')->group(function () {

    Route::get('/library-dashboard', [
        LibraryController::class,
        'dashboard'
    ]);
    Route::get('/library/students', [StudentController::class, 'index']);
    Route::get('/library/students/add', [StudentController::class, 'create']);
    Route::post('/library/students/store', [StudentController::class, 'store']);
    Route::get('/library/students/view/{id}', [StudentController::class, 'show']);
    Route::post('/library/students/update/{id}', [StudentController::class, 'update']);
    Route::post('/library/students/collect-fee/{id}', [StudentController::class, 'collectFee']);
    Route::get('/library/fees', [StudentController::class, 'feesIndex']);
    Route::get('/library/payments/receipt/{id}', [StudentController::class, 'printReceipt']);
    Route::post('/library/students/change-seat/{id}', [StudentController::class, 'changeSeat']);
    Route::get('/library/seats', [SeatController::class, 'index']);
    Route::post('/library/seats/update-section', [SeatController::class, 'updateSection']);
    Route::post('/library/students/toggle-status/{id}', [StudentController::class, 'toggleStatus']);
    Route::post('/library/students/delete/{id}', [StudentController::class, 'destroy']);
});
