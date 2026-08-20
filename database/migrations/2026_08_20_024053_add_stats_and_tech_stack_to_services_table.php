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
        Schema::table('services', function (Blueprint $table) {
            // Statistik dinamis per layanan: [{label: "Proyek Selesai", value: "200+"}, ...]
            $table->json('stats')->nullable()->after('plans');
            // Daftar teknologi/tools yang digunakan: ["Next.js", "React", "Laravel", ...]
            $table->json('tech_stack')->nullable()->after('stats');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['stats', 'tech_stack']);
        });
    }
};
