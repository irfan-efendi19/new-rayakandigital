<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->boolean('show_video')->default(false)->after('title');
            $table->string('youtube_url')->nullable()->after('show_video');
            $table->string('youtube_video_id', 50)->nullable()->after('youtube_url');
        });
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn(['show_video', 'youtube_url', 'youtube_video_id']);
        });
    }
};
