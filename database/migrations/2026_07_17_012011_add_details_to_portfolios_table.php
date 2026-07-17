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
        Schema::table('portfolios', function (Blueprint $table) {
            $table->string('client')->nullable()->after('title');
            $table->string('duration')->nullable()->after('client');
            $table->text('strategy')->nullable()->after('solution');
            $table->text('execution')->nullable()->after('strategy');
            $table->text('result')->nullable()->after('execution');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropColumn(['client', 'duration', 'strategy', 'execution', 'result']);
        });
    }
};
