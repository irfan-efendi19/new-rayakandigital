<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->boolean('show_rsvp')->default(true)->after('show_comments');
            $table->boolean('show_gallery')->default(true)->after('show_rsvp');
            $table->boolean('show_gift')->default(true)->after('show_gallery');
            $table->boolean('show_stories')->default(true)->after('show_gift');
            $table->boolean('show_countdown')->default(true)->after('show_stories');
            $table->boolean('show_event_detail')->default(true)->after('show_countdown');
            $table->boolean('show_quote')->default(true)->after('show_event_detail');
        });
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn([
                'show_rsvp',
                'show_gallery',
                'show_gift',
                'show_stories',
                'show_countdown',
                'show_event_detail',
                'show_quote',
            ]);
        });
    }
};
