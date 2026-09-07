<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->json('benefits')->nullable();
            $table->json('use_cases')->nullable();
            $table->json('specifications')->nullable();
            $table->json('integrations')->nullable();
            $table->json('faq')->nullable();
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
