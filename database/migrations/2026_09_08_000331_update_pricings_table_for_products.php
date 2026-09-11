<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pricings', function (Blueprint $table) {
            if (!Schema::hasColumn('pricings', 'product_id')) {
                $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade')->after('id');
            }
            if (!Schema::hasColumn('pricings', 'pricing_type')) {
                $table->string('pricing_type')->default('one_time')->after('product_id'); // subscription, one_time, bundle, custom
            }
            if (!Schema::hasColumn('pricings', 'currency')) {
                $table->string('currency')->default('IDR')->after('pricing_type');
            }
            if (!Schema::hasColumn('pricings', 'minimum_quantity')) {
                $table->integer('minimum_quantity')->default(1)->after('currency');
            }
            
            // Decimal tracking fields for commerce 
            if (!Schema::hasColumn('pricings', 'numeric_price')) {
                $table->decimal('numeric_price', 15, 2)->nullable()->after('price'); // The calculation price
            }
            if (!Schema::hasColumn('pricings', 'discount_percentage')) {
                $table->decimal('discount_percentage', 5, 2)->nullable()->after('numeric_price');
            }
            if (!Schema::hasColumn('pricings', 'original_price')) {
                $table->decimal('original_price', 15, 2)->nullable()->after('discount_percentage');
            }
            if (!Schema::hasColumn('pricings', 'annual_price')) {
                $table->decimal('annual_price', 15, 2)->nullable()->after('original_price');
            }
            if (!Schema::hasColumn('pricings', 'sale_price')) {
                $table->decimal('sale_price', 15, 2)->nullable()->after('annual_price');
            }
            
            // Labels and toggles
            if (!Schema::hasColumn('pricings', 'pricing_label')) {
                $table->string('pricing_label')->nullable()->after('sale_price');
            }
            if (!Schema::hasColumn('pricings', 'cta_text')) {
                $table->string('cta_text')->nullable()->after('pricing_label');
            }
            if (!Schema::hasColumn('pricings', 'license_type')) {
                $table->string('license_type')->nullable()->after('cta_text'); // personal, commercial, etc
            }
            if (!Schema::hasColumn('pricings', 'is_free_trial')) {
                $table->boolean('is_free_trial')->default(false)->after('license_type');
            }
            if (!Schema::hasColumn('pricings', 'is_enterprise')) {
                $table->boolean('is_enterprise')->default(false)->after('is_free_trial');
            }
            if (!Schema::hasColumn('pricings', 'contact_sales')) {
                $table->boolean('contact_sales')->default(false)->after('is_enterprise');
            }
            if (!Schema::hasColumn('pricings', 'pricing_status')) {
                $table->string('pricing_status')->default('active')->after('contact_sales'); // active, draft, promotional, deprecated
            }
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
