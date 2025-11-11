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
        Schema::create('seos', function (Blueprint $table) {
            $table->id();

            // Title
            $table->string('title_ru')->nullable();
            $table->string('title_kk')->nullable();
            $table->string('title_en')->nullable();

            // Open Graph title
            $table->string('og_title_ru')->nullable();
            $table->string('og_title_kk')->nullable();
            $table->string('og_title_en')->nullable();

            // Description
            $table->text('description_ru')->nullable();
            $table->text('description_kk')->nullable();
            $table->text('description_en')->nullable();

            // Open Graph description
            $table->text('og_description_ru')->nullable();
            $table->text('og_description_kk')->nullable();
            $table->text('og_description_en')->nullable();

            // Open Graph image
            $table->string('og_image')->nullable();

            // Twitter card type (summary, summary_large_image, etc.)
            $table->string('twitter_card')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seos');
    }
};
