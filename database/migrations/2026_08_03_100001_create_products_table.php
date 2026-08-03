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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->nullable();
            $table->decimal('price', 15, 2)->default(0.00);
            $table->string('billing_period')->default('one_time'); // one_time, monthly, yearly, custom
            $table->text('description')->nullable();
            $table->json('features')->nullable(); // List of key features/benefits
            $table->json('gallery')->nullable(); // Preview images/screenshots
            $table->text('license_info')->nullable(); // License type/terms info
            $table->string('version')->nullable()->default('1.0.0'); // Current software version
            $table->string('file_path')->nullable(); // Secure path to downloadable files (for digital marketplace items)
            $table->boolean('is_active')->default(true);
            $table->boolean('is_popular')->default(false);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
