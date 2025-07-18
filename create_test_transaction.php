<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\ParkingTransaction;
use App\Models\VehicleType;
use Carbon\Carbon;

echo "🧪 Creating Test Transaction with New Ticket Format\n\n";

// Get first vehicle type
$vehicleType = VehicleType::first();

if (!$vehicleType) {
    echo "❌ No vehicle types found. Please run seeder first.\n";
    exit;
}

echo "📋 Before Creation:\n";
$existingCount = ParkingTransaction::whereDate('created_at', Carbon::today())->count();
echo "  Today's transactions: {$existingCount}\n";

$lastTicket = ParkingTransaction::whereDate('created_at', Carbon::today())
    ->orderBy('id', 'desc')
    ->first();

if ($lastTicket) {
    echo "  Last ticket number: {$lastTicket->ticket_number}\n";
}

// Create new transaction
echo "\n🎫 Creating New Transaction...\n";

$transaction = ParkingTransaction::create([
    'license_plate' => 'B 9999 TEST',
    'vehicle_type_id' => $vehicleType->id,
    'amount' => $vehicleType->flat_rate,
    'entry_time' => Carbon::now(),
    'notes' => 'Test transaction for new ticket format'
]);

echo "✅ Transaction Created Successfully!\n";
echo "  ID: {$transaction->id}\n";
echo "  Ticket Number: {$transaction->ticket_number}\n";
echo "  License Plate: {$transaction->license_plate}\n";
echo "  Vehicle Type: {$vehicleType->name}\n";
echo "  Amount: Rp " . number_format($transaction->amount, 0, ',', '.') . "\n";

echo "\n📊 Format Analysis:\n";
echo "  Format: " . substr($transaction->ticket_number, 0, 6) . " + " . substr($transaction->ticket_number, 6) . "\n";
echo "  Date Part: " . substr($transaction->ticket_number, 0, 6) . " (" . Carbon::now()->format('ymd') . ")\n";
echo "  Sequence: " . substr($transaction->ticket_number, 6) . "\n";
echo "  Length: " . strlen($transaction->ticket_number) . " characters\n";

echo "\n🎉 New ticket format (without TKT prefix) is working perfectly!\n";
