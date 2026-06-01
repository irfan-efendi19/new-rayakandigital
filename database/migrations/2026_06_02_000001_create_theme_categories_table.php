<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('theme_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::table('themes', function (Blueprint $table) {
            $table->foreignId('theme_category_id')
                ->nullable()
                ->after('id')
                ->constrained('theme_categories')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('themes', function (Blueprint $table) {
            $table->dropForeign(['theme_category_id']);
            $table->dropColumn('theme_category_id');
        });

        Schema::dropIfExists('theme_categories');
    }
};
