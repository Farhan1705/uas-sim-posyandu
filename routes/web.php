<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PregnantWomanController;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\MeasurementController;
use App\Http\Controllers\ImmunizationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// ========== PUBLIC ROUTES ==========
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// ========== AUTHENTICATED ROUTES ==========
Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ========== IBU HAMIL ==========
    Route::resource('pregnant-women', PregnantWomanController::class);

    // ========== BALITA ==========
    Route::resource('children', ChildController::class);
    Route::get('/children/{id}/growth-chart', [ChildController::class, 'growthChart'])->name('children.growth-chart');
    Route::get('/children/{id}/ai-recommendation', [ChildController::class, 'aiRecommendation'])->name('children.ai-recommendation');

    // ========== PENGUKURAN ==========
    Route::prefix('children/{childId}')->group(function () {
        Route::get('/measurements', [MeasurementController::class, 'index'])->name('measurements.index');
        Route::get('/measurements/create', [MeasurementController::class, 'create'])->name('measurements.create');
        Route::post('/measurements', [MeasurementController::class, 'store'])->name('measurements.store');
        Route::get('/measurements/{id}/edit', [MeasurementController::class, 'edit'])->name('measurements.edit');
        Route::put('/measurements/{id}', [MeasurementController::class, 'update'])->name('measurements.update');
        Route::delete('/measurements/{id}', [MeasurementController::class, 'destroy'])->name('measurements.destroy');
    });

    // ========== IMUNISASI ==========
    Route::resource('immunizations', ImmunizationController::class);

});
