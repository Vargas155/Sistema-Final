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
        Schema::create('vector_simulations', function (Blueprint $table) {
            $table->id();
            $table->string('session_title')->nullable();
            $table->json('vectors_data'); // Guarda magnitud y ángulo
            $table->double('sum_fx');
            $table->double('sum_fy');
            $table->double('resultant_magnitude');
            $table->double('resultant_angle');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vector_simulations');
    }
};