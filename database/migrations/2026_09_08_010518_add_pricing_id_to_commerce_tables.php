<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->unsignedBigInteger('pricing_id')->nullable()->after('purchasable_id');
        });

        Schema::table('user_licenses', function (Blueprint $table) {
            $table->unsignedBigInteger('pricing_id')->nullable()->after('product_id');
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('pricing_id');
        });

        Schema::table('user_licenses', function (Blueprint $table) {
            $table->dropColumn('pricing_id');
        });
    }
};
