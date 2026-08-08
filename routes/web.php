<?php



use Illuminate\Support\Facades\Route;


// inspeksi

use App\Http\Controllers\inspeksi\UpsController;
use App\Http\Controllers\inspeksi\StavoltController;
use App\Http\Controllers\inspeksi\MonitorController;
use App\Http\Controllers\inspeksi\ProyektorController;

use App\Http\Controllers\BukuTamuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventarisController;


// Auth Controller
use App\Http\Controllers\Auth\ProfileController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\inspeksi\Ss6Controller;
use App\Http\Controllers\KaryawanController;

// Route::get('/', function () {
//     return view('dashboard');
// });

Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role == 'admin') {
            return redirect()->route('dashboard');
        }

        // return redirect()->route('security.dashboard');
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

    //Route Inventaris 
    Route::controller(InventarisController::class)->prefix('/inventaris')->name('inventaris.')->group( function() {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        Route::get('/export', 'export')->name('export');
        Route::put('/return/{id}', 'returnStatus')->name('returnStatus');
    });

    //Route Karyawan
    Route::controller(KaryawanController::class)->prefix('/karyawan')->name('karyawan.')->group( function() {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{karyawan}/edit', 'edit')->name('edit');
        Route::put('/{karyawan}/update', 'update')->name('update');
        Route::delete('/{karyawan}/destroy', 'destory')->name('destroy');
    });



    // Route Inspeksi
    // Route Stavolt
    Route::controller(StavoltController::class)
        ->prefix('/inspeksi/stavolt')
        ->name('inspeksi.stavolt.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{stavolt}/edit', 'edit')->name('edit');
            Route::put('/{stavolt}', 'update')->name('update');
            Route::delete('/{stavolt}', 'destroy')->name('destroy');
        });

    // Route UPS
    Route::controller(UpsController::class)
        ->prefix('/inspeksi/ups')
        ->name('inspeksi.ups.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{ups}/edit', 'edit')->name('edit');
            Route::put('/{ups}', 'update')->name('update');
            Route::delete('/{ups}', 'destroy')->name('destroy');
        });

    // Route Monitor
    Route::controller(MonitorController::class)
        ->prefix('/inspeksi/monitor')
        ->name('inspeksi.monitor.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{monitor}/edit', 'edit')->name('edit');
            Route::put('/{monitor}', 'update')->name('update');
            Route::delete('/{monitor}', 'destroy')->name('destroy');
        });
        
    // Route Proyektor
    Route::controller(ProyektorController::class)
        ->prefix('/inspeksi/proyektor')
        ->name('inspeksi.proyektor.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{proyektor}/edit', 'edit')->name('edit');
            Route::put('/{proyektor}', 'update')->name('update');
            Route::delete('/{proyektor}', 'destroy')->name('destroy');
        });

    // Route SS6
    Route::controller(Ss6Controller::class)
        ->prefix('/inspeksi/ss6')
        ->name('inspeksi.ss6.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
        });

    
    //user Route
    Route::put('/users/{user}', [ProfileController::class, 'update'])->name('users.update');

    // Logout Route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});