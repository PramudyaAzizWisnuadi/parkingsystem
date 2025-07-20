<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('parking_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique(); // Nomor tiket parkir
            $table->string('license_plate')->nullable(); // Plat nomor kendaraan (opsional)
            $table->foreignId('vehicle_type_id')->constrained('vehicle_types');
            $table->decimal('amount', 10, 2); // Jumlah yang dibayar
            $table->timestamp('entry_time'); // Waktu masuk
            $table->string('operator')->nullable(); // Operator yang melayani
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parking_transactions');
    }
};
