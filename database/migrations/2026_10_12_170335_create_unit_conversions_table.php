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
        Schema::create('unit_conversions', function (Blueprint $table) {
            $table->id();
            $table->string('magnitude_type'); // Masa, Velocidad, Aceleración, Presión, Fuerza, etc.
            $table->string('from_unit');
            $table->string('to_unit');
            $table->double('factor_conversion', 15, 8);
            $table->string('system_origin'); // S.I. o Inglés
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_conversions');
    }
};