<?php

use App\Http\Controllers\inspeksi\OfaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/units/select2', [OfaController::class, 'select2']);
