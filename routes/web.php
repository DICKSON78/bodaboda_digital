<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\RiderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RideController;
use App\Http\Controllers\AuthController;

Route::get('/', function () { return view('welcome'); })->name('home');
Route::get('/about', function () { return view('pages.about'); })->name('about');
Route::get('/services', function () { return view('pages.services'); })->name('services');
Route::get('/contact', function () { return view('pages.contact'); })->name('contact');

// Rider Specific Auth
Route::get('/rider/register', [RiderController::class, 'showRegister'])->name('rider.register');
Route::get('/rider/login', [RiderController::class, 'showLogin'])->name('rider.login');
Route::post('/rider/register', [RiderController::class, 'store'])->name('rider.store');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
Route::get('/riders/online', [App\Http\Controllers\LocationController::class, 'getAllOnlineRiders'])->name('riders.online');
Route::get('/api/locations', [App\Http\Controllers\LocationController::class, 'getLocations']);

// Ride Request API Routes
Route::post('/api/rides/request', [App\Http\Controllers\RideRequestController::class, 'requestRide']);
Route::post('/api/rides/{ride}/accept', [App\Http\Controllers\RideRequestController::class, 'acceptRide']);
Route::post('/api/rides/{ride}/decline', [App\Http\Controllers\RideRequestController::class, 'declineRide']);
Route::post('/api/rides/{ride}/status', [App\Http\Controllers\RideRequestController::class, 'updateStatus']);
Route::post('/api/driver/location', [App\Http\Controllers\RideRequestController::class, 'updateDriverLocation']);

// Public Ride Routes (Guest Booking & Tracking)
Route::get('/rides/create', [RideController::class, 'create'])->name('rides.create');
Route::post('/rides', [RideController::class, 'store'])->name('rides.store');
Route::post('/rides/calculate-fare', [RideController::class, 'calculateFare'])->name('rides.calculate-fare');
Route::get('/rides/{ride}', [RideController::class, 'show'])->name('rides.show');
Route::get('/rides/{ride}/location', [App\Http\Controllers\LocationController::class, 'getRiderLocation'])->name('rides.location');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    
    Route::post('/logout', function () {
        auth()->logout();
        return redirect('/');
    })->name('logout');

    // Rider Only Routes
    Route::middleware(['role:rider'])->group(function () {
        Route::get('/rider/apply', [RiderController::class, 'apply'])->name('rider.apply');
        Route::post('/rider/apply', [RiderController::class, 'store'])->name('rider.store');
        Route::post('/rider/toggle', [RiderController::class, 'toggleStatus'])->name('rider.toggle');
        
        Route::post('/rides/{ride}/accept', [RideController::class, 'accept'])->name('rides.accept');
        Route::post('/rides/{ride}/start', [RideController::class, 'start'])->name('rides.start');
        Route::post('/rides/{ride}/complete', [RideController::class, 'complete'])->name('rides.complete');
        Route::post('/location/update', [App\Http\Controllers\LocationController::class, 'update'])->name('location.update');
    });

    Route::post('/rides/{ride}/cancel', [RideController::class, 'cancel'])->name('rides.cancel');

    // Rating Routes
    Route::get('/rides/{ride}/rate', [App\Http\Controllers\RatingController::class, 'create'])->name('ratings.create');
    Route::post('/rides/{ride}/rate', [App\Http\Controllers\RatingController::class, 'store'])->name('ratings.store');

    // Admin Routes
    Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/riders', [AdminController::class, 'riders'])->name('riders');
        Route::get('/riders/{rider}', [AdminController::class, 'showRider'])->name('riders.show');
        Route::get('/riders/{rider}/edit', [AdminController::class, 'editRider'])->name('riders.edit');
        Route::put('/riders/{rider}', [AdminController::class, 'updateRider'])->name('riders.update');
        Route::post('/rider/{rider}/approve', [AdminController::class, 'approveRider'])->name('rider.approve');
        Route::post('/rider/{rider}/reject', [AdminController::class, 'rejectRider'])->name('rider.reject');
        Route::post('/rider/{rider}/suspend', [AdminController::class, 'suspendRider'])->name('rider.suspend');
        Route::post('/rider/{rider}/activate', [AdminController::class, 'activateRider'])->name('rider.activate');
        Route::delete('/rider/{rider}', [AdminController::class, 'deleteRider'])->name('rider.delete');
        Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
        Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    });
});
