<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('theme_preview_data', function (Blueprint $table) {
            $table->string('groom_full_name')->nullable()->change();
            $table->string('groom_short_name')->nullable()->change();
            $table->string('bride_full_name')->nullable()->change();
            $table->string('bride_short_name')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('theme_preview_data', function (Blueprint $table) {
            $table->string('groom_full_name')->nullable(false)->default('Mochammad Irfan')->change();
            $table->string('groom_short_name')->nullable(false)->default('Irfan')->change();
            $table->string('bride_full_name')->nullable(false)->default('Siti Salsabila')->change();
            $table->string('bride_short_name')->nullable(false)->default('Sasa')->change();
        });
    }
};
