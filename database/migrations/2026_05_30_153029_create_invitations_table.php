<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('bride_name');
            $table->string('groom_name');
            $table->date('event_date')->nullable();
            $table->time('event_time')->nullable();
            $table->string('venue_name')->nullable();
            $table->text('venue_address')->nullable();
            $table->string('venue_maps_url')->nullable();
            $table->string('cover_photo')->nullable();
            $table->text('love_story')->nullable();
            $table->enum('theme', ['elegant', 'modern', 'jawa'])->default('elegant');
            $table->enum('tier', ['free', 'silver', 'gold', 'platinum'])->default('free');
            $table->boolean('is_active')->default(true);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->index('slug');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
