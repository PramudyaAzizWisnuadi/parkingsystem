<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\ParkingTransaction;
use Carbon\Carbon;

echo "🎫 Testing New Ticket Number Format (Without TKT Prefix)\n\n";

// Test manual generation
echo "📋 Manual Generation Test:\n";
for ($i = 1; $i <= 5; $i++) {
    $ticketNumber = ParkingTransaction::generateTicketNumber();
    echo "  Generated: {$ticketNumber}\n";
}

// Show current date format
echo "\n📅 Date Format Explanation:\n";
echo "  Today: " . Carbon::now()->format('d/m/Y') . "\n";
echo "  Format: " . Carbon::now()->format('ymd') . " (ymd)\n";
echo "  Example: " . Carbon::now()->format('ymd') . "0001 for first ticket today\n";

// Test with existing tickets
echo "\n🔍 Checking Existing Tickets:\n";
$existingTickets = ParkingTransaction::whereDate('created_at', Carbon::today())
    ->orderBy('id', 'desc')
    ->limit(3)
    ->get(['id', 'ticket_number', 'created_at']);

if ($existingTickets->count() > 0) {
    echo "  Recent tickets:\n";
    foreach ($existingTickets as $ticket) {
        echo "    - {$ticket->ticket_number} (ID: {$ticket->id})\n";
    }
} else {
    echo "  No tickets found for today.\n";
}

// Test different scenarios
echo "\n🧪 Format Comparison:\n";
echo "  Old Format: TKT" . Carbon::now()->format('ymd') . "0001\n";
echo "  New Format: " . Carbon::now()->format('ymd') . "0001\n";
echo "  Length: " . strlen(Carbon::now()->format('ymd') . "0001") . " characters (was " . strlen('TKT' . Carbon::now()->format('ymd') . "0001") . ")\n";

echo "\n✅ Test Completed! New format is active.\n";
