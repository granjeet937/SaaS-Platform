<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/library-login', function () {
    return view('login');
});

Route::get('/library-registration', function () {
    return view('registration');
});

Route::get('/library-dashboard', function () {
    return view('dashboard');
});