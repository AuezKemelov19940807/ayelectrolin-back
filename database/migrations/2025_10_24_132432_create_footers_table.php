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
        Schema::create('footers', function (Blueprint $table) {
            $table->id();
            $table->string('copy_ru')->nullable();
            $table->string('copy_kk')->nullable();
            $table->string('copy_en')->nullable();
            $table->string('privacy_policy_text_ru')->nullable();
            $table->string('privacy_policy_text_kk')->nullable();
            $table->string('privacy_policy_text_en')->nullable();
            $table->string('privacy_policy_link_ru')->nullable();
            $table->string('privacy_policy_link_kk')->nullable();
            $table->string('privacy_policy_link_en')->nullable();
            $table->string('cookie_policy_text_ru')->nullable();
            $table->string('cookie_policy_text_kk')->nullable();
            $table->string('cookie_policy_text_en')->nullable();
            $table->string('cookie_policy_link_ru')->nullable();
            $table->string('cookie_policy_link_kk')->nullable();
            $table->string('cookie_policy_link_en')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footers');
    }
};
