<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    protected $fillable = [
        'name',
        'flat_rate',
        'is_active'
    ];

    protected $casts = [
        'flat_rate' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    public function parkingTransactions()
    {
        return $this->hasMany(ParkingTransaction::class);
    }
}
