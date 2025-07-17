<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleTypeController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TicketConfigController;
use App\Http\Controllers\ChartController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Test error pages (remove these in production)
Route::get('/test-403', function () {
    abort(403);
});

Route::get('/test-404', function () {
    abort(404);
});

Route::get('/test-500', function () {
    abort(500);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [ParkingController::class, 'dashboard'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes untuk semua user yang login (admin dan petugas)
    Route::get('/parking', [ParkingController::class, 'index'])->name('parking.index');
    Route::get('/parking/create', [ParkingController::class, 'create'])->name('parking.create');
    Route::post('/parking', [ParkingController::class, 'store'])->name('parking.store');
    Route::get('/parking/{parking}', [ParkingController::class, 'show'])->name('parking.show');
    Route::get('/parking/{parking}/print', [ParkingController::class, 'printTicket'])->name('parking.print');

    // Routes khusus untuk admin
    Route::middleware('role:admin')->group(function () {
        // Vehicle Types Routes
        Route::resource('vehicle-types', VehicleTypeController::class);

        // Reports Routes
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::post('/reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
        Route::post('/reports/export', [ReportController::class, 'export'])->name('reports.export');

        // Ticket Configuration Routes
        Route::get('/ticket-config', [TicketConfigController::class, 'index'])->name('ticket-config.index');
        Route::put('/ticket-config', [TicketConfigController::class, 'update'])->name('ticket-config.update');

        // Chart Data API Routes
        Route::get('/api/chart-data/vehicle-types', [ChartController::class, 'vehicleTypeDistribution']);
        Route::get('/api/chart-data/revenue-weekly', [ChartController::class, 'weeklyRevenue']);
        Route::get('/api/chart-data/daily-transactions', [ChartController::class, 'dailyTransactions']);
        Route::get('/api/chart-data/monthly-revenue', [ChartController::class, 'monthlyRevenue']);
        Route::get('/api/chart-data/hourly-distribution', [ChartController::class, 'hourlyDistribution']);
        Route::get('/api/chart-data/top-vehicle-types', [ChartController::class, 'topVehicleTypes']);
    });
});

require __DIR__ . '/auth.php';
