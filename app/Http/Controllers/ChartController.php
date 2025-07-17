<?php

namespace App\Http\Controllers;

use App\Models\ParkingTransaction;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ChartController extends Controller
{
    public function vehicleTypeDistribution()
    {
        // Check if user is admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $data = ParkingTransaction::select('vehicle_types.name', DB::raw('COUNT(*) as count'))
            ->join('vehicle_types', 'parking_transactions.vehicle_type_id', '=', 'vehicle_types.id')
            ->groupBy('vehicle_types.name')
            ->orderBy('count', 'desc')
            ->get();

        return response()->json([
            'labels' => $data->pluck('name'),
            'data' => $data->pluck('count')
        ]);
    }

    public function weeklyRevenue()
    {
        // Check if user is admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $days = [];
        $revenue = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $days[] = $date->format('d/m');

            $dailyRevenue = ParkingTransaction::whereDate('entry_time', $date)
                ->sum('amount');

            $revenue[] = (float) $dailyRevenue;
        }

        return response()->json([
            'labels' => $days,
            'data' => $revenue
        ]);
    }

    public function dailyTransactions()
    {
        // Check if user is admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $days = [];
        $transactions = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $days[] = $date->format('d/m');

            $dailyTransactions = ParkingTransaction::whereDate('entry_time', $date)
                ->count();

            $transactions[] = $dailyTransactions;
        }

        return response()->json([
            'labels' => $days,
            'data' => $transactions
        ]);
    }

    public function monthlyRevenue()
    {
        $months = [];
        $revenue = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M Y');

            $monthlyRevenue = ParkingTransaction::whereYear('entry_time', $date->year)
                ->whereMonth('entry_time', $date->month)
                ->sum('amount');

            $revenue[] = (float) $monthlyRevenue;
        }

        return response()->json([
            'labels' => $months,
            'data' => $revenue
        ]);
    }

    public function hourlyDistribution()
    {
        $hours = [];
        $transactions = [];

        for ($i = 0; $i < 24; $i++) {
            $hour = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
            $hours[] = $hour;

            $hourlyTransactions = ParkingTransaction::whereRaw('HOUR(entry_time) = ?', [$i])
                ->count();

            $transactions[] = $hourlyTransactions;
        }

        return response()->json([
            'labels' => $hours,
            'data' => $transactions
        ]);
    }

    public function topVehicleTypes()
    {
        $data = ParkingTransaction::select('vehicle_types.name', DB::raw('COUNT(*) as count'), DB::raw('SUM(amount) as revenue'))
            ->join('vehicle_types', 'parking_transactions.vehicle_type_id', '=', 'vehicle_types.id')
            ->groupBy('vehicle_types.name')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'labels' => $data->pluck('name'),
            'transactions' => $data->pluck('count'),
            'revenue' => $data->pluck('revenue')
        ]);
    }
}
