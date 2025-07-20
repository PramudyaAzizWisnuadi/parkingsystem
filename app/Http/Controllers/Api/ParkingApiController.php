<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ParkingTransaction;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ParkingApiController extends Controller
{
    /**
     * Get all parking transactions
     */
    public function index(Request $request)
    {
        try {
            $query = ParkingTransaction::with(['vehicleType', 'user'])
                ->orderBy('entry_time', 'desc');

            // Filter by date range
            if ($request->has('start_date') && $request->has('end_date')) {
                $startDate = Carbon::parse($request->start_date)->startOfDay();
                $endDate = Carbon::parse($request->end_date)->endOfDay();
                $query->whereBetween('entry_time', [$startDate, $endDate]);
            }

            // Filter by single date
            if ($request->has('date')) {
                $date = Carbon::parse($request->date);
                $query->whereDate('entry_time', $date);
            }

            // Filter by period
            if ($request->has('period')) {
                switch ($request->period) {
                    case 'today':
                        $query->whereDate('entry_time', today());
                        break;
                    case 'yesterday':
                        $query->whereDate('entry_time', now()->subDay());
                        break;
                    case 'week':
                        $query->whereBetween('entry_time', [
                            now()->startOfWeek(),
                            now()->endOfWeek()
                        ]);
                        break;
                    case 'month':
                        $query->whereMonth('entry_time', now()->month)
                              ->whereYear('entry_time', now()->year);
                        break;
                }
            }

            // Filter by license plate
            if ($request->has('license_plate')) {
                $query->where('license_plate', 'like', '%' . $request->license_plate . '%');
            }

            // Filter by vehicle type
            if ($request->has('vehicle_type_id')) {
                $query->where('vehicle_type_id', $request->vehicle_type_id);
            }

            // Pagination
            $limit = $request->input('limit', 50);
            $page = $request->input('page', 1);
            $offset = ($page - 1) * $limit;

            $total = $query->count();
            $transactions = $query->limit($limit)->offset($offset)->get();

            return response()->json([
                'success' => true,
                'message' => 'Parking transactions retrieved successfully',
                'data' => $transactions->map(function ($transaction) {
                    return $this->formatTransactionData($transaction);
                }),
                'pagination' => [
                    'total' => $total,
                    'page' => $page,
                    'limit' => $limit,
                    'pages' => ceil($total / $limit),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve parking transactions: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create new parking transaction
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'vehicle_type_id' => 'required|exists:vehicle_types,id',
                'license_plate' => 'nullable|string|max:15',
                'notes' => 'nullable|string|max:500',
            ]);

            $vehicleType = VehicleType::findOrFail($request->vehicle_type_id);

            // Generate unique ticket number
            $ticketNumber = $this->generateTicketNumber();

            // Format license plate
            $licensePlate = null;
            if ($request->license_plate) {
                $licensePlate = $this->formatLicensePlate(trim($request->license_plate));
            }

            $transaction = ParkingTransaction::create([
                'ticket_number' => $ticketNumber,
                'license_plate' => $licensePlate,
                'vehicle_type_id' => $request->vehicle_type_id,
                'amount' => $vehicleType->flat_rate,
                'entry_time' => now(),
                'notes' => $request->notes,
                'user_id' => $request->user()->id,
            ]);

            $transaction->load(['vehicleType', 'user']);

            return response()->json([
                'success' => true,
                'message' => 'Parking transaction created successfully',
                'data' => $this->formatTransactionData($transaction),
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
                'message' => 'Failed to create parking transaction: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get specific parking transaction
     */
    public function show($id)
    {
        try {
            $transaction = ParkingTransaction::with(['vehicleType', 'user'])
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Parking transaction retrieved successfully',
                'data' => $this->formatTransactionData($transaction),
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Parking transaction not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve parking transaction: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update parking transaction
     */
    public function update(Request $request, $id)
    {
        try {
            $transaction = ParkingTransaction::findOrFail($id);

            // Check permission (admin or transaction owner)
            if ($request->user()->role !== 'admin' && $transaction->user_id !== $request->user()->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to update this transaction'
                ], 403);
            }

            $request->validate([
                'license_plate' => 'nullable|string|max:15',
                'notes' => 'nullable|string|max:500',
            ]);

            $updateData = [];
            
            if ($request->has('license_plate')) {
                $updateData['license_plate'] = $request->license_plate ? 
                    $this->formatLicensePlate(trim($request->license_plate)) : null;
            }
            
            if ($request->has('notes')) {
                $updateData['notes'] = $request->notes;
            }

            $transaction->update($updateData);
            $transaction->load(['vehicleType', 'user']);

            return response()->json([
                'success' => true,
                'message' => 'Parking transaction updated successfully',
                'data' => $this->formatTransactionData($transaction),
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Parking transaction not found'
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
                'message' => 'Failed to update parking transaction: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete parking transaction
     */
    public function destroy(Request $request, $id)
    {
        try {
            $transaction = ParkingTransaction::findOrFail($id);

            // Check permission (admin only)
            if ($request->user()->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Admin access required.'
                ], 403);
            }

            $transaction->delete();

            return response()->json([
                'success' => true,
                'message' => 'Parking transaction deleted successfully'
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Parking transaction not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete parking transaction: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get print data for parking transaction
     */
    public function print($id)
    {
        try {
            $transaction = ParkingTransaction::with(['vehicleType', 'user'])
                ->findOrFail($id);

            $printData = [
                'ticket_number' => $transaction->ticket_number,
                'license_plate' => $transaction->license_plate,
                'vehicle_type' => $transaction->vehicleType->name,
                'amount' => $transaction->amount,
                'formatted_amount' => 'Rp ' . number_format($transaction->amount, 0, ',', '.'),
                'entry_time' => $transaction->entry_time->format('d/m/Y H:i:s'),
                'entry_date' => $transaction->entry_time->format('d/m/Y'),
                'entry_time_only' => $transaction->entry_time->format('H:i'),
                'notes' => $transaction->notes,
                'operator' => $transaction->user->name ?? 'System',
                'location' => config('app.name', 'Parkir System'),
                'print_time' => now()->format('d/m/Y H:i:s'),
            ];

            return response()->json([
                'success' => true,
                'message' => 'Print data retrieved successfully',
                'data' => $printData,
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Parking transaction not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get print data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get statistics
     */
    public function stats(Request $request)
    {
        try {
            $period = $request->input('period', 'today');
            $query = ParkingTransaction::query();

            switch ($period) {
                case 'today':
                    $query->whereDate('entry_time', today());
                    $periodLabel = 'Hari Ini';
                    break;
                case 'yesterday':
                    $query->whereDate('entry_time', now()->subDay());
                    $periodLabel = 'Kemarin';
                    break;
                case 'week':
                    $query->whereBetween('entry_time', [
                        now()->startOfWeek(),
                        now()->endOfWeek()
                    ]);
                    $periodLabel = 'Minggu Ini';
                    break;
                case 'month':
                    $query->whereMonth('entry_time', now()->month)
                          ->whereYear('entry_time', now()->year);
                    $periodLabel = 'Bulan Ini';
                    break;
                case 'all':
                    $periodLabel = 'Semua';
                    break;
            }

            $totalTransactions = $query->count();
            $totalRevenue = $query->sum('amount');

            // Vehicle type breakdown
            $vehicleStats = $query->select('vehicle_type_id')
                ->selectRaw('COUNT(*) as count')
                ->selectRaw('SUM(amount) as revenue')
                ->with('vehicleType')
                ->groupBy('vehicle_type_id')
                ->get()
                ->map(function ($stat) {
                    return [
                        'vehicle_type' => $stat->vehicleType->name ?? 'Unknown',
                        'count' => $stat->count,
                        'revenue' => $stat->revenue,
                        'formatted_revenue' => 'Rp ' . number_format($stat->revenue, 0, ',', '.'),
                    ];
                });

            return response()->json([
                'success' => true,
                'message' => 'Statistics retrieved successfully',
                'data' => [
                    'period' => $period,
                    'period_label' => $periodLabel,
                    'total_transactions' => $totalTransactions,
                    'total_revenue' => $totalRevenue,
                    'formatted_revenue' => 'Rp ' . number_format($totalRevenue, 0, ',', '.'),
                    'average_per_transaction' => $totalTransactions > 0 ? round($totalRevenue / $totalTransactions) : 0,
                    'vehicle_breakdown' => $vehicleStats,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve statistics: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Demo store (no auth required)
     */
    public function demoStore(Request $request)
    {
        try {
            $request->validate([
                'vehicle_type_id' => 'required|integer|in:1,2,3',
                'license_plate' => 'nullable|string|max:15',
                'notes' => 'nullable|string|max:500',
            ]);

            // Demo vehicle types
            $vehicleTypes = [
                1 => ['name' => 'Motor', 'rate' => 2000],
                2 => ['name' => 'Mobil', 'rate' => 5000],
                3 => ['name' => 'Truk', 'rate' => 10000],
            ];

            $vehicleType = $vehicleTypes[$request->vehicle_type_id];
            $ticketNumber = 'DEMO' . date('ymdHis');

            $demoTransaction = [
                'id' => rand(1000, 9999),
                'ticket_number' => $ticketNumber,
                'license_plate' => $request->license_plate ? strtoupper(trim($request->license_plate)) : null,
                'vehicle_type' => [
                    'id' => $request->vehicle_type_id,
                    'name' => $vehicleType['name'],
                    'rate' => $vehicleType['rate'],
                ],
                'amount' => $vehicleType['rate'],
                'formatted_amount' => 'Rp ' . number_format($vehicleType['rate'], 0, ',', '.'),
                'entry_time' => now()->toISOString(),
                'formatted_entry_time' => now()->format('d/m/Y H:i:s'),
                'notes' => $request->notes,
                'operator' => 'Demo User',
                'print_data' => [
                    'ticket_number' => $ticketNumber,
                    'license_plate' => $request->license_plate ? strtoupper(trim($request->license_plate)) : null,
                    'vehicle_type' => $vehicleType['name'],
                    'amount' => $vehicleType['rate'],
                    'formatted_amount' => 'Rp ' . number_format($vehicleType['rate'], 0, ',', '.'),
                    'entry_time' => now()->format('d/m/Y H:i:s'),
                    'location' => 'Demo Parking System',
                ],
            ];

            return response()->json([
                'success' => true,
                'message' => 'Demo parking transaction created successfully',
                'data' => $demoTransaction,
                'note' => 'This is demo data for testing purposes'
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
                'message' => 'Failed to create demo transaction: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate unique ticket number
     */
    private function generateTicketNumber()
    {
        $prefix = 'TK';
        $date = date('ymd');
        $counter = ParkingTransaction::whereDate('created_at', today())->count() + 1;
        
        return $prefix . $date . str_pad($counter, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Format license plate
     */
    private function formatLicensePlate($licensePlate)
    {
        return strtoupper(trim($licensePlate));
    }

    /**
     * Format transaction data for API response
     */
    private function formatTransactionData($transaction)
    {
        return [
            'id' => $transaction->id,
            'ticket_number' => $transaction->ticket_number,
            'license_plate' => $transaction->license_plate,
            'vehicle_type' => [
                'id' => $transaction->vehicleType->id,
                'name' => $transaction->vehicleType->name,
                'rate' => $transaction->vehicleType->flat_rate,
            ],
            'amount' => $transaction->amount,
            'formatted_amount' => 'Rp ' . number_format($transaction->amount, 0, ',', '.'),
            'entry_time' => $transaction->entry_time->toISOString(),
            'formatted_entry_time' => $transaction->entry_time->format('d/m/Y H:i:s'),
            'notes' => $transaction->notes,
            'operator' => $transaction->user->name ?? 'Unknown',
            'created_at' => $transaction->created_at->toISOString(),
            'updated_at' => $transaction->updated_at->toISOString(),
        ];
    }

    /**
     * Sync functionality for offline app
     */
    public function sync(Request $request)
    {
        try {
            $lastSyncTime = $request->input('last_sync_time');
            
            $query = ParkingTransaction::with(['vehicleType', 'user'])
                ->orderBy('updated_at', 'desc');
            
            if ($lastSyncTime) {
                $query->where('updated_at', '>', Carbon::parse($lastSyncTime));
            }
            
            $transactions = $query->limit(100)->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Data synchronized successfully',
                'sync_time' => now()->toISOString(),
                'data' => $transactions->map(function ($transaction) {
                    return $this->formatTransactionData($transaction);
                }),
                'total' => $transactions->count(),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Sync failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get sync status
     */
    public function syncStatus()
    {
        try {
            $lastTransaction = ParkingTransaction::latest('updated_at')->first();
            $totalTransactions = ParkingTransaction::count();
            $todayTransactions = ParkingTransaction::whereDate('entry_time', today())->count();

            return response()->json([
                'success' => true,
                'message' => 'Sync status retrieved successfully',
                'data' => [
                    'last_update' => $lastTransaction ? $lastTransaction->updated_at->toISOString() : null,
                    'total_transactions' => $totalTransactions,
                    'today_transactions' => $todayTransactions,
                    'server_time' => now()->toISOString(),
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get sync status: ' . $e->getMessage()
            ], 500);
        }
    }
}
