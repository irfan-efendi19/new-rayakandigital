<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('preview_data', function (Blueprint $table) {
            $table->string('cover_photo')->nullable()->after('title');
            $table->string('music_url')->nullable()->after('groom_nickname');
            $table->boolean('show_video')->default(false)->after('music_url');
            $table->string('youtube_url')->nullable()->after('show_video');
            $table->string('youtube_video_id', 50)->nullable()->after('youtube_url');
            $table->string('timezone', 50)->default('Asia/Jakarta')->after('venue_maps_url');
        });
    }

    public function down(): void
    {
        Schema::table('preview_data', function (Blueprint $table) {
            $table->dropColumn([
                'cover_photo',
                'music_url',
                'show_video',
                'youtube_url',
                'youtube_video_id',
                'timezone',
            ]);
        });
    }
};
