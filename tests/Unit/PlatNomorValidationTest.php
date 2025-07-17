<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\ParkingTransaction;
use App\Http\Requests\StoreParkingTransactionRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;

class PlatNomorValidationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_validasi_plat_nomor_indonesia_format_benar()
    {
        // Test format plat nomor Indonesia yang benar
        $validPlates = [
            'B 1234 ABC',  // Mobil Jakarta
            'B 1234 AB',   // Motor Jakarta
            'D 5678 XYZ',  // Mobil Bandung
            'D 5678 XY',   // Motor Bandung
            'L 9999 AAA',  // Mobil Surabaya
            'L 9999 AA',   // Motor Surabaya
        ];

        foreach ($validPlates as $plate) {
            $this->assertTrue(
                ParkingTransaction::validateLicensePlate($plate),
                "Plat nomor '{$plate}' seharusnya valid"
            );
        }
    }

    /** @test */
    public function test_validasi_plat_nomor_indonesia_format_salah()
    {
        // Test format plat nomor Indonesia yang salah
        $invalidPlates = [
            'B 1234',      // Tidak ada huruf belakang
            'B1234ABC',    // Tidak ada spasi
            'B 1234 ABCD', // Terlalu banyak huruf belakang
            '1234 ABC',    // Tidak ada huruf depan
            'B  1234 ABC', // Spasi ganda
            'B 1234  ABC', // Spasi ganda
        ];

        foreach ($invalidPlates as $plate) {
            $this->assertFalse(
                ParkingTransaction::validateLicensePlate($plate),
                "Plat nomor '{$plate}' seharusnya tidak valid"
            );
        }
    }

    /** @test */
    public function test_format_plat_nomor_indonesia()
    {
        $testCases = [
            'b1234abc' => 'B 1234 ABC',
            'b 1234 abc' => 'B 1234 ABC',
            'B1234ABC' => 'B 1234 ABC',
            'd5678xy' => 'D 5678 XY',
            'l9999aaa' => 'L 9999 AAA',
        ];

        foreach ($testCases as $input => $expected) {
            $result = ParkingTransaction::formatLicensePlate($input);
            $this->assertEquals(
                $expected,
                $result,
                "Format plat nomor '{$input}' seharusnya menjadi '{$expected}'"
            );
        }
    }

    /** @test */
    public function test_validasi_bahasa_indonesia_messages()
    {
        $data = [
            'license_plate' => '', // Kosong
            'vehicle_type_id' => '', // Kosong
            'notes' => ''
        ];

        $request = new StoreParkingTransactionRequest();
        $validator = Validator::make($data, $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());

        $errors = $validator->errors()->toArray();

        // Cek pesan error dalam bahasa Indonesia
        $this->assertStringContainsString('wajib diisi', $errors['license_plate'][0]);
        $this->assertStringContainsString('wajib dipilih', $errors['vehicle_type_id'][0]);
    }
}
