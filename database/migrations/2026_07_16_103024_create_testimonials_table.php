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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('client_name'); // Nama pemberi ulasan
            $table->string('company')->nullable(); // Nama perusahaan klien, misal: Tokopedia
            $table->string('avatar')->nullable(); // Foto klien
            $table->text('review'); // Isi ulasan/testimoni
            $table->integer('rating')->default(5); // Skor bintang 1-5
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
