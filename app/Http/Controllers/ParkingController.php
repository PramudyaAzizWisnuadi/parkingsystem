<?php

namespace App\Http\Controllers;

use App\Models\ParkingTransaction;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Requests\StoreParkingTransactionRequest;

class ParkingController extends Controller
{
    public function index()
    {
        $transactions = ParkingTransaction::with('vehicleType')
            ->orderBy('entry_time', 'desc')
            ->get();

        return view('parking.index', compact('transactions'));
    }

    public function create()
    {
        $vehicleTypes = VehicleType::where('is_active', true)->get();
        return view('parking.create', compact('vehicleTypes'));
    }

    public function store(StoreParkingTransactionRequest $request)
    {
        $vehicleType = VehicleType::find($request->vehicle_type_id);

        $transaction = ParkingTransaction::create([
            'license_plate' => ParkingTransaction::formatLicensePlate($request->license_plate),
            'vehicle_type_id' => $request->vehicle_type_id,
            'amount' => $vehicleType->flat_rate,
            'entry_time' => Carbon::now(),
            'notes' => $request->notes
        ]);

        // Redirect to print page with auto-print
        return redirect()->route('parking.print', $transaction->id)
            ->with('success', 'Transaksi parkir berhasil dibuat. Tiket nomor: ' . $transaction->ticket_number)
            ->with('auto_print', true);
    }

    public function show(ParkingTransaction $parking)
    {
        return view('parking.show', compact('parking'));
    }

    public function printTicket(ParkingTransaction $parking)
    {
        return view('parking.ticket', compact('parking'));
    }
    public function dashboard()
    {
        $today = Carbon::today();

        $stats = [
            'today_transactions' => ParkingTransaction::whereDate('entry_time', $today)->count(),
            'today_revenue' => ParkingTransaction::whereDate('entry_time', $today)->sum('amount'),
        ];

        // Only show total statistics for admin users
        if (Auth::check() && Auth::user()->role === 'admin') {
            $stats['total_transactions'] = ParkingTransaction::count();
            $stats['total_revenue'] = ParkingTransaction::sum('amount');
        }

        $recentTransactions = ParkingTransaction::with('vehicleType')
            ->orderBy('entry_time', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard-parking', compact('stats', 'recentTransactions'));
    }
}
