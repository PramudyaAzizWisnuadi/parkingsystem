<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ParkingTransaction extends Model
{
    protected $fillable = [
        'ticket_number',
        'license_plate',
        'vehicle_type_id',
        'amount',
        'entry_time',
        'notes'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'entry_time' => 'datetime'
    ];

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class);
    }

    public function getFormattedEntryTimeAttribute()
    {
        return $this->entry_time->format('d/m/Y H:i:s');
    }

    /**
     * Validate Indonesian license plate format
     */
    public static function validateLicensePlate($licensePlate)
    {
        // Return true jika license plate null atau kosong (karena opsional)
        if (empty($licensePlate) || is_null($licensePlate)) {
            return true;
        }

        // Format: [1-2 huruf] [1-4 angka] [1-3 huruf]
        // Contoh: B 1234 ABC, D 123 AB, F 12 A
        $pattern = '/^[A-Z]{1,2}\s\d{1,4}\s[A-Z]{1,3}$/';
        $formatted = self::formatLicensePlate($licensePlate);
        return preg_match($pattern, $formatted);
    }

    /**
     * Format license plate to uppercase and proper spacing
     */
    public static function formatLicensePlate($licensePlate)
    {
        // Return null jika license plate kosong
        if (empty($licensePlate) || is_null($licensePlate)) {
            return null;
        }

        // Remove all spaces and convert to uppercase
        $cleaned = strtoupper(preg_replace('/\s+/', '', trim($licensePlate)));

        // Indonesian license plate pattern: [1-2 letters][1-4 numbers][1-3 letters]
        // Extract parts using regex
        if (preg_match('/^([A-Z]{1,2})(\d{1,4})([A-Z]{1,3})$/', $cleaned, $matches)) {
            return $matches[1] . ' ' . $matches[2] . ' ' . $matches[3];
        }

        // If already formatted correctly, return as is
        $pattern = '/^[A-Z]{1,2}\s\d{1,4}\s[A-Z]{1,3}$/';
        if (preg_match($pattern, strtoupper($licensePlate))) {
            return strtoupper($licensePlate);
        }

        // If no valid pattern found, return cleaned version
        return $cleaned;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            if (!$transaction->ticket_number) {
                $transaction->ticket_number = self::generateTicketNumber();
            }
        });
    }

    public static function generateTicketNumber()
    {
        $date = Carbon::now()->format('ymd');

        // Get all tickets from today to find the highest sequence
        $todayTickets = self::whereDate('created_at', Carbon::today())
            ->pluck('ticket_number')
            ->filter(function ($ticketNumber) {
                return !empty($ticketNumber);
            });

        $maxSequence = 0;

        foreach ($todayTickets as $ticketNumber) {
            // Handle both old format (TKT250718001) and new format (250718001)
            if (str_starts_with($ticketNumber, 'TKT')) {
                // Old format: TKT + date + sequence
                $sequence = intval(substr($ticketNumber, -4));
            } else {
                // New format: date + sequence
                $sequence = intval(substr($ticketNumber, -4));
            }

            $maxSequence = max($maxSequence, $sequence);
        }

        $newSequence = $maxSequence + 1;

        return $date . str_pad($newSequence, 4, '0', STR_PAD_LEFT);
    }
}
