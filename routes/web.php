<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ProfileController;
use Illuminate\Support\Facades\Auth;
// Auth Controller
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('dashboard');
// });

Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role == 'admin') {
            return redirect()->route('dashboard');
        }

        return redirect()->route('security.dashboard');
    }

    return redirect()->route('login');
});

// Auntetikasi

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
});

// Route buat aplikasi
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    //user Route
    Route::put('/users/{user}', [ProfileController::class, 'update'])->name('users.update');



    // Logout Route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
