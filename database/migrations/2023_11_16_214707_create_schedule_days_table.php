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
        Schema::create('schedule_days', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('day_id');
            $table->uuid('schedule_id');
            $table->foreign('day_id')->references('id')
                ->on('days')->onDelete('cascade');
            $table->foreign('schedule_id')->references('id')
                ->on('schedules')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_days');
    }
};
