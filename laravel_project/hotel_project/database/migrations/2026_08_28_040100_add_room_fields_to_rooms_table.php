<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->unsignedBigInteger('hotel_id')->nullable()->after('id');
            $table->integer('max_guests')->nullable()->after('room_price');
            $table->integer('beds')->nullable()->after('max_guests');
            $table->string('bed_type')->nullable()->after('beds');
            $table->string('room_size')->nullable()->after('bed_type');
            $table->boolean('is_available')->default(true)->after('room_size');
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->foreign('hotel_id')->references('id')->on('hotels')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropForeign(['hotel_id']);
            $table->dropColumn(['hotel_id', 'max_guests', 'beds', 'bed_type', 'room_size', 'is_available']);
        });
    }
};
