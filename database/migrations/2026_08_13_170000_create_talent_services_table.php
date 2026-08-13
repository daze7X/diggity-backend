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
        Schema::create('talent_services', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // 'headhunting', 'outsourcing'
            $table->string('title');
            $table->string('sub_title')->nullable();
            $table->text('description')->nullable();
            $table->json('process_tabs')->nullable(); // Array of process steps
            $table->json('faqs')->nullable(); // Array of FAQ items
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talent_services');
    }
};
