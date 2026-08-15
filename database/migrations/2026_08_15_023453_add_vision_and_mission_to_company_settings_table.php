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
        Schema::table('company_settings', function (Blueprint $table) {
            $table->text('vision_id')->nullable()->after('history_timeline');
            $table->text('vision_en')->nullable()->after('vision_id');
            $table->json('mission_id')->nullable()->after('vision_en');
            $table->json('mission_en')->nullable()->after('mission_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->dropColumn(['vision_id', 'vision_en', 'mission_id', 'mission_en']);
        });
    }
};
