<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\RiderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RideController;
use App\Http\Controllers\RideRequestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MetricsController;

Route::get('/', function () { return view('welcome'); })->name('home');
Route::get('/about', function () { return view('pages.about'); })->name('about');
Route::get('/services', function () { return view('pages.services'); })->name('services');
Route::get('/contact', function () { return view('pages.contact'); })->name('contact');

// Rider Specific Auth
Route::get('/rider/register', [RiderController::class, 'showRegister'])->name('rider.register');
Route::get('/rider/login', [RiderController::class, 'showLogin'])->name('rider.login');
Route::post('/rider/register', [RiderController::class, 'store'])->name('rider.store')->middleware('throttle:5,10');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:5,10');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Confirmation Route (for password.confirm middleware)
Route::get('/confirm-password', [AuthController::class, 'showConfirmForm'])->name('password.confirm');
Route::post('/confirm-password', [AuthController::class, 'confirm']);

// Password Reset Routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email')->middleware('throttle:5,10');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update')->middleware('throttle:5,10');
Route::get('/riders/online', [App\Http\Controllers\LocationController::class, 'getAllOnlineRiders'])->name('riders.online');
Route::get('/api/locations', [App\Http\Controllers\LocationController::class, 'getLocations']);

// Metrics endpoint for Prometheus
Route::get('/metrics', [MetricsController::class, 'metrics']);

// Health check endpoint for CI/CD
Route::get('/api/health', [App\Http\Controllers\HealthController::class, 'health']);

// Ride Request API Routes (rate-limited)
Route::get('/api/ride-requests', [App\Http\Controllers\RideRequestController::class, 'pendingRequests'])->middleware('throttle:60,1');
Route::post('/api/rides/request', [App\Http\Controllers\RideRequestController::class, 'requestRide'])->middleware('throttle:10,1');
Route::post('/api/rides/{ride}/accept', [App\Http\Controllers\RideRequestController::class, 'acceptRide'])->middleware('throttle:20,1');
Route::post('/api/rides/{ride}/decline', [App\Http\Controllers\RideRequestController::class, 'declineRide'])->middleware('throttle:20,1');
Route::post('/api/rides/{ride}/status', [App\Http\Controllers\RideRequestController::class, 'updateStatus'])->middleware('throttle:60,1');
Route::post('/api/driver/location', [App\Http\Controllers\RideRequestController::class, 'updateDriverLocation'])->middleware('throttle:120,1');

// Public Ride Routes (Guest Booking & Tracking)
Route::get('/rides/create', [RideController::class, 'create'])->name('rides.create');
Route::post('/rides', [RideController::class, 'store'])->name('rides.store')->middleware('throttle:10,1');
Route::post('/rides/calculate-fare', [RideController::class, 'calculateFare'])->name('rides.calculate-fare')->middleware('throttle:30,1');
Route::get('/rides/{ride}', [RideController::class, 'show'])->name('rides.show');
Route::get('/rides/{ride}/location', [App\Http\Controllers\LocationController::class, 'getRiderLocation'])->name('rides.location')->middleware('throttle:60,1');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/rides', [RideController::class, 'index'])->name('rides.index');
    
    Route::post('/logout', function () {
        auth()->logout();
        return redirect('/');
    })->name('logout');

    // Rider Only Routes
        Route::middleware(['role:rider'])->group(function () {
            Route::get('/rider/apply', [RiderController::class, 'apply'])->name('rider.apply');
            Route::post('/rider/apply', [RiderController::class, 'store'])->name('rider.store');
            Route::post('/rider/toggle', [RiderController::class, 'toggleStatus'])->name('rider.toggle')->middleware('throttle:10,1');
            
            Route::post('/rides/{ride}/accept', [RideController::class, 'accept'])->name('rides.accept')->middleware('throttle:20,1');
            Route::post('/rides/{ride}/decline', [RideController::class, 'decline'])->name('rides.decline');
            Route::post('/rides/{ride}/start', [RideController::class, 'start'])->name('rides.start');
            Route::post('/rides/{ride}/complete', [RideController::class, 'complete'])->name('rides.complete');
            Route::post('/location/update', [App\Http\Controllers\LocationController::class, 'update'])->name('location.update')->middleware('throttle:60,1');
    });

    Route::post('/rides/{ride}/cancel', [RideController::class, 'cancel'])->name('rides.cancel');

    // Rating Routes
    Route::get('/rides/{ride}/rate', [App\Http\Controllers\RatingController::class, 'create'])->name('ratings.create');
    Route::post('/rides/{ride}/rate', [App\Http\Controllers\RatingController::class, 'store'])->name('ratings.store');

    // Admin Routes
    Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/riders', [AdminController::class, 'riders'])->name('riders');
        Route::get('/riders/{rider}', [AdminController::class, 'showRider'])->name('riders.show');
        Route::get('/riders/{rider}/edit', [AdminController::class, 'editRider'])->name('riders.edit');
        Route::put('/riders/{rider}', [AdminController::class, 'updateRider'])->name('riders.update');

        // Destructive rider actions (require password confirmation)
        Route::middleware(['password.confirm'])->group(function () {
            Route::post('/rider/{rider}/approve', [AdminController::class, 'approveRider'])->name('rider.approve');
            Route::post('/rider/{rider}/reject', [AdminController::class, 'rejectRider'])->name('rider.reject');
            Route::post('/rider/{rider}/suspend', [AdminController::class, 'suspendRider'])->name('rider.suspend');
            Route::post('/rider/{rider}/activate', [AdminController::class, 'activateRider'])->name('rider.activate');
            Route::delete('/rider/{rider}', [AdminController::class, 'deleteRider'])->name('rider.delete');

            // Destructive ride actions
            Route::post('/ride/{ride}/cancel', [AdminController::class, 'cancelRide'])->name('ride.cancel');
            Route::delete('/ride/{ride}', [AdminController::class, 'deleteRide'])->name('ride.delete');

            // Client (Passenger) Management
            Route::post('/client/{user}/suspend', [AdminController::class, 'suspendClient'])->name('client.suspend');
            Route::post('/client/{user}/activate', [AdminController::class, 'activateClient'])->name('client.activate');
            Route::delete('/client/{user}', [AdminController::class, 'deleteClient'])->name('client.delete');

            // System settings
            Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
            Route::post('/settings', [AdminController::class, 'saveSettings'])->name('settings.save');
            Route::post('/settings/flush-cache', [AdminController::class, 'flushCache'])->name('settings.flush-cache');
        });

        // Client read/update routes (no password confirm needed)
        Route::get('/clients', [AdminController::class, 'clients'])->name('clients');
        Route::get('/clients/{user}', [AdminController::class, 'showClient'])->name('clients.show');
        Route::get('/clients/{user}/edit', [AdminController::class, 'editClient'])->name('clients.edit');
        Route::put('/clients/{user}', [AdminController::class, 'updateClient'])->name('clients.update');

        // Rides Management
        Route::get('/rides', [AdminController::class, 'rides'])->name('rides');
        Route::get('/rides/{ride}', [AdminController::class, 'showRide'])->name('rides.show');

        Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
        Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    });
});
