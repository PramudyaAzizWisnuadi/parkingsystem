<?php

namespace Database\Seeders;

use App\Models\ParkingTransaction;
use App\Models\VehicleType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ParkingTransactionSeeder extends Seeder
{
    /**
     * Generate realistic Indonesian license plate
     */
    private function generateLicensePlate($vehicleType = null)
    {
        // Kode wilayah yang umum di Indonesia
        $areaCodes = ['B', 'D', 'F', 'A', 'T', 'E', 'H', 'L', 'N', 'R', 'S', 'W', 'Z'];

        // Pilih kode area random
        $areaCode = $areaCodes[array_rand($areaCodes)];

        // Generate nomor (1-4 digit)
        $number = rand(1, 9999);

        // Generate huruf suffix
        if ($vehicleType && $vehicleType->name === 'Motor') {
            // Motor biasanya 1-2 huruf
            $suffixLength = rand(1, 2);
        } else {
            // Mobil, truk, bus biasanya 1-3 huruf
            $suffixLength = rand(1, 3);
        }

        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $suffix = '';
        for ($i = 0; $i < $suffixLength; $i++) {
            $suffix .= $letters[rand(0, 25)];
        }

        return $areaCode . ' ' . $number . ' ' . $suffix;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicleTypes = VehicleType::all();

        if ($vehicleTypes->isEmpty()) {
            $this->command->info('No vehicle types found. Please run VehicleTypeSeeder first.');
            return;
        }

        for ($day = 29; $day >= 0; $day--) {
            $date = Carbon::now()->subDays($day);

            // Generate random number of transactions per day (5-25)
            $transactionsPerDay = rand(5, 25);

            // Track used plates for this day to avoid duplicates
            $usedPlates = [];

            for ($i = 0; $i < $transactionsPerDay; $i++) {
                $vehicleType = $vehicleTypes->random();

                // Generate unique license plate for this day
                do {
                    $licensePlate = $this->generateLicensePlate($vehicleType);
                } while (in_array($licensePlate, $usedPlates));

                $usedPlates[] = $licensePlate;

                // Random time during the day
                $entryTime = $date->copy()->addHours(rand(6, 22))->addMinutes(rand(0, 59));

                ParkingTransaction::create([
                    'license_plate' => $licensePlate,
                    'vehicle_type_id' => $vehicleType->id,
                    'amount' => $vehicleType->flat_rate,
                    'entry_time' => $entryTime,
                    'notes' => rand(0, 10) > 7 ? 'Catatan: Kendaraan parkir lama' : null
                ]);
            }
        }

        $this->command->info('Sample parking transactions created successfully.');
    }
}
