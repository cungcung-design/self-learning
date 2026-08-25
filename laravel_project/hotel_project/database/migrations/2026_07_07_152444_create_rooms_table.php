<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_name');
            $table->string('room_image')->nullable();
            $table->text('room_description')->nullable();
            $table->decimal('room_price', 10, 2)->default(0);
            $table->string('room_wifi')->default('no');
            $table->string('room_type')->default('regular');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
