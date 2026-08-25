<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->text('room_description')->nullable()->change();
            $table->decimal('room_price', 10, 2)->nullable()->change();
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->text('message')->change();
        });

        DB::table('bookings')->where('room_id', '')->update(['room_id' => null]);

        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('room_id')->nullable()->change();
            $table->date('start_date')->nullable()->change();
            $table->date('end_date')->nullable()->change();
        });

        try {
            Schema::table('bookings', function (Blueprint $table) {
                $table->foreign('room_id')->references('id')->on('rooms')->nullOnDelete();
            });
        } catch (Throwable) {
            // The foreign key already exists on fresh installs.
        }
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->string('room_description')->nullable()->change();
            $table->string('room_price')->nullable()->change();
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->string('message')->change();
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->string('start_date')->nullable()->change();
            $table->string('end_date')->nullable()->change();
        });
    }
};
