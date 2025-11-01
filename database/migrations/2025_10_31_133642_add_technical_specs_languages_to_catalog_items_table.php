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
        Schema::table('catalog_items', function (Blueprint $table) {
            $table->json('technical_specs_ru')->nullable()->after('images');
            $table->json('technical_specs_kk')->nullable()->after('technical_specs_ru');
            $table->json('technical_specs_en')->nullable()->after('technical_specs_kk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catalog_items', function (Blueprint $table) {
            $table->dropColumn(['technical_specs_ru', 'technical_specs_kk', 'technical_specs_en']);
        });
    }
};

