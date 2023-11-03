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
        Schema::create('pharmacy_addresses', function (Blueprint $table) {
            $table->id();
            $table->char('pharmacy_id', 36)->index();
            $table->text('address');
            $table->decimal('latitude', 9, 7);
            $table->decimal('longitude', 9, 7);
            $table->timestamps();
            $table->foreign('pharmacy_id')->references('id')->on('pharmacies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pharmacy_addresses');
    }
};
