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
        Schema::table('priority_blocks', function (Blueprint $table) {
            // Добавляем внешний ключ, если его нет
            if (! Schema::hasColumn('priority_blocks', 'priority_id')) {
                $table->unsignedBigInteger('priority_id')->nullable()->after('id');

                // Устанавливаем внешний ключ на priorities.id
                $table->foreign('priority_id')
                    ->references('id')
                    ->on('priorities')
                    ->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('priority_blocks', function (Blueprint $table) {
            if (Schema::hasColumn('priority_blocks', 'priority_id')) {
                $table->dropForeign(['priority_id']);
                $table->dropColumn('priority_id');
            }
        });
    }
};
