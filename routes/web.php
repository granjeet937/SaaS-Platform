<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibraryController;

Route::get('/', function () {
    return view('index');
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
});
