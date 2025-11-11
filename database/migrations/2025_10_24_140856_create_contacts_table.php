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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('ayelectrolin_logo')->nullable();
            $table->string('ayelectrolin_name_ru')->nullable();
            $table->string('ayelectrolin_name_kk')->nullable();
            $table->string('ayelectrolin_name_en')->nullable();
            $table->string('ayelectrolin_number')->nullable();
            $table->string('ayelectrolin_email')->nullable();
            $table->string('ayelectrolin_address_ru')->nullable();
            $table->string('ayelectrolin_address_kk')->nullable();
            $table->string('ayelectrolin_address_en')->nullable();


            $table->string('zere_construction_logo')->nullable();
            $table->string('zere_construction_name_ru')->nullable();
            $table->string('zere_construction_name_kk')->nullable();
            $table->string('zere_construction_name_en')->nullable();
            $table->string('zere_construction_number')->nullable();
            $table->string('zere_construction_email')->nullable();
            $table->string('zere_construction_address_ru')->nullable();
            $table->string('zere_construction_address_kk')->nullable();
            $table->string('zere_construction_address_en')->nullable();


            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();

            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
