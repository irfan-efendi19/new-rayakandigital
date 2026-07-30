<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            if (! Schema::hasColumn('invitations', 'use_custom_music')) {
                $table->boolean('use_custom_music')->default(false)->after('music_url');
            }
            if (! Schema::hasColumn('invitations', 'custom_music')) {
                $table->string('custom_music')->nullable()->after('use_custom_music');
            }
        });

        // Migrate existing data: set use_custom_music = true and copy music_url to custom_music
        // for invitations that already have a custom music uploaded
        DB::table('invitations')
            ->whereNotNull('music_url')
            ->where('music_url', '!=', '')
            ->update([
                'custom_music' => DB::raw('music_url'),
                'use_custom_music' => true,
            ]);
    }

    public function down(): void
    {
        DB::table('invitations')
            ->where('use_custom_music', true)
            ->update(['use_custom_music' => false]);

        Schema::table('invitations', function (Blueprint $table) {
            if (Schema::hasColumn('invitations', 'custom_music')) {
                $table->dropColumn('custom_music');
            }
            if (Schema::hasColumn('invitations', 'use_custom_music')) {
                $table->dropColumn('use_custom_music');
            }
        });
    }
};
