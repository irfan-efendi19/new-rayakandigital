<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitation_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->cascadeOnDelete();
            $table->string('event_title', 100);
            $table->date('event_date');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->boolean('is_until_finished')->default(false);
            $table->string('place_name', 150);
            $table->text('place_address');
            $table->text('google_maps_url')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['invitation_id', 'event_date', 'start_time'], 'idx_event_chronology');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitation_events');
    }
};
