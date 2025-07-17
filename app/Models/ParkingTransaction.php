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
        $prefix = 'TKT';
        $date = Carbon::now()->format('ymd');
        $lastTransaction = self::whereDate('created_at', Carbon::today())
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $lastTransaction ?
            intval(substr($lastTransaction->ticket_number, -4)) + 1 : 1;

        return $prefix . $date . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }
}
