<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('theme_preview_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('theme_id')->constrained('themes')->onDelete('cascade');

            $table->string('groom_full_name')->default('Mochammad Irfan');
            $table->string('groom_short_name')->default('Irfan');
            $table->string('groom_father_name')->nullable();
            $table->string('groom_mother_name')->nullable();

            $table->string('bride_full_name')->default('Siti Salsabila');
            $table->string('bride_short_name')->default('Sasa');
            $table->string('bride_father_name')->nullable();
            $table->string('bride_mother_name')->nullable();

            $table->string('hero_image_path')->nullable();
            $table->string('bg_music_path')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('theme_preview_data');
    }
};
