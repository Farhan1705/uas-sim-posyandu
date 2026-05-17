<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PregnantWomanController;
use App\Http\Controllers\ChildController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::resource('pregnant-women', PregnantWomanController::class)->middleware('auth');

Route::resource('children', ChildController::class)->middleware('auth');

Route::get('/children/{id}/growth-chart', [ChildController::class, 'growthChart'])
    ->name('children.growth-chart')
    ->middleware('auth');

Route::get('/children/{id}/ai-recommendation', [ChildController::class, 'aiRecommendation'])
    ->name('children.ai-recommendation')
    ->middleware('auth');