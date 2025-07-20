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
        try {
            $vehicleType = VehicleType::find($request->vehicle_type_id);

            if (!$vehicleType) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Jenis kendaraan tidak ditemukan.'
                    ], 400);
                }
                return redirect()->back()->withErrors(['vehicle_type_id' => 'Jenis kendaraan tidak ditemukan.']);
            }

            $transaction = ParkingTransaction::create([
                'license_plate' => $request->license_plate ? ParkingTransaction::formatLicensePlate($request->license_plate) : null,
                'vehicle_type_id' => $request->vehicle_type_id,
                'amount' => $vehicleType->flat_rate,
                'entry_time' => Carbon::now(),
                'notes' => $request->notes
            ]);

            // Check if request is AJAX for auto print
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Transaksi parkir berhasil dibuat. Tiket nomor: ' . $transaction->ticket_number,
                    'ticket_id' => $transaction->id,
                    'ticket_number' => $transaction->ticket_number,
                    'print_url' => route('parking.print', $transaction->id)
                ]);
            }

            // Redirect to print page with auto-print (fallback for non-AJAX)
            return redirect()->route('parking.print', $transaction->id)
                ->with('success', 'Transaksi parkir berhasil dibuat. Tiket nomor: ' . $transaction->ticket_number)
                ->with('auto_print', true);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat memproses transaksi: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat memproses transaksi.']);
        }
    }

    public function show(ParkingTransaction $parking)
    {
        return view('parking.show', compact('parking'));
    }

    public function printTicket(ParkingTransaction $parking, Request $request)
    {
        $isCopy = $request->has('copy') || $request->get('copy', false);
        $view = view('parking.ticket', compact('parking', 'isCopy'));

        // If download parameter is present, return as downloadable HTML
        if ($request->has('download')) {
            $html = $view->render();

            return response($html)
                ->header('Content-Type', 'text/html')
                ->header('Content-Disposition', 'attachment; filename="tiket-' . $parking->ticket_number . '.html"')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        }

        return $view;
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
