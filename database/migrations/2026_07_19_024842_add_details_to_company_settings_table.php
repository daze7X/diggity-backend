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
            // Legality
            $table->string('company_pt_name')->nullable()->after('linkedin_url');
            $table->string('company_nib')->nullable()->after('company_pt_name');
            $table->string('company_kbli')->nullable()->after('company_nib');

            // Philosophy
            $table->text('philosophy_build')->nullable()->after('company_kbli');
            $table->text('philosophy_grow')->nullable()->after('philosophy_build');
            $table->text('philosophy_scale')->nullable()->after('philosophy_grow');
            $table->text('philosophy_empower')->nullable()->after('philosophy_scale');

            // Partner logos & history timeline (JSON data)
            $table->text('partner_logos')->nullable()->after('philosophy_empower');
            $table->text('history_timeline')->nullable()->after('partner_logos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->dropColumn([
                'company_pt_name',
                'company_nib',
                'company_kbli',
                'philosophy_build',
                'philosophy_grow',
                'philosophy_scale',
                'philosophy_empower',
                'partner_logos',
                'history_timeline'
            ]);
        });
    }
};
