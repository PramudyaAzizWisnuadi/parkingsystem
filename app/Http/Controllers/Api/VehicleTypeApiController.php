<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VehicleType;
use Illuminate\Http\Request;

class VehicleTypeApiController extends Controller
{
    /**
     * Get all vehicle types
     */
    public function index()
    {
        try {
            $vehicleTypes = VehicleType::where('is_active', true)
                ->orderBy('name')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Vehicle types retrieved successfully',
                'data' => $vehicleTypes->map(function ($type) {
                    return [
                        'id' => $type->id,
                        'name' => $type->name,
                        'flat_rate' => $type->flat_rate, // Keep for web compatibility
                        'rate' => $type->flat_rate, // Add for mobile compatibility
                        'formatted_rate' => 'Rp ' . number_format($type->flat_rate, 0, ',', '.'),
                        'is_active' => $type->is_active,
                        'created_at' => $type->created_at,
                        'updated_at' => $type->updated_at,
                    ];
                }),
                'total' => $vehicleTypes->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve vehicle types: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get specific vehicle type
     */
    public function show($id)
    {
        try {
            $vehicleType = VehicleType::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Vehicle type retrieved successfully',
                'data' => [
                    'id' => $vehicleType->id,
                    'name' => $vehicleType->name,
                    'flat_rate' => $vehicleType->flat_rate, // Keep for web compatibility
                    'rate' => $vehicleType->flat_rate, // Add for mobile compatibility
                    'formatted_rate' => 'Rp ' . number_format($vehicleType->flat_rate, 0, ',', '.'),
                    'is_active' => $vehicleType->is_active,
                    'created_at' => $vehicleType->created_at,
                    'updated_at' => $vehicleType->updated_at,
                ]
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Vehicle type not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve vehicle type: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Demo endpoint (no auth required)
     */
    public function demo()
    {
        try {
            // Return static demo data for testing
            $demoData = [
                [
                    'id' => 1,
                    'name' => 'Motor',
                    'flat_rate' => 2000, // Keep for web compatibility
                    'rate' => 2000, // Add for mobile compatibility
                    'formatted_rate' => 'Rp 2.000',
                    'is_active' => true,
                ],
                [
                    'id' => 2,
                    'name' => 'Mobil',
                    'flat_rate' => 5000, // Keep for web compatibility
                    'rate' => 5000, // Add for mobile compatibility
                    'formatted_rate' => 'Rp 5.000',
                    'is_active' => true,
                ],
                [
                    'id' => 3,
                    'name' => 'Truk',
                    'flat_rate' => 10000, // Keep for web compatibility
                    'rate' => 10000, // Add for mobile compatibility
                    'formatted_rate' => 'Rp 10.000',
                    'is_active' => true,
                ]
            ];

            return response()->json([
                'success' => true,
                'message' => 'Demo vehicle types retrieved successfully',
                'data' => $demoData,
                'total' => count($demoData),
                'note' => 'This is demo data for testing purposes'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve demo data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create new vehicle type (admin only)
     */
    public function store(Request $request)
    {
        try {
            // Check if user is admin
            if ($request->user()->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Admin access required.'
                ], 403);
            }

            $request->validate([
                'name' => 'required|string|max:255|unique:vehicle_types',
                'flat_rate' => 'required|numeric|min:0',
                'is_active' => 'boolean',
            ]);

            $vehicleType = VehicleType::create([
                'name' => $request->name,
                'flat_rate' => $request->flat_rate,
                'is_active' => $request->is_active ?? true,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Vehicle type created successfully',
                'data' => [
                    'id' => $vehicleType->id,
                    'name' => $vehicleType->name,
                    'flat_rate' => $vehicleType->flat_rate, // Keep for web compatibility
                    'rate' => $vehicleType->flat_rate, // Add for mobile compatibility
                    'formatted_rate' => 'Rp ' . number_format($vehicleType->flat_rate, 0, ',', '.'),
                    'is_active' => $vehicleType->is_active,
                    'created_at' => $vehicleType->created_at,
                ]
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create vehicle type: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update vehicle type (admin only)
     */
    public function update(Request $request, $id)
    {
        try {
            // Check if user is admin
            if ($request->user()->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Admin access required.'
                ], 403);
            }

            $vehicleType = VehicleType::findOrFail($id);

            $request->validate([
                'name' => 'sometimes|required|string|max:255|unique:vehicle_types,name,' . $id,
                'flat_rate' => 'sometimes|required|numeric|min:0',
                'is_active' => 'sometimes|boolean',
            ]);

            $vehicleType->update($request->only(['name', 'flat_rate', 'is_active']));

            return response()->json([
                'success' => true,
                'message' => 'Vehicle type updated successfully',
                'data' => [
                    'id' => $vehicleType->id,
                    'name' => $vehicleType->name,
                    'flat_rate' => $vehicleType->flat_rate, // Keep for web compatibility
                    'rate' => $vehicleType->flat_rate, // Add for mobile compatibility
                    'formatted_rate' => 'Rp ' . number_format($vehicleType->flat_rate, 0, ',', '.'),
                    'is_active' => $vehicleType->is_active,
                    'updated_at' => $vehicleType->updated_at,
                ]
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Vehicle type not found'
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update vehicle type: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete vehicle type (admin only)
     */
    public function destroy(Request $request, $id)
    {
        try {
            // Check if user is admin
            if ($request->user()->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Admin access required.'
                ], 403);
            }

            $vehicleType = VehicleType::findOrFail($id);

            // Check if vehicle type is being used in parking transactions
            if ($vehicleType->parkingTransactions()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete vehicle type. It is being used in parking transactions.'
                ], 400);
            }

            $vehicleType->delete();

            return response()->json([
                'success' => true,
                'message' => 'Vehicle type deleted successfully'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Vehicle type not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete vehicle type: ' . $e->getMessage()
            ], 500);
        }
    }
}
