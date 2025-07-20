<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ParkingApiController;
use App\Http\Controllers\Api\VehicleTypeApiController;

/*
|--------------------------------------------------------------------------
| API Routes for Mobile App
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    // Health check
    Route::get('/health', function () {
        return response()->json([
            'status' => 'success',
            'message' => 'API is running',
            'timestamp' => now(),
            'version' => 'v1'
        ]);
    });
    
    // Public routes
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    
    // Demo routes (for testing without auth)
    Route::get('/demo/vehicle-types', [VehicleTypeApiController::class, 'demo']);
    Route::post('/demo/parking', [ParkingApiController::class, 'demoStore']);
    
    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        // User management
        Route::get('/user', [AuthController::class, 'user']);
        Route::post('/logout', [AuthController::class, 'logout']);
        
        // Vehicle Types
        Route::apiResource('vehicle-types', VehicleTypeApiController::class);
        
        // Parking Operations
        Route::prefix('parking')->group(function () {
            Route::get('/', [ParkingApiController::class, 'index']);
            Route::post('/', [ParkingApiController::class, 'store']);
            Route::get('/{parking}', [ParkingApiController::class, 'show']);
            Route::put('/{parking}', [ParkingApiController::class, 'update']);
            Route::delete('/{parking}', [ParkingApiController::class, 'destroy']);
            Route::get('/{parking}/print', [ParkingApiController::class, 'print']);
        });
        
        // Statistics & Reports
        Route::get('/stats', [ParkingApiController::class, 'stats']);
        Route::get('/reports/daily', [ParkingApiController::class, 'dailyReport']);
        Route::get('/reports/monthly', [ParkingApiController::class, 'monthlyReport']);
        
        // Data synchronization
        Route::post('/sync', [ParkingApiController::class, 'sync']);
        Route::get('/sync/status', [ParkingApiController::class, 'syncStatus']);
    });
});

// Health check endpoint
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now(),
        'version' => '1.0.0'
    ]);
});
