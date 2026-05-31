<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('preview_data', function (Blueprint $table) {
            $table->id();
            $table->string('bride_name')->default('Ani Suryani');
            $table->string('groom_name')->default('Budi Santoso');
            $table->string('bride_nickname')->nullable();
            $table->string('groom_nickname')->nullable();
            $table->string('bride_parents')->nullable();
            $table->string('groom_parents')->nullable();
            $table->string('title')->default('Pernikahan Budi & Ani');
            $table->integer('event_date_offset_days')->default(60);
            $table->string('event_time')->default('10:00');
            $table->string('event_time_end')->default('14:00');
            $table->string('venue_name')->nullable();
            $table->text('venue_address')->nullable();
            $table->string('venue_maps_url')->nullable();
            $table->text('love_story')->nullable();
            $table->json('gallery_photos')->nullable();
            $table->string('gift_bank_name')->nullable();
            $table->string('gift_bank_account')->nullable();
            $table->string('gift_bank_holder')->nullable();
            $table->json('events')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('preview_data');
    }
};
