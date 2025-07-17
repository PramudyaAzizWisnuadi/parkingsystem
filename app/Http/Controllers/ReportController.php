<?php

namespace App\Http\Controllers;

use App\Models\ParkingTransaction;
use App\Models\VehicleType;
use App\Exports\ParkingReportExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $vehicleTypes = VehicleType::all();
        return view('reports.index', compact('vehicleTypes'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'vehicle_type_id' => 'nullable|exists:vehicle_types,id'
        ]);

        $query = ParkingTransaction::with('vehicleType')
            ->whereBetween('entry_time', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);

        if ($request->vehicle_type_id) {
            $query->where('vehicle_type_id', $request->vehicle_type_id);
        }

        $transactions = $query->orderBy('entry_time', 'desc')->get();

        $summary = [
            'total_transactions' => $transactions->count(),
            'total_revenue' => $transactions->sum('amount'),
            'by_vehicle_type' => $transactions->groupBy('vehicleType.name')
                ->map(function ($group) {
                    return [
                        'count' => $group->count(),
                        'revenue' => $group->sum('amount')
                    ];
                })
        ];

        return view('reports.result', compact('transactions', 'summary', 'request'));
    }

    public function export(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'vehicle_type_id' => 'nullable|exists:vehicle_types,id'
        ]);

        $query = ParkingTransaction::with('vehicleType')
            ->whereBetween('entry_time', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);

        if ($request->vehicle_type_id) {
            $query->where('vehicle_type_id', $request->vehicle_type_id);
        }

        $transactions = $query->orderBy('entry_time', 'desc')->get();

        return Excel::download(
            new ParkingReportExport($transactions),
            'laporan_parkir_' . Carbon::parse($request->start_date)->format('Y-m-d') . '_' .
                Carbon::parse($request->end_date)->format('Y-m-d') . '.xlsx'
        );
    }
}
