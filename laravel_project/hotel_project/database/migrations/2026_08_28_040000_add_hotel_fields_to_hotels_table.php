<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->text('contact_info')->nullable()->after('location');
            $table->string('check_in_time')->nullable()->after('contact_info');
            $table->string('check_out_time')->nullable()->after('check_in_time');
        });
    }

    public function down(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropColumn(['contact_info', 'check_in_time', 'check_out_time']);
        });
    }
};
