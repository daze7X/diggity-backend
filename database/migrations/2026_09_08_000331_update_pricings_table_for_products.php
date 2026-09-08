<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pricings', function (Blueprint $table) {
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade')->after('id');
            $table->string('pricing_type')->default('one_time')->after('product_id'); // subscription, one_time, bundle, custom
            $table->string('currency')->default('IDR')->after('pricing_type');
            $table->integer('minimum_quantity')->default(1)->after('currency');
            
            // Decimal tracking fields for commerce 
            $table->decimal('numeric_price', 15, 2)->nullable()->after('price'); // The calculation price
            $table->decimal('discount_percentage', 5, 2)->nullable()->after('numeric_price');
            $table->decimal('original_price', 15, 2)->nullable()->after('discount_percentage');
            $table->decimal('annual_price', 15, 2)->nullable()->after('original_price');
            $table->decimal('sale_price', 15, 2)->nullable()->after('annual_price');
            
            // Labels and toggles
            $table->string('pricing_label')->nullable()->after('sale_price');
            $table->string('cta_text')->nullable()->after('pricing_label');
            $table->string('license_type')->nullable()->after('cta_text'); // personal, commercial, etc
            $table->boolean('is_free_trial')->default(false)->after('license_type');
            $table->boolean('is_enterprise')->default(false)->after('is_free_trial');
            $table->boolean('contact_sales')->default(false)->after('is_enterprise');
            $table->string('pricing_status')->default('active')->after('contact_sales'); // active, draft, promotional, deprecated
        });
    }

    public function down(): void
    {
        Schema::table('pricings', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn([
                'product_id', 'pricing_type', 'currency', 'minimum_quantity',
                'numeric_price', 'discount_percentage', 'original_price', 'annual_price',
                'sale_price', 'pricing_label', 'cta_text', 'license_type',
                'is_free_trial', 'is_enterprise', 'contact_sales', 'pricing_status'
            ]);
        });
    }
};
