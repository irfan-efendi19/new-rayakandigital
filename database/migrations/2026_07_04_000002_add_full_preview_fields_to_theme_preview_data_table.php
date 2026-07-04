<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('theme_preview_data', function (Blueprint $table) {
            $table->string('title')->nullable()->after('theme_id');
            $table->string('bride_photo_path')->nullable()->after('bride_mother_name');
            $table->string('groom_photo_path')->nullable()->after('bride_photo_path');

            $table->boolean('show_video')->nullable()->after('bg_music_path');
            $table->string('youtube_url')->nullable()->after('show_video');
            $table->string('youtube_video_id')->nullable()->after('youtube_url');
            $table->string('timezone')->nullable()->after('youtube_video_id');
            $table->unsignedSmallInteger('event_date_offset_days')->nullable()->after('timezone');
            $table->string('event_time')->nullable()->after('event_date_offset_days');
            $table->string('event_time_end')->nullable()->after('event_time');
            $table->string('venue_name')->nullable()->after('event_time_end');
            $table->text('venue_address')->nullable()->after('venue_name');
            $table->string('venue_maps_url')->nullable()->after('venue_address');

            $table->text('quote_content')->nullable()->after('venue_maps_url');
            $table->string('quote_source')->nullable()->after('quote_content');
            $table->text('love_story')->nullable()->after('quote_source');
            $table->json('stories')->nullable()->after('love_story');
            $table->json('gallery_photos')->nullable()->after('stories');
            $table->json('gift_banks')->nullable()->after('gallery_photos');
            $table->json('gift_ewallets')->nullable()->after('gift_banks');
            $table->json('events')->nullable()->after('gift_ewallets');
        });
    }

    public function down(): void
    {
        Schema::table('theme_preview_data', function (Blueprint $table) {
            $table->dropColumn([
                'title',
                'bride_photo_path',
                'groom_photo_path',
                'show_video',
                'youtube_url',
                'youtube_video_id',
                'timezone',
                'event_date_offset_days',
                'event_time',
                'event_time_end',
                'venue_name',
                'venue_address',
                'venue_maps_url',
                'quote_content',
                'quote_source',
                'love_story',
                'stories',
                'gallery_photos',
                'gift_banks',
                'gift_ewallets',
                'events',
            ]);
        });
    }
};
