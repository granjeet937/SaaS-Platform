<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibraryController;

Route::get('/', function () {
    return view('index');
});

Route::get('/library-login', function () {
    return view('library.login');
});
Route::post('/library_registration_store', [LibraryController::class, 'datastore']);

Route::get('/library-registration', function () {
    return view('library.registration');
});

Route::get('/library-dashboard', function () {
    return view('dashboard');
});
