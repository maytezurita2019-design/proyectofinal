<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InterfazController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/registro', [AuthController::class, 'register'])->name('register');
    Route::post('/registro', [AuthController::class, 'storeRegistration'])->middleware('throttle:5,1')->name('register.store');
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
});

Route::post('/logout', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [InterfazController::class, 'dashboard'])->name('inicio');
    Route::get('/dashboard', [InterfazController::class, 'dashboard'])->name('dashboard');
    Route::get('/interfaz/{modulo}/{seccion}', [InterfazController::class, 'seccion'])->name('interfaz.seccion');
});

use App\Http\Controllers\ServiceStationController;

Route::get('/service-stations', [ServiceStationController::class, 'index'])
    ->name('service-stations.index');

Route::get('/service-stations/create', [ServiceStationController::class, 'create'])
    ->name('service-stations.create');

Route::get('/service-stations/search-location', [ServiceStationController::class, 'searchLocation'])
    ->name('service-stations.search-location');

Route::post('/service-stations', [ServiceStationController::class, 'store'])
    ->name('service-stations.store');