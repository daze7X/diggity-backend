<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'benefits')) {
                $table->json('benefits')->nullable();
            }
            if (!Schema::hasColumn('products', 'use_cases')) {
                $table->json('use_cases')->nullable();
            }
            if (!Schema::hasColumn('products', 'specifications')) {
                $table->json('specifications')->nullable();
            }
            if (!Schema::hasColumn('products', 'integrations')) {
                $table->json('integrations')->nullable();
            }
            if (!Schema::hasColumn('products', 'faq')) {
                $table->json('faq')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'benefits',
                'use_cases',
                'specifications',
                'integrations',
                'faq',
            ]);
        });
    }
};
