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
        Schema::create('pricings', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama Paket, misal: Basic, Premium, Custom
            $table->string('price'); // Harga Paket (bisa string biar fleksibel, misal: "Rp 5.000.000" atau "Contact Us")
            $table->string('period')->default('project'); // Periode: month, year, atau project
            $table->text('description')->nullable(); // Penjelasan singkat paket
            $table->json('features'); // Daftar benefit/fitur yang didapat (disimpan dalam bentuk array JSON)
            $table->boolean('is_popular')->default(false); // Penanda paket yang paling direkomendasikan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricings');
    }
};
