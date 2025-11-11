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
        Schema::create('priorities', function (Blueprint $table) {
            $table->id();
            $table->string('title_ru')->nullable();
            $table->string('title_kk')->nullable();
            $table->string('title_en')->nullable();
            $table->string('description_ru')->nullable();
            $table->string('description_kk')->nullable();
            $table->string('description_en')->nullable();
            $table->string('btnText_ru')->nullable();
            $table->string('btnText_kk')->nullable();
            $table->string('btnText_en')->nullable();

            $table->foreignId('main_id')->nullable()->constrained('mains')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('priorities');
    }
};
