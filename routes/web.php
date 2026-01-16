<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    // TODO: Implement login logic
    return back()->withErrors(['email' => 'Login functionality not implemented yet.']);
})->name('login');

Route::get('/register', function () {
    return view('auth.login'); // Placeholder
})->name('register');

Route::get('/forgot-password', function () {
    return view('auth.login'); // Placeholder
})->name('password.request');
