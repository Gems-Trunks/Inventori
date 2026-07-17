<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('dashboard');
});

// Auntetikasi

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
});

// Route buat aplikasi
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
