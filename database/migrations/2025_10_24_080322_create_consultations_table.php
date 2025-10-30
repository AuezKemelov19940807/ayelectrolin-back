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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();

            $table->string('title_ru')->nullable();
            $table->string('title_kk')->nullable();
            $table->string('title_en')->nullable();

            $table->string('phone_placeholder_ru')->nullable();
            $table->string('phone_placeholder_kk')->nullable();
            $table->string('phone_placeholder_en')->nullable();

            $table->string('name_placeholder_ru')->nullable();
            $table->string('name_placeholder_kk')->nullable();
            $table->string('name_placeholder_en')->nullable();

            $table->string('message_placeholder_ru')->nullable();
            $table->string('message_placeholder_kk')->nullable();
            $table->string('message_placeholder_en')->nullable();

            $table->string('btn_text_ru')->nullable();
            $table->string('btn_text_kk')->nullable();
            $table->string('btn_text_en')->nullable();

            $table->string('note_text_ru')->nullable();
            $table->string('note_text_kk')->nullable();
            $table->string('note_text_en')->nullable();

            $table->string('contact_info_text_ru')->nullable();
            $table->string('contact_info_text_kk')->nullable();
            $table->string('contact_info_text_en')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
