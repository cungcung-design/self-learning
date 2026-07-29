<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adventure_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('adventure_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('image');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_cover')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adventure_images');
    }
};
