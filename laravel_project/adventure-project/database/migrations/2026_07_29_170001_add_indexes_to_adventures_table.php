<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('adventures', function (Blueprint $table) {
            $table->index('title');
            $table->index('category_id');
            $table->index('price');
            $table->index('location');
        });
    }

    public function down(): void
    {
        Schema::table('adventures', function (Blueprint $table) {
            $table->dropIndex(['title']);
            $table->dropIndex(['category_id']);
            $table->dropIndex(['price']);
            $table->dropIndex(['location']);
        });
    }
};
