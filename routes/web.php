<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/library-login', function () {
    return view('library.login');
});

Route::get('/library-registration', function () {
    return view('library.registration');
});
