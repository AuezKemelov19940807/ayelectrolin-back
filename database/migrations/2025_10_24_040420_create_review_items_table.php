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
        Schema::create('review_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('review_id')->constrained()->onDelete('cascade');
            $table->string('description_ru')->nullable();
            $table->string('description_kk')->nullable();
            $table->string('description_en')->nullable();
            $table->string('fullname_ru')->nullable();
            $table->string('fullname_kk')->nullable();
            $table->string('fullname_en')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_items');
    }
};
