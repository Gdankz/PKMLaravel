<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\MonitoringController;

Route::get('/monitoring', [MonitoringController::class, 'index']);

Route::get('/history', [HistoryController::class, 'index']);
Route::get('/history/{no_rm}', [HistoryController::class, 'show']);


Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Registration routes
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Dashboard route
Route::get('/dashboard', [AuthController::class, 'dashboard'])->middleware('auth')->name('dashboard');

// Pastikan route dashboard menggunakan middleware auth
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/monitoring-realtime', function () {
        return view('monitoring-realtime');

    });
});
