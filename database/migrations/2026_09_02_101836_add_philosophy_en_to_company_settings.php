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
            if (!Schema::hasColumn('company_settings', 'philosophy_build_en')) {
                $table->text('philosophy_build_en')->nullable();
            }
            if (!Schema::hasColumn('company_settings', 'philosophy_grow_en')) {
                $table->text('philosophy_grow_en')->nullable();
            }
            if (!Schema::hasColumn('company_settings', 'philosophy_scale_en')) {
                $table->text('philosophy_scale_en')->nullable();
            }
            if (!Schema::hasColumn('company_settings', 'philosophy_empower_en')) {
                $table->text('philosophy_empower_en')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->dropColumn(['philosophy_build_en', 'philosophy_grow_en', 'philosophy_scale_en', 'philosophy_empower_en']);
        });
    }
};
