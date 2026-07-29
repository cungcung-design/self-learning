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
        Schema::create('adventure_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('adventure_id')->constrained()->cascadeOnDelete();
            $table->date('trip_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedInteger('capacity');
            $table->unsignedInteger('booked')->default(0);
            $table->enum('status', ['available', 'full', 'cancelled'])->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adventure_schedules');
    }
};
