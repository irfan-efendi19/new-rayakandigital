<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitation_stories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained('invitations')->onDelete('cascade');
            $table->string('story_date');
            $table->text('story_description');
            $table->integer('order_position')->default(0);
            $table->timestamps();
        });

        DB::table('invitations')
            ->whereNotNull('love_story')
            ->where('love_story', '!=', '')
            ->orderBy('id')
            ->each(function ($invitation) {
                DB::table('invitation_stories')->insert([
                    'invitation_id' => $invitation->id,
                    'story_date' => '',
                    'story_description' => $invitation->love_story,
                    'order_position' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitation_stories');
    }
};
