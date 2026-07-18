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
        Schema::create('screen_presets', function (Blueprint $table) {
            $table->id();
            $table->string('name');                        // Nama Tema (contoh: "Midnight Luxury Gold")
            $table->string('slug')->unique();              // Identifier unik (contoh: "midnight-gold")
            $table->text('description')->nullable();
            $table->string('thumbnail_image')->nullable(); // Path foto preview preset
            $table->string('view_path');                   // Lokasi file blade (contoh: "screens.themes.midnight-gold")
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('screen_presets');
    }
};
