<?php


use App\Http\Controllers\BukuTamuController;
use App\Http\Controllers\DashboardController;

// Auth Controller
use App\Http\Controllers\Auth\ProfileController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthController;



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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //Route buku tamu
    Route::controller(BukuTamuController::class)->prefix('/tamu')->name('tamu.')->group( function() {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store/', 'store')->name('store');
        Route::get('/edit/{no}', 'edit')->name('edit');
        Route::put('/update/{no}', 'update')->name('update');
        Route::delete('/destroy/{no}', 'destroy')->name('destroy');
        Route::get('/export', 'export')->name('export');

    });



    //user Route
    Route::put('/users/{user}', [ProfileController::class, 'update'])->name('users.update');



    // Logout Route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
