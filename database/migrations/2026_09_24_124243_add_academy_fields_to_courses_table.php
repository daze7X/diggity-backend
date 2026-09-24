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
        Schema::table('courses', function (Blueprint $table) {
            $table->string('type')->default('online_course')->after('slug');
            $table->decimal('original_price', 15, 2)->nullable()->after('price');
            $table->string('duration')->nullable()->after('original_price');
            $table->integer('total_students')->default(0)->after('duration');
            $table->decimal('rating', 3, 1)->default(5.0)->after('total_students');
            $table->integer('reviews_count')->default(0)->after('rating');
            $table->text('instructor_bio')->nullable()->after('instructor_title');
            $table->string('instructor_avatar')->nullable()->after('instructor_bio');
            $table->string('badge')->nullable()->after('image');
            $table->json('benefits')->nullable()->after('badge');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn([
                'type',
                'original_price',
                'duration',
                'total_students',
                'rating',
                'reviews_count',
                'instructor_bio',
                'instructor_avatar',
                'badge',
                'benefits'
            ]);
        });
    }
};
